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

// käyttäjätoiminnot:
$routes->get('/login', function() {
    ChefController::login();
});
$routes->post('/login', function() {
    ChefController::handle_login();
});
$routes->post('/logout', function() {
    ChefController::logout();
});

$routes->get('/signup', function() {
    ChefController::signup();
});
$routes->post('/signup', function() {
    ChefController::handle_signup();
});

// nämä kesken:
// kirjautumis-/sessiotoiminnot:
//$routes->get('/login', function() {
//    SessionController::store();
//});
//
//$routes->post('/login', function() {
//    SessionController::handle_login();
//});
//
//$routes->post('/logout', function() {
//    SessionController::destroy();
//});
// käyttäjätoiminnot:
//$routes->get('/signup', function(){
//	UserController::create();
//});
//$routes->post('/signup', function(){
//	UserController::store();
//});
//$routes->get('/user', function(){
//	UserController::index();
//});
//$routes->get('/user/:id', function($id){
//	UserController::show($id);
//});
// hiekkalaatikko testausta varten:
$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
