<?php

/**
 * Registering an autoloader
 * @var Phalcon\Config $config
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->servicesDir,
    ]
)->register();
