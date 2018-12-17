<?php
/**
 * Register Portfolio CPT and meta boxes for it
 * Post type name and meta key names are follow 'content type standard',
 * see more about it here: https://github.com/justintadlock/content-type-standards/wiki/Content-Type:-Portfolio
 *
 * @package DF Portfolio Management
 */

/**
 * Class DF_Portfolio
 */
class DF_Portfolio {
	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return DF_Portfolio
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		// Handle post columns
		add_filter( 'manage_portfolio_project_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_portfolio_project_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_metadata' ) );

        // Enqueue style and javascript
        add_action( 'admin_print_styles-post.php', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_print_styles-post-new.php', array( $this, 'enqueue_scripts' ) );

        // Handle ajax callbacks
        add_action( 'wp_ajax_df_portfolio_attach_images', array( $this, 'ajax_attach_images' ) );
        add_action( 'wp_ajax_df_portfolio_order_images', array( $this, 'ajax_order_images' ) );
        add_action( 'wp_ajax_df_portfolio_delete_image', array( $this, 'ajax_delete_image' ) );
	}

	/**
	 * Register portfolio post type
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'portfolio_project' ) ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Portfolio', 'Post Type General Name', 'df-portfolio' ),
			'singular_name'      => _x( 'Portfolio', 'Post Type Singular Name', 'df-portfolio' ),
			'menu_name'          => esc_html__( 'Portfolios', 'df-portfolio' ),
			'parent_item_colon'  => esc_html__( 'Parent Portfolio', 'df-portfolio' ),
			'all_items'          => esc_html__( 'All Portfolios', 'df-portfolio' ),
			'view_item'          => esc_html__( 'View Portfolio', 'df-portfolio' ),
			'add_new_item'       => esc_html__( 'Add New Portfolio', 'df-portfolio' ),
			'add_new'            => esc_html__( 'Add New', 'df-portfolio' ),
			'edit_item'          => esc_html__( 'Edit Portfolio', 'df-portfolio' ),
			'update_item'        => esc_html__( 'Update Portfolio', 'df-portfolio' ),
			'search_items'       => esc_html__( 'Search Portfolio', 'df-portfolio' ),
			'not_found'          => esc_html__( 'Not found', 'df-portfolio' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'df-portfolio' ),
		);
		$args   = array(
			'label'               => esc_html__( 'Portfolio', 'df-portfolio' ),
			'description'         => esc_html__( 'Create and manage all works', 'df-portfolio' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => apply_filters( 'ta_portfolio_slug', 'portfolio' ) ),
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-portfolio',
		);
		register_post_type( 'portfolio_project', $args );
	}

	/**
	 * Register portfolio category taxonomy
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'              => esc_html__( 'Categories', 'df-portfolio' ),
			'singular_name'     => esc_html__( 'Category', 'df-portfolio' ),
			'search_items'      => esc_html__( 'Search Categories', 'df-portfolio' ),
			'all_items'         => esc_html__( 'All Categories', 'df-portfolio' ),
			'parent_item'       => esc_html__( 'Parent Category', 'df-portfolio' ),
			'parent_item_colon' => esc_html__( 'Parent Category:', 'df-portfolio' ),
			'edit_item'         => esc_html__( 'Edit Category', 'df-portfolio' ),
			'update_item'       => esc_html__( 'Update Category', 'df-portfolio' ),
			'add_new_item'      => esc_html__( 'Add New Category', 'df-portfolio' ),
			'new_item_name'     => esc_html__( 'New Category Name', 'df-portfolio' ),
			'menu_name'         => esc_html__( 'Categories', 'df-portfolio' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array(
				'slug'         => apply_filters( 'ta_portfolio_category_slug', 'portfolio-category' ),
				'with_front'   => true,
				'hierarchical' => false,
			),
		);

		register_taxonomy( 'portfolio_category', array( 'portfolio_project' ), $args );
	}

	/**
	 * Add custom column to manage portfolio screen
	 * Add Thumbnail column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$cb              = array_slice( $columns, 0, 1 );
		$cb['thumbnail'] = esc_html__( 'Thumbnail', 'df-portfolio' );

		return array_merge( $cb, $columns );
	}

	/**
	 * Handle custom column display
	 *
	 * @since  1.0.0
	 *
	 * @param  string $column
	 * @param  int    $post_id
	 *
	 * @return void
	 */
	public function manage_custom_columns( $column, $post_id ) {
		if ( 'thumbnail' == $column ) {
			echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
		}
	}

    public function enqueue_scripts() {
        global $post_type;

        if ( $post_type == 'portfolio_project' ) {
            wp_enqueue_media();
            wp_enqueue_style( 'df-portfolio', DF_PORTFOLIO_URL . '/css/admin.css' );
            wp_enqueue_script( 'df-portfolio', DF_PORTFOLIO_URL . '/js/admin.js', array( 'jquery', 'underscore', 'jquery-ui-sortable' ), '20160726', true );

            wp_localize_script(
                'df-portfolio', 'dfPortfolio', array(
                    'frameTitle' => esc_html__( 'Select Or Upload Images', 'df-portfolio' ),
                )
            );
        }
    }

	/**
	 * Add portfolio details meta box
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box( 'portfolio-type', esc_html__( 'Portfolio Type', 'df-portfolio' ), array( $this, 'portfolio_type_meta_box' ), 'portfolio_project', 'normal', 'high' );
		add_meta_box( 'portfolio-detail', esc_html__( 'Portfolio Details', 'df-portfolio' ), array( $this, 'portfolio_detail_meta_box' ), 'portfolio_project', 'normal', 'high' );
	}

	/**
	 * Display portfolio details meta box
	 * It contains project url
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function portfolio_detail_meta_box( $post ) {
		wp_nonce_field( 'df_portfolio_details_' . $post->ID, '_dfnonce' );
		?>

		<p>
			<label for="project-client"><?php _e( 'Project Client', 'df-portfolio' ) ?></label><br>
			<input type="text" name="_project_client" value="<?php echo get_post_meta( $post->ID, '_project_client', true ) ?>" id="project-client" class="widefat">
		</p>

        <p>
            <label for="project-author"><?php _e( 'Author', 'df-portfolio' ) ?></label><br>
            <input type="text" name="_project_author" value="<?php echo get_post_meta( $post->ID, '_project_author', true ) ?>" id="project-author" class="widefat">
        </p>


        <?php do_action( 'df_portfolio_details_fields', $post ); ?>

		<?php
	}


	/**
	 * Display portfolio type meta box
	 * It contains project url
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function portfolio_type_meta_box( $post ) {
		wp_nonce_field( 'df_portfolio_type_' . $post->ID, '_dfnonce' );
		?>

		<p>
			<?php _e( 'Choose portfolio single type', 'df-portfolio' ) ?>
		</p>

		<?php
		$type = get_post_meta( $post->ID, '_project_type', true );
		$image = $type == 'image' ? 'checked="checked"' : '';
		$gallery = $type == 'gallery' ? 'checked="checked"' : '';
		?>

		<p>
			<input type="radio" <?php echo esc_attr( $image ) ?> name="_project_type" value="image" id="project-image" class="widefat">
			<label for="project-image"><?php _e( 'Single Image', 'df-portfolio' ) ?></label><br>
		</p>


		<p>
			<input type="radio" <?php echo esc_attr( $gallery ) ?> name="_project_type" value="gallery" id="project-gallery" class="widefat">
			<label for="project-gallery"><?php _e( 'Gallery', 'df-portfolio' ) ?></label><br>
		</p>
		<div id="fos-project-gallery">
			<p>
				<?php _e( 'Project Gallery', 'df-portfolio' ) ?>
			</p>

			<ul id="project-images" class="images-holder" data-nonce="<?php echo wp_create_nonce( 'df-portfolio-images-' . $post->ID ) ?>">
				<?php
				foreach ( $images = array_filter( (array) get_post_meta( $post->ID, 'images', false ) ) as $image ) {
					echo $this->gallery_item( $image );
				}
				?>
			</ul>

			<input type="button" id="df-images-upload" class="button" value="<?php _e( 'Select Or Upload Images', 'df-portfolio' ) ?>" data-nonce="<?php echo wp_create_nonce( 'df-upload-images-' . $post->ID ) ?>">

		</div>

		<?php
	}

	/**
	 * Save portfolio details
	 *
	 * @since  1.0.0
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function save_metadata( $post_id ) {

		// Verify nonce
		if ( ( get_post_type() != 'portfolio_project' ) || ( isset( $_POST['_dfnonce'] ) && ! wp_verify_nonce( $_POST['_dfnonce'], 'df_portfolio_details_' . $post_id ) ) ) {
			return;
		}


		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Update post meta
		update_post_meta( $post_id, '_project_client', esc_html( $_POST['_project_client'] ) );
		update_post_meta( $post_id, '_project_author', esc_html( $_POST['_project_author'] ) );

		update_post_meta( $post_id, '_project_type', esc_html( $_POST['_project_type'] ) );

		do_action( 'df_portfolio_save_metadata', $post_id );
	}

    /**
     * Get html markup for one gallery's image item
     *
     * @param  int $attachment_id
     *
     * @return string
     */
    public function gallery_item( $attachment_id ) {
        return sprintf(
            '<li id="item_%1$s">
				%5$s
				<p class="image-actions">
					<a title="%3$s" class="df-portfolio-edit-image" href="%2$s" target="_blank">%3$s</a> |
					<a title="%4$s" class="df-portfolio-delete-image" href="#" data-attachment_id="%1$s" data-nonce="%6$s">×</a>
				</p>
			</li>',
            $attachment_id,
            get_edit_post_link( $attachment_id ),
            esc_html__( 'Edit', 'df-portfolio' ),
			esc_html__( 'Delete', 'df-portfolio' ),
            wp_get_attachment_image( $attachment_id ),
            wp_create_nonce( 'df-portfolio-delete-image-' . $attachment_id )
        );
    }

    /**
     * Ajax callback for attaching media to field
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function ajax_attach_images() {
        $post_id        = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
        $attachment_ids = isset( $_POST['attachment_ids'] ) ? $_POST['attachment_ids'] : array();

        check_ajax_referer( 'df-upload-images-' . $post_id );
        $items = '';

        foreach ( $attachment_ids as $attachment_id ) {
            add_post_meta( $post_id, 'images', $attachment_id, false );
            $items .= $this->gallery_item( $attachment_id );
        }
        wp_send_json_success( $items );
    }

    /**
     * Ajax callback for ordering images
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function ajax_order_images() {
        $order   = isset( $_POST['order'] ) ? $_POST['order'] : 0;
        $post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;

        check_ajax_referer( 'df-portfolio-images-' . $post_id );

        parse_str( $order, $items );

        delete_post_meta( $post_id, 'images' );
        foreach ( $items['item'] as $item ) {
            add_post_meta( $post_id, 'images', $item, false );
        }
        wp_send_json_success();
    }

    /**
     * Ajax callback for deleting an image from portfolio's gallery
     *
     * @since  1.0.0
     *
     * @return void
     */
    function ajax_delete_image() {
        $post_id       = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
        $attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;

        check_ajax_referer( 'df-portfolio-delete-image-' . $attachment_id );

        delete_post_meta( $post_id, 'images', $attachment_id );
        wp_send_json_success();
    }
}
