<?php
/**
 * Register basic autoloader that uses include path
 *
<<<<<<< HEAD
 * Copyright © 2016 Magento. All rights reserved.
=======
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
>>>>>>> 229eaabfb4fced7adf5a1b09486de2a513239a60
 * See COPYING.txt for license details.
 */
use Magento\Framework\Autoload\AutoloaderRegistry;
use Magento\Framework\Autoload\ClassLoaderWrapper;

/**
 * Shortcut constant for the root directory
 */
define('BP', dirname(__DIR__));

define('VENDOR_PATH', BP . '/app/etc/vendor_path.php');

if (!file_exists(VENDOR_PATH)) {
    throw new \Exception(
        'We can\'t read some files that are required to run the Magento application. '
         . 'This usually means file permissions are set incorrectly.'
    );
}

$vendorDir = require VENDOR_PATH;
$vendorAutoload = BP . "/{$vendorDir}/autoload.php";

/* 'composer install' validation */
if (file_exists($vendorAutoload)) {
    $composerAutoloader = include $vendorAutoload;
} else {
    throw new \Exception(
        'Vendor autoload is not found. Please run \'composer install\' under application root directory.'
    );
}

AutoloaderRegistry::registerAutoloader(new ClassLoaderWrapper($composerAutoloader));

// Sets default autoload mappings, may be overridden in Bootstrap::create
\Magento\Framework\App\Bootstrap::populateAutoloader(BP, []);
