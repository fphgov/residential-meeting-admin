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

    $app->post('/admin/api/account/search', [
        // Jwt\Handler\JwtAuthMiddleware::class,
        // App\Middleware\UserMiddleware::class,
        App\Handler\Account\SearchHandler::class
    ], 'admin.api.account.search');
};
