<?php

require_once(ROOT . '/app/Components/Psr4AutoloaderClass.php');

    // instantiate the loader
    $loader = new \Components\Psr4AutoloaderClass();

    // register the autoloader
    $loader->register();

    // register the base directories for the namespace prefix
    $loader->addNamespace('Components', './app/Components');
    $loader->addNamespace('Core', './app/Core');
    $loader->addNamespace('Controllers', './app/Controllers');
    $loader->addNamespace('Models', './app/Models');
    // $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
