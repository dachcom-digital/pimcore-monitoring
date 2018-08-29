# Pimcore Monitoring

#### Requirements
* Pimcore 5.

## Installation
Use composer to require dachcom-digital/monitoring or add it manually:

```json
"require": {
    "dachcom-digital/monitoring" : "~2.0.0",
}  
```

Enable the service/extension in pimcore-backend.

Immediately create the configuration for this service containing the authentication key (must be alphanumeric, also don't use special characters which will be encoded by the browser):

```yaml
monitoring:
    api_key: 'putSomethingUniqueHere'
```

## Fetch Data
```php
GET /monitoring/fetch?secret=putSomethingUniqueHere
```

## Output
- Pimcore version
- Information about extensions
- Information about AreaBricks

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