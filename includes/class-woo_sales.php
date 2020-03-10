<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.linkedin.com/in/shkapenko-oleksii/
 * @since      1.0.0
 *
 * @package    Woo_sales
 * @subpackage Woo_sales/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_sales
 * @subpackage Woo_sales/includes
 * @author     Alex <alex96813@gmail.com>
 */
class Woo_sales {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_sales_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	const PLUGIN_NAME = 'woo_sales';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_SALES_VERSION' ) ) {
			$this->version = WOO_SALES_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->set_discount();
		$this->check_visit();
		$this->add_settings();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_sales_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_sales_i18n. Defines internationalization functionality.
	 * - Woo_sales_Admin. Defines all hooks for the admin area.
	 * - Woo_sales_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_sales-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_sales-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo_sales-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo_sales-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_sales-discount.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_sales-visit.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_sales-settings.php';

		$this->loader = new Woo_sales_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_sales_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_sales_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_sales_Admin( self::PLUGIN_NAME, $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_sales_Public( self::PLUGIN_NAME, $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'insert_close_popup' );
		
	}
	
	private function set_discount(){

		$plugin_discount = new Woo_sales_Discount();
	
		$this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_discount, 'add_user_discounts' );
		
		$this->loader->add_action( 'wp_ajax_get_staying_discount', $plugin_discount, 'get_staying_discount' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_staying_discount', $plugin_discount, 'get_staying_discount' );

		$this->loader->add_action( 'wp_ajax_refuse_staying_discount', $plugin_discount, 'refuse_staying_discount' );
		$this->loader->add_action( 'wp_ajax_nopriv_refuse_staying_discount', $plugin_discount, 'refuse_staying_discount' );
		
	}
	
	private function check_visit(){

		$plugin_visit = new Woo_sales_Visit();
	
		$this->loader->add_action( 'init', $plugin_visit, 'setup' );
		$this->loader->add_action( 'wp_footer', $plugin_visit, 'add_message' );

	}

	private function add_settings(){

		$plugin_settings = new Woo_sales_Settings();

		$this->loader->add_action( 'woocommerce_settings_tabs_array', $plugin_settings, 'add_settings_tab');
		$this->loader->add_action( 'woocommerce_settings_tabs_' . self::PLUGIN_NAME, $plugin_settings, 'add_settings_tab_content');
		$this->loader->add_action( 'woocommerce_update_options_' . self::PLUGIN_NAME, $plugin_settings, 'update_settings' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_sales_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
