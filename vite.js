import { createServer, build } from 'vite';
import { existsSync, readdirSync } from 'node:fs';
import path from 'path';

function getBuildableThemes() {
  const themesRoot = path.resolve('themes');
  return readdirSync(themesRoot, { withFileTypes: true })
    .filter((entry) => entry.isDirectory())
    .map((entry) => entry.name)
    .filter((themeName) =>
      existsSync(path.join(themesRoot, themeName, 'vite.config.js')),
    );
}

async function dev(theme = 'default') {
  const server = await createServer({
    configFile: path.join('themes', theme, 'vite.config.js'),
  });
  await server.listen();
}

async function buildTheme(theme) {
  await build({
    configFile: path.join('themes', theme, 'vite.config.js'),
  });
}

async function buildAllThemes() {
  const themes = getBuildableThemes();

  for (const theme of themes) {
    await buildTheme(theme);
  }
}

async function main() {
  const command = process.argv[2];

  if (command === 'dev') {
    await dev(process.argv[3] ?? 'default');
    return;
  }

  if (!command || command === 'all') {
    await buildAllThemes();
    return;
  }

  await buildTheme(command);
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
