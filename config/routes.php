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
        Jwt\Handler\JwtAuthMiddleware::class,
        App\Middleware\UserMiddleware::class,
        App\Handler\Account\SearchHandler::class
    ], 'admin.api.account.search');

    $app->post('/admin/api/account/send', [
        Jwt\Handler\JwtAuthMiddleware::class,
        App\Middleware\UserMiddleware::class,
        App\Handler\Account\SendHandler::class
    ], 'admin.api.account.send');

    $app->post('/admin/api/account/print', [
        Jwt\Handler\JwtAuthMiddleware::class,
        App\Middleware\UserMiddleware::class,
        App\Handler\Account\PrintHandler::class
    ], 'admin.api.account.print');

    $app->post('/admin/api/account/reject', [
        Jwt\Handler\JwtAuthMiddleware::class,
        App\Middleware\UserMiddleware::class,
        App\Handler\Account\RejectHandler::class
    ], 'admin.api.account.reject');

    $app->get('/admin/api/stat/mails', [
        App\Middleware\StatisticsAccountMiddleware::class,
        App\Handler\Stat\GetMailHandler::class
    ], 'app.api.stat.mails');
};
