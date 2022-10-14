# HabitatSeven’s source code for the RiskProfiler website

This git repository is a slightly modified mirror of the RiskProfiler WordPress git reposiory developed and maintained by HabitatSeven.

## Changes from H7’s original repo

* site/wp-config.php: This was changed to a symbolic link, to be linked with ../wp-config.php that is generated from wp-config-docker.php.
* Changes from upstream site/wp-config.php may either go into wp-config-docker.php, or sometimes to `.env` (e.g. change to `DB_NAME`).
* Addition of a GitHub Actions workflow that synchronizes with H7’s original repo

## Troubleshooting

```bash
LAST_SYNC_UPSTREAM_REF=$(git tag -l --format='%(contents)' last-sync-upstream-ref)

echo "$LAST_SYNC_UPSTREAM_REF"
git show "$LAST_SYNC_UPSTREAM_REF"

UPSTREAM_MAIN_REF="$(git rev-parse --verify upstream/main)"

git cherry-pick -S "$LAST_SYNC_UPSTREAM_REF"..upstream/main

git tag -a -f -m "$UPSTREAM_MAIN_REF" last-sync-upstream-ref
