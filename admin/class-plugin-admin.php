<?php

/**
 * Class WP_Portofolio_Admin
 */
class WP_Portofolio_Admin {

	/**
	 * Wp_Pool_Admin constructor.
	 * Write all admin hooks
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'pf_enqueue_styles' ], 10 );
		add_action( 'admin_enqueue_scripts', [ $this, 'pf_enqueue_scripts' ], 10 );

		add_action( 'init', [ $this, 'pf_register_projects_cpt' ] );
		add_action( 'add_meta_boxes', [ $this, 'pf_add_meta_box' ] );
		add_action( 'save_post', [ $this, 'pf_save_metadata' ] );

		add_action( 'init', [ $this, 'pf_register_shortcodes' ] );
		add_action( 'init', [ $this, 'pf_register_taxonomy' ] );

	}

	/**
	 * Register Taxonomy
	 */
	public function pf_register_taxonomy() {

		$labels = array(
			'name'          => _x( 'Category', 'pf' ),
			'singular_name' => _x( 'Subject', 'pf' ),
			'search_items'  => __( 'Search Projects' ),
			'all_items'     => __( 'All Projects' ),
			'menu_name'     => __( 'Category' ),
		);

		register_taxonomy( 'project_category', array( 'projects' ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
		) );

	} //end pf_register_taxonomy


	/**
	 * Register all shortcode
	 */
	public function pf_register_shortcodes() {
		add_shortcode( 'show_projects', array( $this, 'pf_render_shortcode_show_projects' ) );
	} //end pf_register_shortcodes

	/**
	 * Render all shortcode
	 */
	public function pf_render_shortcode_show_projects() {
		$plugin_dir_path = plugin_dir_path( __FILE__ );
		require_once $plugin_dir_path . '../templates/projects-template.php';
	}


	/**
	 * Register Projects Custom Post Types
	 *
	 * @no_param
	 */
	public function pf_register_projects_cpt() {

		$labels = array(
			'name'               => _x( 'Projects', 'pf' ),
			'add_new_item'       => _x( 'Add New Project', 'pf' ),
			'all_items'          => __( 'All Projects', 'pf' ),
			'view_item'          => __( 'View Project', 'pf' ),
			'add_new'            => __( 'Add New', 'pf' ),
			'edit_item'          => __( 'Edit Project', 'pf' ),
			'update_item'        => __( 'Update Project', 'pf' ),
			'search_items'       => __( 'Search Project', 'pf' ),
			'not_found'          => __( 'Not Found', 'pf' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'pf' ),

		);

		$args = array(
			'public'    => true,
			'labels'    => $labels,
			'menu_icon' => 'dashicons-layout',
			'supports'  => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'   => array( 'slug' => 'projects' ),

		);
		register_post_type( 'projects', $args );

	} //end method pf_register_projects_cpt

	/**
	 * Add Meta data under projects cpt
	 */
	public function pf_add_meta_box() {
		add_meta_box(
			'pf_projects',
			'Projects Additional Information',
			[ $this, 'pf_render_metabox' ],
			'projects',
			'normal',
			'default'
		);
	} //end method pf_add_meta_in_projects_cpt

	/**
	 * Projects Meta Box Renderer
	 *
	 * @param $post
	 */
	public function pf_render_metabox( $post ) {

		$pf_ex_url          = get_post_meta( $post->ID, 'pf_ex_url', true );
		$pf_title           = get_post_meta( $post->ID, 'pf_title', true );
		$pf_description     = get_post_meta( $post->ID, 'pf_description', true );
		$pf_multiple_images = get_post_meta( $post->ID, 'pf_multiple_images', true );

		?>
        <form action="" method="post">
            <div class="container">

                <label for="pf_ex_url"><b>External Url</b></label>
                <input type="text" placeholder="Enter External Url" name="pf_ex_url" id="ex_url"
                       value="<?php esc_attr_e( $pf_ex_url ); ?>" required>

                <label for="psw"><b>Title</b></label>
                <input type="text" placeholder="Enter Title" name="pf_title" id="pf_title"
                       value="<?php esc_attr_e( $pf_title ); ?>" required>

                <label for="psw"><b>Description</b></label>
                <textarea name="pf_description" id="" cols="30" rows="10"
                          placeholder="Write Description"><?php esc_attr_e( $pf_description ); ?></textarea>

                <label for="custom_image_ids">Upload Images:</label>
                <input type="hidden" name="pf_multiple_images" class="image_ids"
                       value="<?php echo esc_attr( $pf_multiple_images ); ?>">
                <div class="images_preview">
					<?php
					if ( $pf_multiple_images ) {
						$image_ids = explode( ',', $pf_multiple_images );
						foreach ( $image_ids as $image_id ) {
							echo wp_get_attachment_image( $image_id, 'thumbnail' );
						}
					}
					?>
                </div>
                <button type="button" class="button multiple_image_preview">Add Multiple Images</button>

				<?php wp_nonce_field( 'pf_meta_box_nonce', 'pf_meta_box_nonce' ); ?>
            </div>
        </form>
		<?php
	} //end function pf_render_metabox


	/**
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function pf_save_metadata( $post_id ) {

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return $post_id;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return $post_id;
		}

		$nonce = isset( $_POST['pf_meta_box_nonce'] ) ? $_POST['pf_meta_box_nonce'] : "";

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'pf_meta_box_nonce' ) ) {
			return $post_id;
		}

		$pf_ex_url          = isset( $_POST['pf_ex_url'] ) ? sanitize_text_field( $_POST['pf_ex_url'] ) : "";
		$pf_title           = isset( $_POST['pf_title'] ) ? sanitize_text_field( $_POST['pf_title'] ) : "";
		$pf_description     = isset( $_POST['pf_description'] ) ? sanitize_text_field( $_POST['pf_description'] ) : "";
		$pf_multiple_images = isset( $_POST['pf_multiple_images'] ) ? sanitize_text_field( $_POST['pf_multiple_images'] ) : "";

		update_post_meta( $post_id, 'pf_ex_url', $pf_ex_url );
		update_post_meta( $post_id, 'pf_title', $pf_title );
		update_post_meta( $post_id, 'pf_description', $pf_description );
		update_post_meta( $post_id, 'pf_multiple_images', $pf_multiple_images );


	} //end pf_save_metadata

	/**
	 * Register all styles
	 */
	public function pf_enqueue_styles( $hook ) {
		wp_enqueue_style( 'pf-admin-css', plugins_url( '/assets/css/pf-admin.css', __FILE__ ), array(), time(), 'all' );
	}

	/**
	 * Register all scripts
	 */
	public function pf_enqueue_scripts( $hook ) {
		wp_enqueue_script( 'pf-admin', plugins_url( '/assets/js/pf-admin.js', __FILE__ ), 'jquery', time(), true );
	}


} //end main class

new WP_Portofolio_Admin();

