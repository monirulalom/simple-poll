<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://monirulalom.com
 * @since      1.0.0
 *
 * @package    Simple_Poll
 * @subpackage Simple_Poll/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Simple_Poll
 * @subpackage Simple_Poll/includes
 * @author     Md. Monirul Alom <monirulalom@gmail.com>
 */
class Simple_Poll_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . "simple_poll";
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);
	}
}
