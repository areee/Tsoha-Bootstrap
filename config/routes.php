<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/food', function() {
    HelloWorldController::food_list();
});

$routes->get('/food/1', function() {
    HelloWorldController::food_show();
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
