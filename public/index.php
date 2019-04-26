<?php
declare(strict_types=1);

use App\Calc;
use App\Application;
use App\Providers\AppProvider;

chdir(dirname(__DIR__));
date_default_timezone_set('Asia/Shanghai');

require 'vendor/autoload.php';

(function () {
    $app = new Application([
        'app'=> 'rpc',
        'auth' => [
            'enable' => true,
            'key' => '21334234',
            'algo' => 'sha1',
        ],
    ]);
    $app->register(new AppProvider());
    $app->setClass(new Calc());
    $app->run();
})();
