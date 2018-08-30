# Upgrade Notes
![upgrade](https://user-images.githubusercontent.com/700119/31535145-3c01a264-affa-11e7-8d86-f04c33571f65.png)  
***
After every update you should check the pimcore extension manager. Just click the "update" button to finish the bundle update.

#### Update from Version 2.0.1 to Version 2.0.2
- **[BREAKING]**: Changed request method and parameter names
    - changed request method from GET to POST
    - changed parameter from 'secret' to 'apiCode'
    - changed configuration.yaml entry to 'api_code'

#### Update from Version 2.0.0 to Version 2.0.1
- update of the readme
- **[BREAKING]** removed 'data' key from result-set
