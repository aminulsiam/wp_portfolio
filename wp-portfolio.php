<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WP Portfolio
 * Plugin URI:        https://github.com/aminulsiam/wp_projects
 * Description:       Create custom post, Show custom post, Show single post.
 * Version:           1.0.0
 * Author:            Aminul Haq Mallik
 * Author URI:        https://github.com/aminulsiam
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pf
 * Domain Path:       /languages
 */

require_once plugin_dir_path( __FILE__ ) . 'admin/class-plugin-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'public/class-plugin-public.php';


class WP_Portfolio {
	public function __construct() {
		$admin  = new WP_Portfolio_Admin();
		$public = new WP_Portfolio_Public();
	}
}

new WP_Portfolio();




