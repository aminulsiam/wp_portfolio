<?php

class WP_Portofolio_Public {

	/**
	 * Wp_Pool_Admin constructor.
	 * Write all admin hooks
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_style' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_scripts' ] );

		define( 'PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );


	}


	/**
	 * Register all styles
	 */
	public function pf_enqueue_style() {
		wp_enqueue_style( 'bootstrap', PLUGIN_DIR_URL . '../assets/css/bootstrap.min.css', array(), time(), 'all' );
	}

	/**
	 * Register all styles
	 */
	public function pf_enqueue_scripts() {
		wp_enqueue_script( 'bootstrap-js', PLUGIN_DIR_URL . '../assets/js/bootstrap.min.js', array(), time(), 'all' );
	}


} //end main class

new WP_Portofolio_Public();

