<?php

$routes->get('/', function() {
    FoodController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/food', function() {
    FoodController::index();
});

$routes->post('/food', function() {
    FoodController::store();
});

$routes->post('/food/new', function() {
    FoodController::create();
});

$routes->get('/food/:id', function($id) {
    FoodController::show($id);
});

$routes->get('/food/1/edit', function() {
    HelloWorldController::food_edit();
});

$routes->get('/recipe', function() {
    HelloWorldController::recipe_list();
});

$routes->get('/recipe/1', function() {
    HelloWorldController::recipe_show();
});

$routes->get('/recipe/1/edit', function() {
    HelloWorldController::recipe_edit();
});
