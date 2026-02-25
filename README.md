# Pimcore Monitoring

***

> [!IMPORTANT]
> This bundle will **not** be compatible with Pimcore 12 or any future Pimcore versions.
>
> For all future development, updates, and documentation, please refer to [opendxp.io](https://www.opendxp.io):
>
> - Access the latest info here: [https://www.opendxp.io/en/bundles](https://www.opendxp.io/en/bundles)  
> - Migration of Dachcom Digital Bundles: [https://www.opendxp.io/en/dachcom-bundles](https://www.opendxp.io/en/dachcom-bundles)
>
> **Note:** We are open to partnerships for those interested in porting this bundle to future versions.
> 
> For inquiries, please contact: dcdi@dachcom.ch

***

[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Software License](https://img.shields.io/badge/license-DCL-white.svg?style=flat-square&color=%23ff5c5c)](LICENSE.md)

Fetch health state of your pimcore installation.

### Release Plan
| Release | Supported Pimcore Versions | Supported Symfony Versions | Release Date | Maintained     | Branch                                                                          |
|---------|----------------------------|----------------------------|--------------|----------------|---------------------------------------------------------------------------------|
| **4.x** | `^11.0`                    | `6.4`                      | 22.09.2023   | Feature Branch | master                                                                          |
| **3.x** | `^10.0`                    | `5.4`                      | 06.01.2022   | Unsupported    | [3.x](https://github.com/dachcom-digital/pimcore-monitoring/tree/3.x)           |
| **2.x** | `^5.0`, `^6.0`             | `3.4`, `^4.4`              | 31.08.2018   | Unsupported    | [2.x](https://github.com/dachcom-digital/pimcore-monitoring/tree/2.x)           |
| **1.x** | `^4.0`                     | --                         | 06.02.2017   | Unsupported    | [pimcore4](https://github.com/dachcom-digital/pimcore-monitoring/tree/pimcore4) |

## Installation

```json
"require" : {
    "dachcom-digital/monitoring" : "~4.4.0"
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

## Fetch Data By Check
```bash
curl --data "apiCode=YOUR_API_CODE" https://www.your-domain.tld/monitoring/fetch?filter=core,heartbeat
```

## Create Custom Check
Create a tagged `pimcore.monitoring.check` service and implement the `CheckInterface` interface.

## Available Checks
- Pimcore version and revision
- PHP (version, memory_limit and more)
- Kernel (environment, debug)
- Installed Bundles
- Installed AreaBricks
- Available Users

***

## Modules

### Email Log Module

```bash
monitoring:
    modules:
        email_log: true # disabled by default
```

```bash
curl --data "apiCode=YOUR_API_CODE" https://www.your-domain.tld/monitoring/fetch-email-log
```

#### Params
- `onlyErrors`: only fetch logs with errors (Default `false`)
- `startingFrom`: only fetch logs newer than `Y-m-d H:i:s`  (Default `null`)
- `limit`: limit log response (Default `100`)

### Heartbeat Module
This module provides a lightweight "heartbeat" mechanism to monitor the execution of periodic maintenance tasks. 
It helps verify that both the system **cronjob** and the **Symfony Messenger queue** are functioning correctly.

This heartbeat check:

- Confirms that the cronjob is triggering as expected.
- Confirms that the Messenger worker is actively processing jobs.
- Optionally indicates the **duration or load** of the maintenance task by analyzing time deltas between executions.

```bash
monitoring:
    modules:
        heartbeat: true # disabled by default
```

This will also add a check `hearbeat`.

***

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)

## License
**DACHCOM.DIGITAL AG**, Löwenhofstrasse 15, 9424 Rheineck, Schweiz  
[dachcom.com](https://www.dachcom.com), dcdi@dachcom.ch  
Copyright © 2025 DACHCOM.DIGITAL. All rights reserved.  

For licensing details please visit [LICENSE.md](LICENSE.md)  