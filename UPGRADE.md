# Upgrade Notes
![upgrade](https://user-images.githubusercontent.com/700119/31535145-3c01a264-affa-11e7-8d86-f04c33571f65.png)  
***
After every update you should check the pimcore extension manager. Just click the "update" button to finish the bundle update.

#### Update from version 2.0.2 to version 2.0.3
- updated upgrade notes

#### Update from version 2.0.1 to version 2.0.2
- **[BC BREAK]**
    - changed request method from GET to POST
    - changed request parameter from 'secret' to 'apiCode'
    - changed configuration.yaml entry to 'api_code'
- increased code consistency
- implemented [PackageVersionTrait](https://github.com/pimcore/pimcore/blob/master/lib/Extension/Bundle/Traits/PackageVersionTrait.php)

#### Update from version 2.0.0 to version 2.0.1
- **[BC BREAK]** removed 'data' key from result-set
- update of the readme

#### Update to version 2.0.0 
- Version 2.x is for Pimcore 5 (bundle), version 1.x is for Pimcore 4 (plugin)
