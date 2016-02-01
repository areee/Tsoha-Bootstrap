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

$routes->get('/recipe', function() {
    HelloWorldController::recipe_list();
});
