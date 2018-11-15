<?php
declare(strict_types=1);

use App\Auth;
use App\Calc;
use App\Application;
use App\Providers\AppProvider;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

date_default_timezone_set('Asia/Shanghai');
/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    $app = new Application(['app'=> 'rpc']);
    $app->register(new AppProvider());

    $container = $app->getContainer();
    $auth = $container[Auth::class];
    $error = $auth->check();
    if ($error) {
        echo $error;
        return;
    }
    $app->setClass(new Calc($app->getContainer()));
    $response = $app->handle();
    echo $response;
    return;
})();