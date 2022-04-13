<!--- Sidebar --->
    <div class="main__element el-sidebar">

    <?php if ( is_active_sidebar( 'standart_bar' ) ) : ?>
          <?php dynamic_sidebar( 'standart_bar' ); ?>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'ajax_filter_bar' ) ) : ?>
        <aside itemscope itemtype="http://schema.org/WPSideBar">
            <form action="" method="POST" id="ajax_filter_form">
                <?php dynamic_sidebar( 'ajax_filter_bar' ); ?>
            <input type="hidden" name="action" value="ajax_filter_form" />
            <input type="hidden" name="orderby" value="" />
            <input type="hidden" name="product_cats" value="<? print (get_queried_object()->term_taxonomy_id) ? get_queried_object()->term_taxonomy_id : '0' ?>" />
            <input type="hidden" name="paged" value="" />
            </form>
        </aside>
    <?php endif; ?>

</div>
<!---/ Sidebar --->