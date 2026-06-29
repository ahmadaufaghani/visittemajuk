# Security Policy

## Supported Branches

The active development branch is `dev`. Security fixes should target `dev` unless the team defines a release branch policy.

The `design` branch is a static website design reference branch and should not contain Laravel application code, secrets, dependencies, deployment configuration, or generated backend files.

## Reporting a Vulnerability

Use private reporting channels for vulnerabilities, leaked credentials, and suspected secret exposure.

Report security issues through GitHub Security Advisories when the repository has advisories enabled:

```text
https://github.com/ahmadaufaghani/visittemajuk/security/advisories/new
```

When advisories are not available, contact a repository maintainer through the team's agreed private channel and include:

- affected area,
- impact,
- reproduction steps,
- relevant logs or screenshots with secrets removed,
- suggested mitigation if known.

## Secret Handling

- Never commit `.env`, credentials, API keys, database dumps, production configuration, or private service tokens.
- Rotate any credential immediately if it is accidentally committed or shared.
- Keep local development credentials separate from production credentials.
- Store production secrets only in an approved deployment workflow with assigned ownership.

## Dependency Security

Dependency updates are handled through reviewed pull requests into `dev`. The committed workflow set includes dependency change review for pull requests that modify dependency manifests or lock files.

Recommended GitHub security settings:

- enable Dependency graph,
- enable Dependabot alerts where the repository plan supports them,
- enable secret scanning and push protection where the repository plan supports them,
- review dependency changes through the `dependency-review` workflow when GitHub supports it for the repository.

Dependency updates should not be auto-merged without CI and human review.
