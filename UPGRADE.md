# Upgrade Notes

## Migrating from Version 2.x to Version 3.0
- PHP8 return type declarations added: you may have to adjust your extensions accordingly
- API code **must** be submitted via `POST`
- `SecurityChecker` has been [shut down](https://github.com/sensiolabs/security-checker). We cannot provide any alternative due to
  security reasons. You need to implement your own strategy 
  (use [security-checker-action](https://github.com/symfonycorp/security-checker-action) in your deployment action for example)

***

Monitoring 2.x Upgrade Notes: https://github.com/dachcom-digital/pimcore-monitoring/blob/2.x/UPGRADE.md
