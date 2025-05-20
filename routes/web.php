<?php

// routes/web.php

$router->get('/admin', 'AdminController@index');
$router->get('/admin/create', 'AdminController@create');
$router->post('/admin/store', 'AdminController@store');
$router->get('/admin/edit/{id}', 'AdminController@edit');
$router->post('/admin/update/{id}', 'AdminController@update');
$router->get('/admin/delete/{id}', 'AdminController@delete');
