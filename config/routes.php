<?php

declare(strict_types=1);

use Mezzio\Application;

return static function (
    Application $app,
): void {
    $app->get('/app/api/ping', App\Handler\PingHandler::class, 'app.api.ping');

    $app->post('/admin/api/login', [
        Jwt\Handler\TokenHandler::class,
    ], 'admin.api.login');

    $app->post('/admin/api/account/check', [
        App\Handler\Account\CheckHandler::class
    ], 'admin.api.account.check');
};
