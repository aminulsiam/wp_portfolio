<?php

class WP_Portfolio_Public {

	/**
	 * WP_Portfolio_Public constructor.
	 * Write all public hooks
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'pf_enqueue_scripts' ] );
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
		wp_enqueue_script( 'pf-admin', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ), 'jquery', time(), true );
	}


} //end main class

new WP_Portfolio_Public();

