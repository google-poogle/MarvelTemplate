<?
/**
 * @param array $args {
 *     @type int    $total    Max paginate page.
 *     @type int    $current  Current page.
 *     @type string $url_base URL pattern. Use {page_num} placeholder.
 * }
 *
 * @return array
 */
function kama_paginate_links_data( $args ){
	global $wp_query;
	$args = wp_parse_args( $args, [
		'total' => $wp_query->max_num_pages ?? 1,
		'current' => null,
		'url_base' => '', //
	] );

	if( null === $args['current'] ){
		$args['current'] = max( 1, get_query_var( 'paged', 1 ) );
	}

	if( ! $args['url_base'] ){
		$args['url_base'] = str_replace( PHP_INT_MAX, '{page_num}', get_pagenum_link( PHP_INT_MAX ) );
	}

	$pages = range( 1, max( 1, (int) $args['total'] ) );

	foreach( $pages as & $page ){
		$page = (object) [
			'is_current' => $page == $args['current'] ,
			'page_num'   => $page,
			'url'        => str_replace( '{page_num}', $page, $args['url_base'] ),
		];
	}
	unset( $page );

	return $pages;
}


function marvel_pagination(){
    $links_data = kama_paginate_links_data( [
      //  'total' => 10,
     //   'current' => 2,
     //   'url_base' => 'http://site.com/page-name/paged/{page_num}',
    ] );
    
    ob_start();
    ?>

    <div class="pagination">
        <? if(count($links_data) > 1) : ?>
                <ul>
                    <?php foreach( $links_data as $link ) : ?>
                    <li>
                    <? if($link->is_current) : ?>
                            <span class="activ_pag_link"><?=$link->page_num?></span>
                    <? else : ?>
                            <a class="pagination_link" href="<?php esc_attr_e( $link->url ) ?>" data-num="<?php _e( $link->page_num ) ?>"><?php _e( $link->page_num ) ?></a>
                    </li>
                    <?php endif; ?>
                    <? endforeach;?>
                    
                </ul>
        <? endif; ?>
    </div><!-- end nav -->

    <?
      $output = ob_get_contents();
      ob_end_clean();
      echo $output;
    ?>

<? } ?>     