<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;
use App\Middleware\LoginMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

/**后台**/
Router::addGroup('/system', function () {
    /**登录**/
    Router::get('/login', 'App\Controller\Admin\LoginController@index');
    Router::get('/captchas','App\Controller\Admin\LoginController@captcha');
    Router::post('/login', 'App\Controller\Admin\LoginController@login');
    Router::post('/login/logout', 'App\Controller\Admin\LoginController@logout');
    /**首页**/
    Router::get('', 'App\Controller\Admin\IndexController@index');
    Router::get('/', 'App\Controller\Admin\IndexController@index');
    Router::get('/index', 'App\Controller\Admin\IndexController@index');

    /**个人信息**/
    Router::get('/admin/profile', 'App\Controller\Admin\AdminController@profile');
    Router::post('/admin/info', 'App\Controller\Admin\AdminController@info');
    Router::post('/admin/pwd', 'App\Controller\Admin\AdminController@pwd');

    /**个人信息**/
    Router::get('/admin/index', 'App\Controller\Admin\AdminController@index');
    Router::post('/admin/store', 'App\Controller\Admin\AdminController@store');
    Router::post('/admin/update', 'App\Controller\Admin\AdminController@update');
    Router::post('/admin/del', 'App\Controller\Admin\AdminController@del');

    /**菜单管理**/
	Router::get('/menu/index', 'App\Controller\Admin\MenuController@index');
	Router::post('/menu/store', 'App\Controller\Admin\MenuController@store');
	Router::post('/menu/update', 'App\Controller\Admin\MenuController@update');
	Router::post('/menu/del', 'App\Controller\Admin\MenuController@del');

    /**角色管理**/
    Router::get('/role/index', 'App\Controller\Admin\RoleController@index');
    Router::post('/role/store', 'App\Controller\Admin\RoleController@store');
    Router::post('/role/update', 'App\Controller\Admin\RoleController@update');
    Router::post('/role/del', 'App\Controller\Admin\RoleController@del');
    Router::get('/role/authorize', 'App\Controller\Admin\RoleController@authorize');
    Router::post('/role/auth', 'App\Controller\Admin\RoleController@auth');

    /**设置**/
	Router::get('/set/upload', 'App\Controller\Admin\SetController@upload');
	Router::post('/set/update', 'App\Controller\Admin\SetController@update');

},['middleware' => [LoginMiddleware::class,AuthMiddleware::class,CsrfMiddleware::class]]);

/**上传**/
Router::post('/common/img','App\Controller\CommonController@img');

Router::get('/408',function (){
	echo '408';
});
Router::get('/404',function (){
	echo '404';
});