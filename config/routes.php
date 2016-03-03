<?php

// juuri/etusivu:
$routes->get('/', function() {
    FoodController::index();
});

// ruokakomeron toiminnot:
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

// reseptipankin toiminnot:
$routes->get('/recipe', function() {
    RecipeController::index();
});

$routes->post('/recipe', function() {
    RecipeController::store();
});

$routes->get('/recipe/new', function() {
    RecipeController::create();
});

$routes->get('/recipe/:id', function($id) {
    RecipeController::show($id);
});

$routes->get('/recipe/:id/edit', function($id) {
    RecipeController::edit($id);
});
$routes->post('/recipe/:id/edit', function($id) {
    RecipeController::update($id);
});

$routes->post('/recipe/:id/destroy', function($id) {
    RecipeController::destroy($id);
});

// käyttäjien hallinta:
$routes->get('/chef', function() {
    ChefController::index();
});

$routes->post('/chef', function() {
    ChefController::store();
});

$routes->get('/chef/new', function() { //ikään kuin signup
    ChefController::create();
      //  HelloWorldController::register();
});

$routes->get('/chef/:id', function($id) {
    ChefController::show($id);
});

$routes->get('/chef/:id/edit', function($id) {
    ChefController::edit($id);
});
$routes->post('/chef/:id/edit', function($id) {
    ChefController::update($id);
});

$routes->post('/chef/:id/destroy', function($id) {
    ChefController::destroy($id);
});

// sisään- ja uloskirjautuminen:
$routes->get('/login', function() {
    ChefController::login();
});
$routes->post('/login', function() {
    ChefController::handle_login();
});
$routes->post('/logout', function() {
    ChefController::logout();
});

// hiekkalaatikko testausta varten:
$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

//$routes->get('/rek', function() {
//    HelloWorldController::register();
//});
