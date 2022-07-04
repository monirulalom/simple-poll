<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://monirulalom.com
 * @since      1.0.0
 *
 * @package    Simple_Poll
 * @subpackage Simple_Poll/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Poll
 * @subpackage Simple_Poll/admin
 * @author     Md. Monirul Alom <monirulalom@gmail.com>
 */
class Simple_Poll_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Poll_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Poll_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-poll-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Poll_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Poll_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-poll-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_var', array( 'ajaxurl' => admin_url('admin-ajax.php') ));		
		

	}

	public function enqueue_block_scripts(){
		wp_enqueue_script("poll-block-script", plugin_dir_url(  __DIR__ ) . 'block/build/index.js', array( 'wp-blocks','wp-block-editor','wp-components','wp-element', 'wp-polyfill', 'wp-api-fetch', 'wp-i18n', 'wp-editor'));
	}

	public function addMenuPages($hook_suffix)
    {
		if (!class_exists("Simple_Poll_Admin_Page")) {
            require plugin_dir_path(dirname(__FILE__)) . 'admin/partials/simple-poll-admin-display.php';
        }

        $poll_admin_page = new Simple_Poll_Admin_Page();

		add_menu_page(
			__('Simple Poll','simple-poll'),
			__('Simple Poll','simple-poll'), 
			'manage_options',
			'add-new-poll',
			[$poll_admin_page,'add_new_poll_page'],
			'dashicons-groups',
		);

		add_submenu_page(
			'add-new-poll',
			__('Add new poll','simple-poll'),
			__('Add new poll','simple-poll'),
			'manage_options',
			'add-new-poll',
			[$poll_admin_page,'add_new_poll_page'],
		);

		add_submenu_page(
			'add-new-poll',
			__('Existing polls','simple-poll'),
			__('Existing polls','simple-poll'),
			'manage_options',
			'view-exixting-polls',
			[$poll_admin_page,'view_existing_polls_page'],
		);

		add_submenu_page(
			null,
			__('Edit poll', 'simple-poll'),
			__('Edit poll', 'simple-poll'),
			'manage_options',
			'edit-poll',
			[$poll_admin_page,'edit_poll_page'],
		);

		add_submenu_page(
			null,
			__('Delete poll', 'simple-poll'),
			__('Delete poll', 'simple-poll'),
			'manage_options',
			'delete-poll',
			[$poll_admin_page,'delete_poll_page'],
		);
    }
	


}
