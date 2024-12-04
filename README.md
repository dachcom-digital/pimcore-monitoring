# Pimcore Monitoring
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Software License](https://img.shields.io/badge/license-DCL-white.svg?style=flat-square&color=%23ff5c5c)](LICENSE.md)

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
    "dachcom-digital/monitoring" : "~4.1.0"
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

## Create Custom Check
Create a tagged `pimcore.monitoring.check` service and implement the `CheckInterface` interface.

## Available Checks
- Pimcore version and revision
- Installed Bundles
- Installed AreaBricks
- Available Users

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)

## License
**DACHCOM.DIGITAL AG**, Löwenhofstrasse 15, 9424 Rheineck, Schweiz  
[dachcom.com](https://www.dachcom.com), dcdi@dachcom.ch  
Copyright © 2024 DACHCOM.DIGITAL. All rights reserved.  

For licensing details please visit [LICENSE.md](LICENSE.md)  