LitGroupDnsBundle
=================

🚫 **(This project is no longer maintained.)**

This bundle integrates [React DNS][1] into the Symfony 2 environment.

[![Latest Stable Version](https://poser.pugx.org/litgroup/dns-bundle/v/stable.svg)](https://packagist.org/packages/litgroup/dns-bundle)
[![Total Downloads](https://poser.pugx.org/litgroup/dns-bundle/downloads.svg)](https://packagist.org/packages/litgroup/dns-bundle)
[![Latest Unstable Version](https://poser.pugx.org/litgroup/dns-bundle/v/unstable.svg)](https://packagist.org/packages/litgroup/dns-bundle)
[![License](https://poser.pugx.org/litgroup/dns-bundle/license.svg)](https://packagist.org/packages/litgroup/dns-bundle)

Master branch status:
[![Build Status](https://travis-ci.org/LitGroup/LitGroupDnsBundle.svg?branch=master)](https://travis-ci.org/LitGroup/LitGroupHttpClientBundle)



Installation
------------

Use [composer][2] to install _LitGroupDnsBundle_:

```json
"require": {
    "litgroup/dns-bundle": "1.0.x-dev"
}
```

Register bundle in the AppKernel:

```php
<?php // AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            // LitGroupEventLoopBundle should be registered first:
            new LitGroup\Bundle\EventLoopBundle\LitGroupEventLoopBundle(),
            new LitGroup\Bundle\DnsBundle\LitGroupDnsBundle(),
        ];
        // ...

        return $bundles;
    }

    // ...
}
```

Configuration
-------------

```yaml
lit_group_dns:
    nameserver: '8.8.8.8' // Nameserver IP address (required):
    cache: true           // Use cached DNS resolver (optional, default: false)
```

Usage
-----

Use `litgroup_dns.resolver` service to receive `React\Dns\Resolver\Resolver`.

See [React DNS][1] library documentation for more details.

License
-------
See details in the `Resources/meta/LICENSE`.

[1]: https://github.com/reactphp/dns
[2]: http://getcomposer.org
