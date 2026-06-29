# GitHub Setup Guide

This guide covers remote GitHub settings that are managed in the GitHub UI. Visit Temajuk uses `dev` as the primary development branch.

## Local GitHub Files

The repository includes:

- `.github/workflows/ci.yml`
- `.github/workflows/commitlint.yml`
- `.github/workflows/dependency-review.yml`
- `SECURITY.md`
- `docs/github-setup.md`

The local repository includes CI, commit validation, dependency change review, security policy documentation, and project documentation. Scheduled dependency-version automation is managed separately from the committed workflow files.

## Branches

- `dev`: Laravel application development branch.
- `design`: static website design reference.
- `dev_*`: personal development branches that can open pull requests into `dev`.

Keep static design reference files in `design`; implement application code in `dev`.

## GitHub Actions

The local workflows are:

- `CI`: runs the `quality` job for PRs into `dev` and pushes to `dev` or `dev_*`.
- `Commitlint`: runs the `commitlint` job for PRs into `dev`.
- `Dependency Review`: runs the `dependency-review` job for PRs into `dev` when GitHub supports Dependency Review for the repository.

Push the workflow files before enabling required status checks. GitHub only lets you require checks after they have run at least once.

## Branch Protection For `dev`

Open GitHub:

```text
Settings -> Branches -> Add branch protection rule
```

Use this rule:

- Branch name pattern: `dev`
- Require a pull request before merging: enabled
- Required approvals: `1`
- Dismiss stale pull request approvals when new commits are pushed: enabled
- Require review from Code Owners: enable when the team maintains `CODEOWNERS`
- Require conversation resolution before merging: enabled
- Require status checks to pass before merging: enabled
- Require branches to be up to date before merging: enabled
- Required checks:
    - `quality`
    - `commitlint`
    - `dependency-review` where repository settings support it and the check is passing
- Allow force pushes: disabled
- Allow deletions: disabled

Recommended merge settings:

- Enable squash merge.
- Disable merge commits if the team wants a cleaner history.
- Keep rebase merge disabled unless the team explicitly wants it.

## Branch Protection For `design`

Use a lighter rule:

- Branch name pattern: `design`
- Require pull request before merging: optional
- Allow force pushes: disabled
- Allow deletions: disabled

This branch is a design reference branch, not the Laravel development branch.

## Security Settings

Open:

```text
Settings -> Code security and analysis
```

Enable the security features supported by the repository plan:

- Dependency graph
- Dependabot alerts
- Secret scanning
- Push protection for secrets
- Code scanning default setup

Dependabot security updates and scheduled version updates can create dependency pull requests. Use reviewed pull requests for dependency changes, and keep alerting enabled for visibility where the repository plan supports it.

## Pull Request Expectations

Every pull request into `dev` should include:

- short summary,
- reason for the change,
- migration impact if any,
- UI screenshots if UI behavior changes,
- verification commands and results,
- confirmation that no secrets or generated dependency/build folders are included.

Commit messages must follow:

```text
type(context): message
```

## GitHub Projects

Use a simple project board if the team wants task tracking in GitHub:

- Backlog
- Ready
- In Progress
- Review
- Done

Recommended fields:

- Priority: High, Medium, Low
- Area: Backend, Frontend, CMS, Database, Tooling, Documentation
- Size: Small, Medium, Large
- Assignee
- Milestone

Keep project automation simple and reviewable.

## Suggested Labels

Create these labels:

- `type:bug`
- `type:feature`
- `type:task`
- `area:backend`
- `area:frontend`
- `area:cms`
- `area:database`
- `area:tooling`
- `area:documentation`
- `priority:high`
- `priority:medium`
- `priority:low`
- `status:blocked`
- `status:needs-review`

## Validating The Setup

After pushing these local files:

1. Open a pull request from a personal branch such as `dev_cahyo` into `dev`.
2. Confirm these checks appear:
    - `quality`
    - `commitlint`
    - `dependency-review` where repository settings support it
3. Confirm pull requests cannot be merged when a required check fails.
4. Confirm `SECURITY.md` appears in the repository security policy area.
5. Confirm branch protection blocks force pushes and branch deletion.

## Repository Automation Boundaries

These areas belong to separate deployment, release, or operations decisions:

- production deployment workflow,
- production GitHub Environment,
- production secrets,
- release automation,
- changelog automation,
- package publishing,
- multi-environment promotion workflow,
- scheduled Dependabot version update pull requests.
