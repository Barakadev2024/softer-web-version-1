<?php
namespace App\Admin\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Encore\Admin\Facades\Admin;
use App\Admin\Controllers\CompanyController;
use App\Admin\Controllers\SalesController;
use App\Admin\Controllers\PurchaseController;
use App\Admin\Controllers\ExpenseController;
use App\Admin\Controllers\HomeController;
use App\Admin\Controllers\ChartController;
use App\Models\Chart;


Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('companies', 'CompanyController');
    $router->resource('sales', 'SalesController');
    $router->resource('purchases', 'PurchaseController');
    $router->resource('expenses', 'ExpenseController'); 

});
