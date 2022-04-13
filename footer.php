<!--== Start Footer Section ===-->
<footer id="footer-area">
    <!-- Start Footer Widget Area -->
    <div class="footer-widget-area pt-40 pb-28">
        <div class="container">
            <div class="footer-widget-content">
                <div class="row">

                    <!-- Start Footer Widget Item -->
                    <div class="col-sm-3 col-lg-3">
                        <div class="footer-widget-item-wrap">
                            <h3 class="widget-title">Каталог</h3>
                            <div class="widget-body">
															<?php
																wp_nav_menu(
																	array(
																		'theme_location' => 'foot_1',
																		'container' => false,
																		'menu_class' => 'footer-list',
																	)
																);
                              ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer Widget Item -->

                    <!-- Start Footer Widget Item -->
                    <div class="col-sm-3 col-lg-3">
                        <div class="footer-widget-item-wrap">
                            <h3 class="widget-title">Страницы</h3>
                            <div class="widget-body">
															<?php
															 wp_nav_menu(
																 array(
																	 'theme_location' => 'foot_2',
																	 'container' => false,
																	 'menu_class' => 'footer-list',
																 )
															 );
															?>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer Widget Item -->

                    <!-- Start Footer Widget Item -->
                    <div class="col-sm-3 col-lg-3">
                        <div class="footer-widget-item-wrap">
                            <h3 class="widget-title">Товары</h3>
                            <div class="widget-body">
															<?php
																wp_nav_menu(
																	array(
																		'theme_location' => 'foot_3',
																		'container' => false,
																		'menu_class' => 'footer-list',
																	)
																);
															?>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer Widget Item -->

                    <!-- Start Footer Widget Item -->
                    <div class="col-sm-3 col-lg-3">
                        <div class="footer-widget-item-wrap">
                            <h3 class="widget-title">Напишите мне</h3>
                            <div class="widget-body">
                                <div class="contact-text">
                                    <a href="#">(+1) 234 56 78</a>
                                    <a href="#">me@misha.blog</a>
                                    <p>Санкт-Петербург, Невский пр.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer Widget Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Widget Area -->

    <!-- Start Footer Bottom Area -->
    <div class="footer-bottom-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-lg-3 m-auto order-1">
                    <div class="footer-social-icons nav justify-content-center justify-content-sm-start mb-xs-10">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                </div>

                <div class="col-sm-5 col-lg-6 m-auto order-3 order-sm-2 text-center text-sm-left text-lg-center">
                    <div class="copyright-text mt-xs-10 ">
                        <p>&copy; 2020 Курс WooCommerce от Миши Рудрастых.</p>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-3 m-auto order-2 text-center text-md-right">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/payments.png" alt="Payment Method"/>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom Area -->
</footer>
<!--== End Footer Section ===-->

<script>
jQuery( function( $ ) {

$('.orderby').on('change', function( e ){
    e.stopPropagation();
    e.preventDefault();
    $( 'input[name="orderby"]' ).val( this.value );
    $( 'input[name="paged"]' ).val( '' );
	$( '#ajax_filter_form' ).submit();
});

$('.pagination').bind('click', function(e){
    if(e.target.className == 'pagination_link') {
     $( 'input[name="paged"]' ).val( e.target.dataset.num );
     $( '#ajax_filter_form' ).submit();
     e.stopPropagation();
     e.preventDefault();
    }
});

	// асинхронный запрос при отправке формы
	$( '#ajax_filter_form' ).submit( function( e ) {
		e.preventDefault();

		const form = $(this);

		$.ajax( {
			type : 'POST',
			url : woocommerce_params.ajax_url,
			data : form.serialize(),
			beforeSend : function( xhr ) {
				// отображаем прелоадер и блокируем клик по фильтр в момент, когда он загружается
				$( '.main__element__wrapper' ).block({
					message : null,
					overlayCSS: {
            background: '#fff url( ' + window.location.protocol + '//' + window.location.hostname + '/wp-content/themes/Marvel/assets/img/oval.svg) center 150px no-repeat',
            opacity: 0.6
        	}

				})
			},
			success : function( data ) {
				// выводим отфильтрованные товары
				$( '.pruduct__items' ).html( data.products );
				// выводим счётчик количества товаров
				$( '.woocommerce-result-count' ).text( data.count );

				$( '.pagination' ).html( data.pagination );

				$( '.main__element__wrapper' ).unblock();
			}

		} );

	} );

	// отправляем форму при клике на чекбоксы также
	$( '#ajax_filter_form input[type="checkbox"]' ).change( function() {
        $( 'input[name="paged"]' ).val( '' );
		$( '#ajax_filter_form' ).submit();

	} );

    $( ".price_slider" ).on( "slidechange", function( e, ui ) { $('#ajax_filter_form').submit();  } );   
 });

</script>

<style>
.woocommerce .widget_price_filter .price_slider {
 margin-bottom:1em
}
.woocommerce .widget_price_filter .price_slider_amount {
 text-align:right;
 line-height:2.4;
 font-size:.8751em
}
.woocommerce .widget_price_filter .price_slider_amount .button {
 font-size:1.15em;
 float:left
}
.woocommerce .widget_price_filter .ui-slider {
 position:relative;
 text-align:left;
 margin-left:.5em;
 margin-right:.5em
}
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
 position:absolute;
 z-index:2;
 width:1em;
 height:1em;
 background-color:#a46497;
 border-radius:1em;
 cursor:ew-resize;
 outline:0;
 top:-.3em;
 margin-left:-.5em
}
.woocommerce .widget_price_filter .ui-slider .ui-slider-range {
 position:absolute;
 z-index:1;
 font-size:.7em;
 display:block;
 border:0;
 border-radius:1em;
 background-color:#a46497
}
.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content {
 border-radius:1em;
 background-color:#462940;
 border:0
}
.woocommerce .widget_price_filter .ui-slider-horizontal {
 height:.5em
}
.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range {
 top:0;
 height:100%
}
.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range-min {
 left:-1px
}
.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range-max {
 right:-1px
}
.woocommerce .widget_rating_filter ul {
 margin:0;
 padding:0;
 border:0;
 list-style:none outside
}
.woocommerce .widget_rating_filter ul li {
 padding:0 0 1px;
 list-style:none
}
.woocommerce .widget_rating_filter ul li::after,
.woocommerce .widget_rating_filter ul li::before {
 content:" ";
 display:table
}
.woocommerce .widget_rating_filter ul li::after {
 clear:both
}
.woocommerce .widget_rating_filter ul li a {
 padding:1px 0;
 text-decoration:none
}
.woocommerce .widget_rating_filter ul li .star-rating {
 float:none;
 display:inline-block
}
.woocommerce .widget_rating_filter ul li.chosen a::before {
 font-family:WooCommerce;
 speak:never;
 font-weight:400;
 font-variant:normal;
 text-transform:none;
 line-height:1;
 -webkit-font-smoothing:antialiased;
 margin-right:.618em;
 content:"\e013";
 text-decoration:none;
 color:#a00
}
    </style>


<?php wp_footer() ?>

</body>
</html>
