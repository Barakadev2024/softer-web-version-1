<?php

/**
 
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);
use Encore\Admin\Facades\Admin;
Admin::js('/vendor/chartjs/dist/Chart.min.js');
Admin::favicon('/your/favicon/resources/images/favicon.png');
// include __DIR__.'/../vendor/laravel-admin-ext/chartjs/src/routes.php';
// use Encore\Admin\Form;
// use Encore\Admin\Grid;
// use Encore\Admin\Show;
// use Encore\Admin\Widgets\Tab;
// use Encore\Admin\Widgets\Box;
// use Encore\Admin\Widgets\Collapse;