<?php
require_once  ROOT.'/Application/Components/Psr4AutoloaderClass.php';

// instantiate the loader
     $loader = new \Psr4AutoloaderClass;

     // register the autoloader
     $loader->register();

     // register the base directories for the namespace prefix
     $loader->addNamespace('Application/Components/', './Application/Components/Router');
    // $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
