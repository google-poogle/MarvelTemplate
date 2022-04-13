<?
/**
 * AJAX фильтр товаров
 */
add_action( 'wp_ajax_ajax_filter_form', 'true_filter' );
add_action( 'wp_ajax_nopriv_ajax_filter_form', 'true_filter' );

function true_filter() {
	// замедляет в секундах выполнение AJAX запроса
	//sleep( 3 );
	$posts_per_page = 4;
	$pagination = '';
	$paged = ! empty( $_POST[ 'paged' ] ) && $_POST[ 'paged' ] ? $_POST[ 'paged' ] : 1;
	$args = array(
		'paged' => $paged,
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'orderby' => 'price',
		'order' => 'DESK',
		'tax_query' => array(
			'relation' => 'AND',
   		array( // исключаем из фильтрации товары, который скрыты из каталога
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			),
		)
	);

	// категории товара
	$product_cats = ! empty( $_POST[ 'product_cats' ] ) && $_POST[ 'product_cats' ] ? $_POST[ 'product_cats' ] : array();


	if( $product_cats ) {
		$args[ 'tax_query' ][] = array(
			'taxonomy' => 'product_cat',
			'terms' => $product_cats
		);
	}

	// атрибуты товара
	// да, атрибуты это тоже таксономии, причём каждый атрибут – отдельная таксономия
	$razmers = ! empty( $_POST[ 'size' ] ) && $_POST[ 'size' ] ? $_POST[ 'size' ] : array();

	if( $razmers ) {
		$args[ 'tax_query' ][] = array(
			'taxonomy' => 'pa_size',
			'field' => 'slug',
			'terms' => $razmers
		);
	}


	$color = ! empty( $_POST[ 'color' ] ) && $_POST[ 'color' ] ? $_POST[ 'color' ] : array();

	if( $color ) {
		$args[ 'tax_query' ][] = array(
			'taxonomy' => 'pa_color',
			'field' => 'slug',
			'terms' => $color
		);
	}

	// фильтрация по ценам
	$min_price = ! empty( $_POST[ 'min_price' ] ) && $_POST[ 'min_price' ] ? absint( $_POST[ 'min_price' ] ) : 0;
	$max_price = ! empty( $_POST[ 'max_price' ] ) && $_POST[ 'max_price' ] ? absint( $_POST[ 'max_price' ] ) : 100;

	$args[ 'meta_query' ] = array(
		'price_clause' => array(
			'key' => '_price',
			'value' => array( $min_price, $max_price ), // значения ОТ и ДО
			'compare' => 'between',
			'type' => 'numeric'
		)
	);

	// сортировка цена/дата/рейтинг
	$orderby = ! empty( $_POST[ 'orderby' ] ) && $_POST[ 'orderby' ] ? $_POST[ 'orderby' ] : 'price';

	if( 'price' ===  $orderby ) {

		$args[ 'orderby' ] = 'price_clause';
		$args[ 'order' ] = 'ASC';
	}
	if( 'price-desc' ===  $orderby ) {

		$args[ 'orderby' ] = 'price_clause';
		$args[ 'order' ] = 'DESC';

	}


///	$args['orderby'] = 'meta_value_num';
//$args['meta_key'] = '_price';
//$args['order'] = 'asc';

	$query = new WP_Query( $args );
	//var_dump($query); exit;

	// запускаем буферизацию
	// после этой строчки всё, что будет выводитсья функцией echo по факту выводиться не будет, а запишется в буфер
	ob_start();

	if( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			wc_get_template_part( 'content', 'product' );
		}
	
	} else {
		echo '<p>Ничего не найдено.</p>';
	}

	// записываем всё, что в буфере, в переменную
	$html_products = ob_get_contents();
	// очищаем буфер
	ob_end_clean();

	
	$links_data = kama_paginate_links_data( [
		    'total' => $query->max_num_pages,
	   //   'current' => 2,
		//  'url_base' => 'http://ya.ru/page-name/paged/{page_num}',
	  ] );
	  if($query->found_posts>$posts_per_page) :
	  ob_start();
	  ?>
	  <div class="pagination">
		  <ul>
			  <?php foreach( $links_data as $link ) { ?>
			  <li>
				<? if($paged==$link->page_num){ 
					echo '<span class="activ_pag_link">'. $link->page_num .'</span>'; 
				} else { ?>
			    <a class="pagination_link" href="<?php esc_attr_e( $link->url ) ?>" data-num="<?php _e( $link->page_num ) ?>"><?php _e( $link->page_num ) ?></a>
			  <? } ?>
			</li>
			  <?php } 
				  //$link->is_current - активный элемент
			  ?>
		  </ul>
	  </div><!-- end nav -->
		  <?
	  $pagination = ob_get_contents();
	  ob_end_clean();
			  endif;
	 




	// при использовании wp_send_json() функции die()/exit(); уже не понадобятся после
	wp_send_json( array(
		'products' => $html_products,
		'count' => 'Отображение 1–' . $query->found_posts . ' из ' . $query->found_posts,
		'pagination' => $pagination
	) );

}
?>