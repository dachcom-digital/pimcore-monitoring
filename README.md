# Pimcore Monitoring

#### Requirements
* Pimcore 5.

## Installation
:information_source: Please pay attention to the [upgrade notes](./UPGRADE.md)

Use composer to require dachcom-digital/monitoring or add it manually:

```json
"require": {
    "dachcom-digital/monitoring" : "~2.0.0",
}  
```

Create the configuration for this service containing the authentication code (must be alphanumeric, also don't use special characters which will be encoded by the browser):

```yaml
# app/config/monitoring.yml
monitoring:
    api_code: 'putSomethingUniqueHere' 
```

Include routing
```json
# app/config/routing.yml
_monitoring:
    resource: "@MonitoringBundle/Resources/config/routing.yml"
```

Enable the service/extension in pimcore-backend.

## Fetch Data
```php
POST /monitoring/fetch

with body-parameter apiCode=putSomethingUniqueHere
```

## Output
- Pimcore version
- Information about extensions
- Information about areabricks

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
        },
        ...
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
        },
    ...
}
```
## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  