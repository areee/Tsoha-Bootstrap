<?php

//function check_logged_in() {
//    BaseController::check_logged_in();
//}

$routes->get('/', function() {
    FoodController::index();
});

$routes->get('/food', function() {
    FoodController::index();
});

$routes->post('/food', function() {
    FoodController::store();
});

$routes->get('/food/new', function() {
    FoodController::create();
});

$routes->get('/food/:id', function($id) {
    FoodController::show($id);
});

$routes->get('/food/:id/edit', function($id) {
    FoodController::edit($id);
});
$routes->post('/food/:id/edit', function($id) {
    FoodController::update($id);
});

$routes->post('/food/:id/destroy', function($id) {
    FoodController::destroy($id);
});

$routes->get('/login', function() {
    ChefController::login();
});

$routes->post('/login', function() {
    ChefController::handle_login();
});

$routes->post('/logout', function() {
    ChefController::logout();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

//$routes->get('/login', function() {
//    HelloWorldController::login();
//});
//$routes->get('/food/1/edit', function() {
//    HelloWorldController::food_edit();
//});

$routes->get('/recipe', function() {
    HelloWorldController::recipe_list();
});

$routes->get('/recipe/1', function() {
    HelloWorldController::recipe_show();
});

$routes->get('/recipe/1/edit', function() {
    HelloWorldController::recipe_edit();
});
