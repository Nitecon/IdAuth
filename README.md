[![Build Status](https://travis-ci.org/Nitecon/Iap.png?branch=master)](https://travis-ci.org/Nitecon/Iap) [![Latest Stable Version](https://poser.pugx.org/nitecon/Iap/v/stable.png)](https://packagist.org/packages/nitecon/Iap) [![Coverage Status](https://coveralls.io/repos/Nitecon/Iap/badge.png?branch=master)](https://coveralls.io/r/Nitecon/Iap?branch=master)

PSR-2 Certified with build pass
===============================

WIP
===
The module now functional but needs a lot of work and unit tests

Iap
=====
Iap is designed to be a multi provider identity and authentication system.  Where as most modules
that are currently available only allow single authentication systems the aim is to provide, access
to many different authentication systems including Facebook / Github etc as additional providers.

Objectives of this module
=========================
  1. Provide User Authentication with multiple providers at the same time
  2. Provide multiple independent identity providers active at the same time
  3. Allow plugin based authentication (eg: Facebook) - Only takes 2 classes currently to create a plugin
  4. Native LDAP provider plugin for identity & authorization
  5. Native Zend TableAdapter provider plugin for identity & authorization
  6. Native Doctrine provider plugin for identity & authorization
  7. Role based authentication readily available by adding on ZfcRbac
  8. Collector module to show specific details on current user including currently signed in provider
  9. Allow password reset independently of each provider
  10. Allow updates to identity's on providers in an independent nature.
  11. Add dedicated storage for all providers (Default: Zend\Authentication\Storage\Session)
  12. Fall through authentication between all providers until a valid authentication attempt is found.
  13. Direct access to authentication provider by specifying the provider.
  14. Native roles array to allow for easy expansion to ZfcRbac
  15. Native Authentication Service that can be added communicated with directly and added to ZfcRbac.
