<?php
declare(strict_types=1);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

date_default_timezone_set('Asia/Shanghai');
/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    $app = new \App\Application(['app'=> 'rpc']);
    $app->register(new \App\Providers\AppProvider());
    $app->setClass(new \App\Calc($app->getContainer()));
    $app->run();
})();