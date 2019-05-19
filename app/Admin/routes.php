<?php declare(strict_types=1);

use App\Admin\Admin;
use Illuminate\Routing\Router;

(new Admin)->registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/tournaments', 'TournamentController');
    $router->resource('/problems', 'ProblemController');
    $router->resource('/solutions', 'SolutionController');
});
