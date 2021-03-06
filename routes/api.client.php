<?php

Route::group([
    'middleware' => [
        'api.client',
        'api.currency',
        'api.customer_groups',
        'api.locale',
        'api.tax'
    ],
    'prefix' => 'api/' . config('app.api_version', 'v1'),
    'namespace' => 'GetCandy\Api\Http\Controllers'
], function ($router) {
    /*
|--------------------------------------------------------------------------
| API Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Client routes for GetCandy
| These are READ ONLY routes
|
     */
// $router->get('channels', 'Channels\ChannelController@index');
    $router->get('channels/{id}', 'Channels\ChannelController@show');
    $router->get('collections', 'Collections\CollectionController@index');
    $router->get('collections/{id}', 'Collections\CollectionController@show');
    $router->get('categories/{id}', 'Categories\CategoryController@show');
    $router->get('products/{product}', 'Products\ProductController@show');
    $router->post('customers', 'Customers\CustomerController@store');
    $router->get('products', 'Products\ProductController@index');

    /**
     * Baskets
     */
    $router->get('baskets', 'Products\ProductController@index');
    $router->put('baskets/{id}/discounts', 'Baskets\BasketController@addDiscount');
    $router->delete('baskets/{id}/discounts', 'Baskets\BasketController@deleteDiscount');
    $router->put('baskets/{id}/user', 'Baskets\BasketController@putUser');
    $router->delete('baskets/{id}/user', 'Baskets\BasketController@deleteUser');
    $router->resource('baskets', 'Baskets\BasketController', [
        'except' => ['edit', 'create']
    ]);

    /**
     * Categories
     */
    $router->get('categories', 'Categories\CategoryController@index');

    /**
     * Countries
     */
    $router->get('countries', 'Countries\CountryController@index');

    /**
     * Currencies
     */
    $router->resource('currencies', 'Currencies\CurrencyController', [
        'except' => ['edit', 'create']
    ]);

    /**
     * Customers
     */
    $router->resource('customers', 'Customers\CustomerController', [
        'except' => ['index', 'edit', 'create', 'show']
    ]);

    /**
     * Orders
     */

    $router->post('orders/process', 'Orders\OrderController@process');
    $router->post('orders/{id}/expire', 'Orders\OrderController@expire');
    $router->put('orders/{id}/shipping/address', 'Orders\OrderController@shippingAddress');
    $router->put('orders/{id}/shipping/methods', 'Orders\OrderController@shippingMethod');
    $router->get('orders/{id}/shipping/methods', 'Orders\OrderController@shippingMethods');
    $router->put('orders/{id}/shipping/cost', 'Orders\OrderController@shippingCost');
    $router->put('orders/{id}/contact', 'Orders\OrderController@addContact');
    $router->put('orders/{id}/billing/address', 'Orders\OrderController@billingAddress');
    $router->resource('orders', 'Orders\OrderController', [
        'only' => ['store', 'show']
    ]);
    $router->get('orders/{id}/invoice', 'Orders\OrderController@invoice');

    /**
     * Payments
     */
    $router->get('payments/provider', 'Payments\PaymentController@provider');
    $router->get('payments/types', 'Payments\PaymentTypeController@index');

    $router->get('routes', 'Routes\RouteController@index');
    $router->get('routes/{slug}', [
        'uses' => 'Routes\RouteController@show'
    ])->where(['slug' => '.*']);


    $router->post('password/reset', 'Auth\ResetPasswordController@reset');
    $router->post('password/reset/request', 'Auth\ForgotPasswordController@sendResetLinkEmail');

    $router->get('search', 'Search\SearchController@search');
    $router->get('search/products', 'Search\SearchController@products');

    /**
     * Shipping
     */
    $router->get('shipping', 'Shipping\ShippingMethodController@index');


    $router->post('users', 'Users\UserController@store');
    $router->post('users/{userid}', 'Users\UserController@update');
});