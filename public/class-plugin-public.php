<?php

class WP_Portofolio_Public {

	/**
	 * Wp_Pool_Admin constructor.
	 * Write all admin hooks
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_scripts' ] );

		define( 'PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );


	}


	/**
	 * Register all styles
	 */
	public function pf_enqueue_styles() {
		wp_enqueue_style( 'pf-admin-css', plugins_url( '/assets/css/bootstrap.min.css', __FILE__ ), array(), time(), 'all' );
	}

	/**
	 * Register all scripts
	 */
	public function pf_enqueue_scripts() {
		wp_enqueue_script( 'pf-admin', plugins_url( '/assets/css/bootstrap.min.js', __FILE__ ), 'jquery', time(), true );
	}


} //end main class

new WP_Portofolio_Public();

