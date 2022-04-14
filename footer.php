<footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
        <div class="container">
            <div class="footer__items">
                <div class="footer__item">
                <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>logo.png" />
                    <div class="footer__item-text">
                        Фирменный магазин телевизоров Xiaomi mi TV и Redmi TV в Москве. Оригинальная техника по доступным ценам от производителя
                    </div>
                </div>
                <div class="footer__item">
                    <div class="footer__item-title">Покупателям</div>
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
                <div class="footer__item">
                    <div class="footer__item-title">Дополнительно</div>
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
                <div class="footer__item">
                    <div class="footer__item-title">Контакты</div>
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

            <hr>

            <div class="copyright__items">
                Copyright
                <div class="copyrightYear" itemprop="copyrightYear">2020</div> - 2022 ©
                <div itemprop="creator">a[Marvel]</div>
            </div>

        </div>
    </footer>



<script>
jQuery( function( $ ) {

/// клик по портировке
$('.orderby').on('change', function( e ){
    e.stopPropagation();
    e.preventDefault();
    $( 'input[name="orderby"]' ).val( this.value );
    $( 'input[name="paged"]' ).val( '' );
	$( '#ajax_filter_form' ).submit();
});

/// Клик по погинации
$('.pagination').bind('click', function(e){
    if(e.target.className == 'pagination_link') {
        $( 'input[name="paged"]' ).val( e.target.dataset.num );
        $( '#ajax_filter_form' ).submit();
        e.stopPropagation();
        e.preventDefault();
    }
});

// отправляем форму при клике на чекбоксы также
$( '#ajax_filter_form input[type="checkbox"]' ).change( function() {
    $( 'input[name="paged"]' ).val( '' );
    $( '#ajax_filter_form' ).submit();

} );
// ценовой слайдер
$( ".price_slider" ).on( "slidechange", function( e, ui ) { 
    $( 'input[name="paged"]' ).val( '' );
    $('#ajax_filter_form').submit(); 
    }
);   

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
