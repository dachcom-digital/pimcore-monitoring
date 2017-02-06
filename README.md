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
    "dachcom-digital/pimcore-monitoring" : "1.0.0",
}
```

## Fetch Data

```php
GET /plugin/Monitoring/WatchDog/fetch?secret=yourAuthKey
```