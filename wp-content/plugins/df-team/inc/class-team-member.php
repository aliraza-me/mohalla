<?php
/**
 * Register Team Member CPT and meta boxes for it
 *
 * @package DF Team Management
 */

/**
 * Class DF_Team_Member
 */
class DF_Team_Member {
	/**
	 * Social profiles
	 * @var array
	 */
	public $socials;

	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return DF_Team_Member
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		// Handle post columns
		add_filter( 'manage_team_member_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_team_member_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_metadata' ) );
	}

	/**
	 * Register custom post type for Team Member
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'team_member' ) ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Team Member', 'Post Type General Name', 'df-team' ),
			'singular_name'      => _x( 'Team Member', 'Post Type Singular Name', 'df-team' ),
			'menu_name'          => __( 'Team', 'df-team' ),
			'parent_item_colon'  => __( 'Parent Team Member', 'df-team' ),
			'all_items'          => __( 'All Members', 'df-team' ),
			'view_item'          => __( 'View Member', 'df-team' ),
			'add_new_item'       => __( 'Add New Member', 'df-team' ),
			'add_new'            => __( 'Add New', 'df-team' ),
			'edit_item'          => __( 'Edit Member', 'df-team' ),
			'update_item'        => __( 'Update Member', 'df-team' ),
			'search_items'       => __( 'Search Member', 'df-team' ),
			'not_found'          => __( 'Not found', 'df-team' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'df-team' ),
		);
		$args   = array(
			'label'               => __( 'Team Member', 'df-team' ),
			'description'         => __( 'Create and manage all works', 'df-team' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => apply_filters( 'df_team_member_slug', 'member' ) ),
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-groups',
		);
		register_post_type( 'team_member', $args );
	}

	/**
	 * Register Team Group taxonomy
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'              => __( 'Team Group', 'df-team' ),
			'singular_name'     => __( 'Team Group', 'df-team' ),
			'search_items'      => __( 'Search Team Groups', 'df-team' ),
			'all_items'         => __( 'All Team Groups', 'df-team' ),
			'parent_item'       => __( 'Parent Team Group', 'df-team' ),
			'parent_item_colon' => __( 'Parent Team Group:', 'df-team' ),
			'edit_item'         => __( 'Edit Team Group', 'df-team' ),
			'update_item'       => __( 'Update Team Group', 'df-team' ),
			'add_new_item'      => __( 'Add New Team Group', 'df-team' ),
			'new_item_name'     => __( 'New Team Group Name', 'df-team' ),
			'menu_name'         => _x( 'Groups', 'Team Group Taxonomy Menu', 'df-team' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array(
				'slug'         => apply_filters( 'df_team_group_slug', 'member-group' ),
				'with_front'   => true,
				'hierarchical' => false,
			),
		);

		register_taxonomy( 'team_group', array( 'team_member' ), $args );
	}

	/**
	 * Add custom column to manage Team Member screen
	 * Add image column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$cb              = array_slice( $columns, 0, 1 );
		$cb['image'] = __( 'Image', 'df-team' );

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
		if ( 'image' == $column ) {
			echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
		}
	}

	/**
	 * Add Team Member information meta box
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box( 'team-member-info', __( 'Team Member Information', 'df-team' ), array( $this, 'info_meta_box' ), 'team_member', 'normal', 'high' );
	}

	/**
	 * Display meta box
	 * It contains fields: email, website url and social links
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function info_meta_box( $post ) {
		$job     = get_post_meta( $post->ID, '_team_member_job', true );
		wp_nonce_field( 'df_team_member_info_' . $post->ID, '_tanonce' );
		?>

		<table class="form-table">
			<tr class="team-member-job">
				<th scope="row"><label for="team-member-job"><?php _e( 'Job Title', 'df-team' ) ?></label></th>
				<td><input type="text" name="_team_member_job" value="<?php echo $job ?>" id="team-member-job" class="widefat"></td>
			</tr>

		</table>

		<?php
	}

	/**
	 * Save post meta data
	 *
	 * @since  1.0.0
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function save_metadata( $post_id ) {
		// Verify nonce
		if ( ( get_post_type() != 'team_member' ) || ( isset( $_POST['_tanonce'] ) && ! wp_verify_nonce( $_POST['_tanonce'], 'df_team_member_info_' . $post_id ) ) ) {
			return;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Update post meta
		update_post_meta( $post_id, '_team_member_job', esc_html( $_POST['_team_member_job'] ) );

		do_action( 'df_team_member_save_metadata', $post_id );
	}
}
