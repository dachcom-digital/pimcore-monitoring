# Upgrade Notes

## 4.1.0
- [LICENSE] Dual-License with GPL and Dachcom Commercial License (DCL) added

## Migrating from Version 3.x to Version 4.0

### Global Changes
- Recommended folder structure by symfony adopted
- [ROUTE] Route include changed from `@MonitoringBundle/Resources/config/routing.yml` to `@MonitoringBundle/config/routing.yaml`

### Deprecations
- `extensions.isEnabled` has been removed and was replaced by `extensions.isInstalled`
- Check Script has been removed
- `failed_logins` has been removed since pimcore now longer provide any logging files for that. If you still need it, you need to implement your own check and hook into the security monolog channel for example

### New Features
- It's now possible to add your own check. Just create a tagged `pimcore.monitoring.check` service and implement the `CheckInterface` interface

***

Monitoring 3.x Upgrade Notes: https://github.com/dachcom-digital/pimcore-monitoring/blob/3.x/UPGRADE.md
