<?php
class trueTopPostsWidget extends WP_Widget
{

	/*
  * создание виджета
  */
	function __construct()
	{
		parent::__construct(
			'true_top_widget',
			'Фильтр', // заголовок виджета
			array('description' => 'Вывод фильтра по атрибутам.') // описание
		);

	}

	/*
  * фронтэнд виджета
  */
	public function widget($args, $instance)
	{
		$ajaxFunc = 1;
		$title = apply_filters('widget_title', $instance['title']); // к заголовку применяем фильтр (необязательно)
		$posts_per_page = $instance['posts_per_page'];
		$atribut = $instance['my_settings'];

		//var_dump($args);
		echo $args['before_widget'];

		echo $args['before_title'] .  $title . $args['after_title'];


		$product_attr = get_terms(array('taxonomy' => 'pa_' . $atribut, 'hide_empty' => false));
		if ($product_attr) :
			$shop_page_url = $_SERVER['REQUEST_URI'];
			if (!empty($_GET['min_price'])) {
				$shop_page_url = add_query_arg('min_price', $_GET['min_price'], $shop_page_url);
			}
			if (!empty($_GET['max_price'])) {
				$shop_page_url = add_query_arg('max_price', $_GET['max_price'], $shop_page_url);
			}
			foreach ($_GET as $key => $value) {
				if (strpos($key, 'filter_') !== false) {
					$shop_page_url = add_query_arg($key, $value, $shop_page_url);
				}
			}

		echo '<div class="atribut__elemets">';
		foreach ($product_attr as $attr_item) : ?>
				<div class="atribut__el">
				
				<?if($ajaxFunc == 0):?>
				<a href="<?php echo add_query_arg('filter_' . $atribut . '', $attr_item->slug, $shop_page_url) ?>" <?php if (isset($_GET['filter_' . $atribut . '']) && $attr_item->slug == $_GET['filter_' . $atribut . '']) : ?>class="active" <?php endif; ?>>
						<?php echo $attr_item->name ?>
					<? else : ?>
					<input type="checkbox" name="<?=esc_attr( $atribut )?>[]" id="razmer-<?php echo esc_attr( $attr_item->slug ) ?>" value="<?php echo esc_attr( $attr_item->slug ) ?>" />
				    <label for="razmer-<?php echo esc_attr( $attr_item->slug ) ?>"><?php echo esc_html( $attr_item->name ) ?></label>
										
					<?endif;?>
					</a>
				</div>
		<?php endforeach;
		echo '</div">';
		endif;



		echo $args['after_widget'];
	}
	/*
  * бэкэнд виджета
  */
	public function form($instance)
	{
		if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		if (isset($instance['posts_per_page'])) {
			$posts_per_page = $instance['posts_per_page'];
		}
		if (isset($instance['my_settings'])) {
			$my_settings = $instance['my_settings'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Заголовок</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>">Количество постов:</label>
			<input id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr($posts_per_page) : '5'; ?>" size="3" />
		</p>
		<p>
			<label for="my_settings"><?= $my_settings ?></label>
			<select name="<?php echo $this->get_field_name('my_settings'); ?>" id="<?php echo $this->get_field_id('my_settings'); ?>" class="widefat">
				<?
				$tax_list = wc_get_attribute_taxonomies();
				foreach ($tax_list as $value) : ?>
					<option value="<?= $value->attribute_name ?>" <? selected($instance['my_settings'], $value->attribute_name) ?>><?= $value->attribute_label ?></option>
				<?
				endforeach;
				?>
			</select>
		</p>
<?php
	}

	/*
  * сохранение настроек виджета
  */
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['posts_per_page'] = (is_numeric($new_instance['posts_per_page'])) ? $new_instance['posts_per_page'] : '5'; // по умолчанию выводятся 5 постов
		$instance['my_settings'] = ($new_instance['my_settings']) ? $new_instance['my_settings'] : 5;
		return $instance;
	}
}

/*
* регистрация виджета
*/
function true_top_posts_widget_load()
{
	register_widget('trueTopPostsWidget');
}
add_action('widgets_init', 'true_top_posts_widget_load');
