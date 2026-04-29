#!/usr/bin/env node
import { createHash } from 'node:crypto';
import { execFileSync } from 'node:child_process';
import { existsSync, readFileSync, readdirSync, statSync } from 'node:fs';
import { join, relative } from 'node:path';

const root = process.cwd();
const configPath = process.env.DRIFT_GUARD_CONFIG || 'scripts/rolling-reno-drift-guard.config.json';
const config = JSON.parse(readFileSync(configPath, 'utf8'));
const strictContent = truthy(process.env.DRIFT_GUARD_STRICT_CONTENT);
const failOnWarnings = truthy(process.env.DRIFT_GUARD_FAIL_ON_WARNINGS);
const cacheBust = `drift-${process.env.GITHUB_SHA?.slice(0, 7) || 'local'}-${Date.now()}`;
const failures = [];
const warnings = [];

function truthy(value) {
  return ['1', 'true', 'yes', 'on'].includes(String(value || '').toLowerCase());
}

function logSection(title) {
  console.log(`\n## ${title}`);
}

function sha256(value) {
  return createHash('sha256').update(value).digest('hex');
}

function shouldExclude(relPath) {
  if (relPath === '.git' || relPath === '.gitignore') return true;
  if (relPath.startsWith('.git/') || relPath.startsWith('.github/') || relPath.startsWith('node_modules/')) return true;
  if (relPath.endsWith('.md')) return true;
  return false;
}

function walk(dir, acc = []) {
  for (const name of readdirSync(dir)) {
    const full = join(dir, name);
    const rel = relative(root, full).split('\\').join('/');
    if (shouldExclude(rel)) continue;
    const stat = statSync(full);
    if (stat.isDirectory()) walk(full, acc);
    else if (stat.isFile()) acc.push(rel);
  }
  return acc;
}

function localManifest() {
  const files = walk(root).sort();
  const manifest = new Map();
  for (const file of files) {
    manifest.set(file, sha256(readFileSync(join(root, file))));
  }
  return manifest;
}

function remoteManifest({ label, host, user, keyPath, themePath }) {
  if (!host || !user || !keyPath || !existsSync(keyPath)) {
    warnings.push(`${label}: SSH manifest skipped (set ${label.toUpperCase()}_SSH_HOST, ${label.toUpperCase()}_SSH_USER, ${label.toUpperCase()}_SSH_KEY_PATH).`);
    return null;
  }
  const remote = `${user}@${host}`;
  const script = `cd ${shellQuote(themePath)} && find . -type f ! -path './.git/*' ! -path './.github/*' ! -path './node_modules/*' ! -name '*.md' ! -name '.gitignore' -print0 | sort -z | xargs -0 sha256sum`;
  const output = execFileSync('ssh', ['-i', keyPath, '-o', 'StrictHostKeyChecking=no', remote, 'bash', '-lc', shellQuote(script)], { encoding: 'utf8', stdio: ['ignore', 'pipe', 'pipe'] });
  const manifest = new Map();
  for (const line of output.trim().split('\n').filter(Boolean)) {
    const match = line.match(/^([a-f0-9]{64})\s+\.\/(.+)$/);
    if (match) manifest.set(match[2], match[1]);
  }
  return manifest;
}

function expandHome(value) {
  if (!value) return '';
  return String(value).replace(/^~(?=$|\/)/, process.env.HOME || '~');
}

