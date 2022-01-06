# Pimcore Monitoring
Fetch health state of your pimcore installation.

### Release Plan
| Release | Supported Pimcore Versions        | Supported Symfony Versions | Release Date | Maintained     | Branch     |
|---------|-----------------------------------|----------------------------|--------------|----------------|------------|
| **3.x** | `^10.0`                           | `5.4`                      | 06.01.2022   | Feature Branch | master     |
| **2.x** | `^5.0`, `^6.0`                    | `3.4`, `^4.4`              | 31.08.2018   | Unsupported    | [1.x](https://github.com/dachcom-digital/pimcore-monitoring/tree/2.x) |
| **1.x** | `^4.0`                            | --                         | 06.02.2017   | Unsupported    | [pimcore4](https://github.com/dachcom-digital/pimcore-monitoring/tree/pimcore4) |

## Installation

```json
"require" : {
    "dachcom-digital/monitoring" : "~3.0.0"
}
```

- Execute: `$ bin/console pimcore:bundle:enable MonitoringBundle`

### Install Routes
```yaml
# config/routes.yaml
monitoring:
    resource: '@MonitoringBundle/Resources/config/routing.yml'
```

### Configuration

```yaml
# config/monitoring.yml
monitoring:
    api_code: 'YOUR_API_CODE'
```


## Fetch Data
```bash
curl --data "apiCode=YOUR_API_CODE" https://www.your-domain.tld/monitoring/fetch
```

## Available Output
- Pimcore version and revision
- Installed Bundles
- Installed AreaBricks
- Available Users
- Failed logins

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

The script uses the configuration file "config/versions.json" - the committed one is an example and needs to be configured by you.

The example "ToolboxBundle" can be duplicated for every bundle you use.

Substituted operands are:
<, >, ==, !=

where '==' is the default if not defined

Versions are compared using perl's string-comparison (see $SUBSTITUTED_OPERANDS in pimcore-checker.pl).

## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)
