<?php
require_once 'vendor/autoload.php';

/** @var altorouter */
$router = new AltoRouter();


// map homepage

$router->map( 'GET', '/', function() { require 'home.php';});
$router->map( 'GET', '/categories/', function() { require 'categories.php';});
$router->map( 'GET', '/post/', function() { require 'post.php';});

// dynamic named route
// i:id = la clé id est un entier (i)
// a:slug = slug est une string
// map user details page
$router->map( 'GET', '/user/[i:id]/', function( $id ) {	require 'user.php';});

// regarde si une route matche dans les routes définies au-dessus
$match = $router->match();


// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    //appelle la fonction
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