function shellQuote(value) {
  return `'${String(value).replaceAll("'", `'\\''`)}'`;
}

function compareManifests(label, local, remote) {
  if (!remote) return;
  let missing = 0;
  let changed = 0;
  let extra = 0;
  for (const [file, hash] of local) {
    if (!remote.has(file)) {
      missing++;
      failures.push(`${label}: deployed theme is missing ${file}`);
    } else if (remote.get(file) !== hash) {
      changed++;
      failures.push(`${label}: deployed theme hash differs for ${file}`);
    }
  }
  for (const file of remote.keys()) {
    if (!local.has(file)) {
      extra++;
      warnings.push(`${label}: deployed theme has extra file ${file}`);
    }
  }
  console.log(`${label}: ${local.size} local files checked; missing=${missing}, changed=${changed}, extra=${extra}`);
}

function targetFromEnv(label) {
  const upper = label.toUpperCase();
  const url = process.env[`${upper}_URL`];
  if (!url) return null;
  return {
    label,
    url: url.replace(/\/$/, ''),
    authUser: process.env[`${upper}_AUTH_USER`] || '',
    authPass: process.env[`${upper}_AUTH_PASS`] || '',
    sshHost: process.env[`${upper}_SSH_HOST`] || '',
    sshUser: process.env[`${upper}_SSH_USER`] || '',
    sshKeyPath: expandHome(process.env[`${upper}_SSH_KEY_PATH`] || process.env.SSH_KEY_PATH || ''),
    themePath: process.env[`${upper}_THEME_PATH`] || process.env.THEME_PATH || config.remoteThemePath,
  };
}

function configuredTargets() {
  const labels = (process.env.DRIFT_GUARD_TARGETS || 'prod,staging').split(',').map((s) => s.trim()).filter(Boolean);
  return labels.map(targetFromEnv).filter(Boolean);
}

async function fetchProbe(target, path) {
  const url = new URL(path, `${target.url}/`);
  url.searchParams.set('drift_check', cacheBust);
  const headers = { 'User-Agent': 'RollingRenoDriftGuard/1.0' };
  if (target.authUser || target.authPass) {
    headers.Authorization = `Basic ${Buffer.from(`${target.authUser}:${target.authPass}`).toString('base64')}`;
  }
  const res = await fetch(url, { headers, redirect: 'follow', signal: AbortSignal.timeout(20000) });
  const body = await res.text();
  return { target: target.label, path, url: url.href, status: res.status, size: Buffer.byteLength(body), body, hash: sha256(body) };
}

function markerList(path) {
  return [...(config.expectedMarkers?.all || []), ...(config.expectedMarkers?.[path] || [])];
}

function checkProbe(probe) {
  if (probe.status !== 200) {
    failures.push(`${probe.target} ${probe.path}: HTTP ${probe.status} (${probe.url})`);
  }
  if (probe.size < 1000) {
    failures.push(`${probe.target} ${probe.path}: suspiciously small response (${probe.size} bytes)`);
  }
  for (const marker of markerList(probe.path)) {
    if (!probe.body.toLowerCase().includes(String(marker).toLowerCase())) {
      failures.push(`${probe.target} ${probe.path}: missing expected marker ${JSON.stringify(marker)}`);
    }
  }
  if (/uncategorized/i.test(probe.body)) {
    warnings.push(`${probe.target} ${probe.path}: contains retired/undesired marker "Uncategorized"`);
  }
  console.log(`${probe.target} ${probe.path}: HTTP ${probe.status}, ${probe.size} bytes, sha256=${probe.hash.slice(0, 12)}`);
}

function compareUrlProbes(left, right) {
  const ratio = Number(config.urlSizeDeltaWarnRatio || 0.25);
  const byKey = new Map(left.map((p) => [p.path, p]));
  for (const probe of right) {
    const base = byKey.get(probe.path);
    if (!base) continue;
    const maxSize = Math.max(base.size, probe.size, 1);
    const deltaRatio = Math.abs(base.size - probe.size) / maxSize;
    if (base.hash !== probe.hash) {
      warnings.push(`${base.target} vs ${probe.target} ${probe.path}: rendered HTML hashes differ (${base.hash.slice(0, 12)} vs ${probe.hash.slice(0, 12)}). If theme hashes match, investigate WordPress content/options/menu/cache drift rather than syncing databases automatically.`);
    }
    if (deltaRatio > ratio) {
      const msg = `${base.target} vs ${probe.target} ${probe.path}: response size drift ${base.size} vs ${probe.size} bytes (${Math.round(deltaRatio * 100)}%). Likely content/options drift, not code-file drift.`;
      (strictContent ? failures : warnings).push(msg);
    }
    for (const marker of markerList(probe.path)) {
      const leftHas = base.body.toLowerCase().includes(String(marker).toLowerCase());
      const rightHas = probe.body.toLowerCase().includes(String(marker).toLowerCase());
      if (leftHas !== rightHas) {
        const msg = `${base.target} vs ${probe.target} ${probe.path}: marker ${JSON.stringify(marker)} presence differs (${base.target}=${leftHas}, ${probe.target}=${rightHas}).`;
        (strictContent ? failures : warnings).push(msg);
      }
    }
  }
}

logSection('Rolling Reno deploy drift guard');
console.log(`Config: ${configPath}`);
console.log(`Mode: content drift is ${strictContent ? 'blocking' : 'warning-only'}; warnings ${failOnWarnings ? 'fail' : 'do not fail'} the run.`);

const local = localManifest();
console.log(`Local deploy manifest: ${local.size} files at ${process.env.GITHUB_SHA || 'local checkout'}`);

logSection('Theme file parity');
const targets = configuredTargets();
if (targets.length === 0) {
  failures.push('No URL targets configured. Set PROD_URL and/or STAGING_URL.');
}
for (const target of targets) {
  const manifest = remoteManifest({ label: target.label, host: target.sshHost, user: target.sshUser, keyPath: target.sshKeyPath, themePath: target.themePath });
  compareManifests(target.label, local, manifest);
}

logSection('URL and marker probes');
const probesByTarget = new Map();
for (const target of targets) {
  const probes = [];
  for (const path of config.paths || ['/']) {
    try {
      const probe = await fetchProbe(target, path);
      checkProbe(probe);
      probes.push(probe);
    } catch (error) {
      failures.push(`${target.label} ${path}: fetch failed - ${error.message}`);
    }
  }
  probesByTarget.set(target.label, probes);
}

if (probesByTarget.size >= 2) {
  logSection('Content/options drift signals');
  const [firstLabel, secondLabel] = [...probesByTarget.keys()];
  compareUrlProbes(probesByTarget.get(firstLabel), probesByTarget.get(secondLabel));
  console.log(`Compared ${firstLabel} ↔ ${secondLabel} response sizes and marker presence. HTML hash differences are expected when WordPress content/options differ; use warnings below to decide if content/options need manual reconciliation.`);
}

if (warnings.length) {
  logSection('Warnings / non-blocking drift signals');
  for (const warning of warnings) console.log(`⚠️ ${warning}`);
}
if (failures.length) {
  logSection('Failures / action required');
  for (const failure of failures) console.log(`❌ ${failure}`);
  process.exitCode = 1;
} else if (failOnWarnings && warnings.length) {
  process.exitCode = 1;
} else {
  logSection('Result');
  console.log('✅ Drift guard completed. Code-current checks passed; review warnings for content/options drift signals. No DB sync attempted.');
}
