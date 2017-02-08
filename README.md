# Pimcore Monitoring

## Installation
**Handcrafted Installation**   
1. Download Plugin  
2. Rename it to `Monitoring`  
3. Place it in your plugin directory  
4. Activate & install it through backend 

**Composer Installation**  
1. Add code below to your `composer.json`    
2. Activate & install it through backend

```json
"require" : {
    "dachcom-digital/monitoring" : "1.0.0",
}
```

## Fetch Data
```php
GET /plugin/Monitoring/watch-dog/fetch?secret=yourAuthKey
```

## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  