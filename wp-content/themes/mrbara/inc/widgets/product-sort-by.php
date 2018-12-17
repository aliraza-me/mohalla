<?php

class MrBara_Product_ShortBy_Widget extends WP_Widget
{
	protected $defaults;
	function __construct()
	{
		$this->defaults = array(
			'title' => '',
		);

		parent::__construct(
			'product-sort-by',
			esc_html__( 'MrBara - Product Sort By', 'mrbara' ),
			array(
				'classname'   => 'product-sort-by shop-toolbar',
				'description' => esc_html__( 'Sort Product By', 'mrbara' ),
			)
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget($args, $instance) {
		$instance = wp_parse_args($instance, $this->defaults);

		extract($args);
		echo $before_widget;

		if ($title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base))
			echo $before_title . $title . $after_title;
		?>
			<div class="sort-by">
				<?php esc_html_e( 'Sort By:', 'mrbara' ) . woocommerce_catalog_ordering() ?>
			</div>
		<?php
		echo $after_widget;
	}

	/**
	 * Deals with the settings when they are saved by the admin.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance )
	{
		$instance                        = array();
		$instance['title']               = strip_tags( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return array
	 */
	function form( $instance )
	{
		$instance = wp_parse_args( $instance, $this->defaults );
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'mrbara' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
	<?php
	}
}
