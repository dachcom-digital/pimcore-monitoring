# Pimcore Monitoring

#### Requirements
* Pimcore 5.

## Installation
:information_source: Please pay attention to the [upgrade notes](./UPGRADE.md).

Create the configuration for this service containing the authentication code (must be alphanumeric, also don't use special characters which will be encoded by the browser):
```yaml
# app/config/monitoring.yml
monitoring:
    api_code: 'putSomethingUniqueHere'
```
and add it to your project-config:
```yaml
# app/config/config.yml
imports:
    - { resource: monitoring.yml }
```
Use composer to require dachcom-digital/monitoring or add it manually:
```json
{
    "require": {
        "dachcom-digital/monitoring" : "~2.0.0"
    }
}  
```
Include routing:
```yaml
# app/config/routing.yml
monitoring:
    resource: "@MonitoringBundle/Resources/config/routing.yml"
```

Enable the service/extension in pimcore-backend.

## Fetch Data
```php
POST /monitoring/fetch

with body-parameter apiCode=putSomethingUniqueHere
```

## Output
- Pimcore version and revision
- Information about extensions
- Information about areabricks
- Securechecker output - this requires composer.lock in getProjectDir() (see [Pimcore\Kernel](https://pimcore.com/docs/api/master/Pimcore/Kernel.html)); defaults to []

```json
{
    "core": {
        "version": "5.3.0",
        "revision": 290
    },
    "extensions": [
        {
        "title": "I18nBundle",
        "version": "2.3.2",
        "identifier": "I18nBundle\\I18nBundle",
        "isEnabled": true
        },
        {
        "title": "ToolboxBundle",
        "version": "2.6.1",
        "identifier": "ToolboxBundle\\ToolboxBundle",
        "isEnabled": true
        }
    ],
    "bricks": {
        "accordion": {
            "description": "Toolbox Accordion / Tabs",
            "name": "Accordion",
            "isEnabled": true
        },
        "anchor": {
            "description": "Toolbox Anchor",
            "name": "Anchor",
            "isEnabled": true
        }
    },
    "security_check": {
        "symfony/symfony": {
            "version": "v3.4.12",
            "advisories": {
                "symfony/symfony/CVE-2018-14773.yaml": {
                    "title": "CVE-2018-14773: Remove support for legacy and risky HTTP headers",
                    "link": "https://symfony.com/blog/cve-2018-14773-remove-support-for-legacy-and-risky-http-headers",
                    "cve": "CVE-2018-14773"
                }
            }
        }
    }
}
```
## Check-Script
In the folder "check-script" you find a perl-script which you can use to check your instance of pimcore. We built it to be used in NAGIOS.
This script is "as is" - extend/change it for your own needs

```
perl pimcore-checker.pl --server=<server> [--level, --verbose, --help]

Parameters:
    --server        Protocol and domain of installation to check (e.g. https://solution.dachcom.com/)
optional:
    --level         minimum errorlevel to return, default is 1 (0: show all; 1: show critical and warning; 2: show critical only)
    --verbose, -v   additionally output gathered package-informations as json
    --help, -h      print this help
```

The script uses the configurationfile "config/versions.json" - the committed one is an example and needs to be configured by you.

The example "ToolboxBundle" can be duplicated for every bundle you use.

Substituted operands are:
<, >, ==, !=

where '==' is the default if not defined

Versions are compared using perl's string-comparison (see $SUBSTITUTED_OPERANDS in pimcore-checker.pl).


## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  