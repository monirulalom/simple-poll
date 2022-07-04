<?php

/**
 * Fired during plugin activation
 *
 * @link       https://monirulalom.com
 * @since      1.0.0
 *
 * @package    Simple_Poll
 * @subpackage Simple_Poll/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Simple_Poll
 * @subpackage Simple_Poll/includes
 * @author     Md. Monirul Alom <monirulalom@gmail.com>
 */
class Simple_Poll_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "simple_poll";
	  
		$sql = "CREATE TABLE $table_name (
		  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
		  `question` varchar(255),
		  `yes` bigint(11) unsigned DEFAULT '0',
		  `no` bigint(11) unsigned DEFAULT '0',

		  PRIMARY KEY  (id)
		) $charset_collate;";
	  
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}
