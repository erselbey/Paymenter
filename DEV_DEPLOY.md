# Dev Deployment: dev.getselfcloud.com

This repository includes `.github/workflows/dev-getselfcloud-deploy.yaml`.

Required GitHub Actions secrets:

- `DEV_GSC_HOST`: SSH hostname/IP for the dev server
- `DEV_GSC_USER`: SSH username
- `DEV_GSC_SSH_KEY`: Private key (PEM/OpenSSH) with deploy access
- `DEV_GSC_PORT`: SSH port (optional, defaults to `22`)
- `DEV_GSC_APP_PATH`: Absolute path to the app on server (example: `/opt/paymenter`)

Workflow behavior:

1. Installs PHP and Node dependencies
2. Builds frontend assets
3. Runs basic Laravel cache checks (`route:cache`, `view:cache`)
4. Connects to server over SSH
5. Pulls latest `master`, rebuilds containers, clears Laravel caches

Trigger options:

- Automatic on push to `master` for app/theme/config related paths
- Manual via GitHub Actions `workflow_dispatch`
