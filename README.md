# Pimcore Monitoring
Fetch health state of your pimcore installation.

### Release Plan
| Release | Supported Pimcore Versions | Supported Symfony Versions | Release Date | Maintained     | Branch                                                                          |
|---------|----------------------------|----------------------------|--------------|----------------|---------------------------------------------------------------------------------|
| **4.x** | `^11.0`                    | `6.2`                      | --           | Feature Branch | master                                                                          |
| **3.x** | `^10.0`                    | `5.4`                      | 06.01.2022   | Unsupported    | [3.x](https://github.com/dachcom-digital/pimcore-monitoring/tree/3.x)           |
| **2.x** | `^5.0`, `^6.0`             | `3.4`, `^4.4`              | 31.08.2018   | Unsupported    | [2.x](https://github.com/dachcom-digital/pimcore-monitoring/tree/2.x)           |
| **1.x** | `^4.0`                     | --                         | 06.02.2017   | Unsupported    | [pimcore4](https://github.com/dachcom-digital/pimcore-monitoring/tree/pimcore4) |

## Installation

```json
"require" : {
    "dachcom-digital/monitoring" : "~4.0.0"
}
```

Add Bundle to `bundles.php`:
```php
return [
    MonitoringBundle\MonitoringBundle::class => ['all' => true],
];
```

### Install Routes
```yaml
# config/routes.yaml
monitoring:
    resource: '@MonitoringBundle/config/routing.yaml'
```

### Configuration

```yaml
# config/packages/monitoring.yaml
monitoring:
    api_code: 'YOUR_API_CODE'
```


## Fetch Data
```bash
curl --data "apiCode=YOUR_API_CODE" https://www.your-domain.tld/monitoring/fetch
```

## Available Checks
- Pimcore version and revision
- Installed Bundles
- Installed AreaBricks
- Available Users
- Failed logins

## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)
