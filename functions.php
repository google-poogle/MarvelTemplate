<?php

/* подключение стилей и скриптов */
add_action( 'wp_enqueue_scripts', function(){

	wp_enqueue_style( 'open-sans-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,600,700,800' );
	wp_enqueue_style( 'playfair-font', 'https://fonts.googleapis.com/css?family=Playfair+Display' );

	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/vendor/bootstrap.min.css' );
	wp_enqueue_style( 'dl-icon', get_stylesheet_directory_uri() . '/assets/css/vendor/dl-icon.css' );
	wp_enqueue_style( 'fa', get_stylesheet_directory_uri() . '/assets/css/vendor/font-awesome.css' );
	wp_enqueue_style( 'helper', get_stylesheet_directory_uri() . '/assets/css/helper.min.css' );
	wp_enqueue_style( 'plugins', get_stylesheet_directory_uri() . '/assets/css/plugins.css' );
	wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), time() );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', 'jquery', null, true );
	wp_enqueue_script( 'plugins', get_stylesheet_directory_uri() . '/assets/js/plugins.js', 'jquery', null, true );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array(), time(), true );

});


/* регистрация меню */

register_nav_menus(
	array(
		'head_menu' => 'Меню в шапке',
		'foot_1' => 'Футер 1: Каталог',
		'foot_2' => 'Футер 2: Страницы',
		'foot_3' => 'Футер 3: Товары',
	)
);
