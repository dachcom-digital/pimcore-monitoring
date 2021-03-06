# Upgrade Notes
![upgrade](https://user-images.githubusercontent.com/700119/31535145-3c01a264-affa-11e7-8d86-f04c33571f65.png)  
***
After every update you should check the pimcore extension manager. Just click the "update" button to finish the bundle update.

#### Update from version 2.x to version 2.1.1
- fetch users
- fetch login errors
- fix security check

#### Update from version 2.0.2 to version 2.0.3
- added script (perl) for checking instance - useful for integration with NAGIOS etc. You need to set the acceptable packages yourself in the versions.json
- checked compatibility with sensiolabs/security-checker ~5.0

#### Update from version 2.0.1 to version 2.0.2
- fixed securechecker related stuff: if no composer.lock provided ([see readme](README.md)), securechecker returns []

#### Update from version 2.0.0 to version 2.0.1
- implemented Issue #1: Implement security:check
- requires Pimcore 5.1

#### Update to version 2.0.0 
- Version 2.x is for Pimcore ~5.0.0 (bundle), version 1.x is for Pimcore 4 (plugin)
