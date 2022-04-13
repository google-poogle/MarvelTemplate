<?php
/* подключение стилей и скриптов */
add_action( 'wp_enqueue_scripts', function(){

//	wp_enqueue_style( 'open-sans-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,600,700,800' );
//	wp_enqueue_style( 'playfair-font', 'https://fonts.googleapis.com/css?family=Playfair+Display' );

	wp_enqueue_style( 'base-css', get_stylesheet_directory_uri() . '/assets/css/base.css' );
	wp_enqueue_style( 'header-css', get_stylesheet_directory_uri() . '/assets/css/header.css' );
	wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/assets/css/main.css' );
	//wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), time() );

	wp_enqueue_script( 'jquery' );
//	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', 'jquery', null, true );
//	wp_enqueue_script( 'plugins', get_stylesheet_directory_uri() . '/assets/js/plugins.js', 'jquery', null, true );
//	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array(), time(), true );
	wp_deregister_style( 'woocommerce-general' );
	wp_deregister_style( 'woocommerce-layout' ); 
	wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
});

///подключим фильтр вывода подкатегорий
require get_template_directory() . '/inc/class_widget_category_list.php';
///подключим функции ajax
require get_template_directory() . '/inc/ajax_filter.php';
/// подключитм свою пагинацию
require get_template_directory() . '/inc/pagination.php';
//  Добавим размер миниатюры
add_image_size( 'product_thumbs', 228, 190, true );
// активация темы
add_theme_support( 'woocommerce' ); 
/* регистрация меню */
register_nav_menus(
	array(
		'head_menu' => 'Меню в шапке',
		'foot_1' => 'Футер 1: Каталог',
		'foot_2' => 'Футер 2: Страницы',
		'foot_3' => 'Футер 3: Товары',
	)
);



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function true_register_wp_sidebars() {
 
	/* В боковой колонке - первый сайдбар */
	// стили оформления виджетов задаем тут
	register_sidebar(
		array(
			'id' => 'ajax_filter_bar', // уникальный id
			'name' => 'Ajax фильтры', // название сайдбара
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<section><div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div></section>',
			'before_title' => '<div class="widget-title widgettitle" itemprop="name">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</div>'
		)
	);
 
	/* В подвале - второй сайдбар */
	register_sidebar(
		array(
			'id' => 'standart_bar',
			'name' => 'Стандарный sidebar',
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
			'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title widgettitle">',
			'after_title' => '</div>'
		)
	);
}
 
add_action( 'widgets_init', 'true_register_wp_sidebars' );


// выведем свой сайдбар через хук
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_sidebar', 'standart_sidebar', 10 );
	function standart_sidebar() {
	get_sidebar( 'shop' );
	}

// отвязываем стандартную пагинацию чтобы привязать свою
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
// привязваем свою функцию
add_action( 'woocommerce_after_shop_loop', 'marvel_pagination', 10);

/*** добавляем обертку к сортивке и выводу количества товаров */
add_action ( 'woocommerce_before_shop_loop' ,  function(){ echo '<div class="sort__wrapper">'; },15);
add_action ( 'woocommerce_before_shop_loop' ,  function(){ echo '</div>';},35);

//function marvel_paginayion() {}
/// отключаем хлебные крошки
add_filter( 'woocommerce_breadcrumb_defaults', 'my_breadcrumbs_delimiter');
function my_breadcrumbs_delimiter($args) {
  $args['delimiter'] = ' / ';
  return $args;
}

// Отвязываем функции от хуков
add_action('init','removeOldFunction');
function removeOldFunction(){
// вывод тегов перед хлебными крошками
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
}




remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );



add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 15);
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15);

/** фильтр на изменения вывода плашки скидка/нет в наличии/хит **/
function filter_woocommerce_sale_flash( $span_class_onsale____sale_woocommerce_span, $post, $product ) { 

	  $product_published = $product->get_date_created(); // получим дату создания продукта
	  $timeLeft = time() - 86400 * 5;
	//  if ( $product->is_type( 'Grouped' )) { return 'вариативный товар'; }
//print $product->is_type( 'Grouped' );
	 if ($product->is_in_stock()) : 
		if( $product->is_on_sale() && $product->get_type() != 'grouped' ) :
			$id = $product->id;
			$price = get_post_meta($id,'_price', true);
			$price_r = get_post_meta($id,'_regular_price', true);
			$percentage = round( ( ( $price_r - $price ) / $price_r ) * 100 );
			return '<div class="product-badge discount">Скидка '.$percentage.'%</div>';
		elseif( $product->is_featured() ) : 
			return '<div class="product-badge hot">Хит продаж</div>';
		elseif(  $timeLeft < $product_published->getTimestamp() ) :
			return '<div class="product-badge new">Новинка</div>';
		endif; 
		else : 
		return '<div class="product-badge stop">Нет в наличии</div>';
	endif; 
  }; 
  add_filter( 'woocommerce_sale_flash', 'filter_woocommerce_sale_flash', 10, 3 );



  
/// тестируем работу сортировки
//add_filter( 'woocommerce_get_catalog_ordering_args', 'truemisha_random_order' );
 
function truemisha_random_order( $args ) {
 
	$args['orderby'] = 'rand';
	return $args;
 
}

//Чао jq-mirate
add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

function remove_jquery_migrate( $scripts ) {

	if ( empty( $scripts->registered['jquery'] ) || is_admin() ) {
		return;
	}

	$deps = & $scripts->registered['jquery']->deps;

	$deps = array_diff( $deps, [ 'jquery-migrate' ] );
}

// отключает какие-то скрипты
add_action('wp_footer','wooexperts_remove_block_data',0);
add_action('admin_enqueue_scripts','wooexperts_remove_block_data',0);
function wooexperts_remove_block_data(){ 
    remove_filter('wp_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
    remove_filter('admin_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
}

// `Disable Emojis` Plugin Version: 1.7.2
if( 'Отключаем Emojis в WordPress' ){

	/**
	 * Disable the emoji's
	 */
	function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );    
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
		add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
	}
	add_action( 'init', 'disable_emojis' );

	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 * 
	 * @param    array  $plugins  
	 * @return   array             Difference betwen the two arrays
	 */
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}

		return array();
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 *
	 * @param  array  $urls          URLs to print for resource hints.
	 * @param  string $relation_type The relation type the URLs are printed for.
	 * @return array                 Difference betwen the two arrays.
	 */
	function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {

		if ( 'dns-prefetch' == $relation_type ) {

			// Strip out any URLs referencing the WordPress.org emoji location
			$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
			foreach ( $urls as $key => $url ) {
				if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
					unset( $urls[$key] );
				}
			}

		}

		return $urls;
	}

}

// количетсво отображаемых товаров в каталоге
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 4;' ), 20 );




