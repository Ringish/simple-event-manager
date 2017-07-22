<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SEM
 * @subpackage SEM/includes
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
 * @package    SEM
 * @subpackage SEM/includes
 * @author     Your Name <email@example.com>
 */
class SEM {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      SEM_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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

		$this->plugin_name = 'sem';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - SEM_Loader. Orchestrates the hooks of the plugin.
	 * - SEM_i18n. Defines internationalization functionality.
	 * - SEM_Admin. Defines all hooks for the admin area.
	 * - SEM_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sem-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sem-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sem-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sem-public.php';

		$this->loader = new SEM_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the SEM_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new SEM_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register post type(s) for plugin
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => _x( 'Events', 'post type general name', 'simple-event-manager' ),
			'singular_name'      => _x( 'Event', 'post type singular name', 'simple-event-manager' ),
			'menu_name'          => _x( 'Events', 'admin menu', 'simple-event-manager' ),
			'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'simple-event-manager' ),
			'add_new'            => _x( 'Add New', 'event', 'simple-event-manager' ),
			'add_new_item'       => __( 'Add New Event', 'simple-event-manager' ),
			'new_item'           => __( 'New Event', 'simple-event-manager' ),
			'edit_item'          => __( 'Edit Event', 'simple-event-manager' ),
			'view_item'          => __( 'View Event', 'simple-event-manager' ),
			'all_items'          => __( 'All Events', 'simple-event-manager' ),
			'search_items'       => __( 'Search Events', 'simple-event-manager' ),
			'parent_item_colon'  => __( 'Parent Events:', 'simple-event-manager' ),
			'not_found'          => __( 'No events found.', 'simple-event-manager' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'simple-event-manager' )
			);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'simple-event-manager' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'event' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			);

		register_post_type( 'event', $args );
	}

	/**
	 * Add meta boxes for event(s) for plugin
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_sem_meta_boxes() {
		add_meta_box(
    'sem-date',      // Unique ID
    esc_html__( 'Date', 'sem' ),    // Title
    array($this,'sem_date_meta_box'),   // Callback function
    'event',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
    );

		add_meta_box(
    'sem-fields',      // Unique ID
    esc_html__( 'Fields', 'sem' ),    // Title
    array($this,'sem_fields'),   // Callback function
    'event',         // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
    );

	}

	public function sem_date_meta_box() {
		wp_nonce_field( basename( __FILE__ ), 'sem_date_nonce' ); ?>
		<p>
			<label for="sem-date"><?php _e( "Date of event start.", 'sem' ); ?></label>
			<br />
			<input class="datepicker" type="text" name="sem_date" id="sem-date-input" value="<?php echo esc_attr( get_post_meta( get_the_id(), 'sem_date', true ) ); ?>" size="30" />
		</p>
		<?php
	}

	public function sem_fields() {
		wp_nonce_field( basename( __FILE__ ), 'sem_fields_nonce' ); ?>
		<p>
			<label><?php _e( "Add registration fields.", 'sem' ); ?></label>
			<br />
			<?php
			$fields = get_post_meta( get_the_id(), 'sem_custom_field', true );
			foreach ($fields as $field) {
				?>
				<input class="sem-custom-field" type="text" name="sem_custom_field[]"  value="<?php echo $field; ?>" size="30" placeholder="Field name" />
				<?php
			}
			?>
			<input class="sem-custom-field" type="text" name="sem_custom_field[]"  value="" size="30" placeholder="Field name" />
		</p>
		<a class="button add-field"><?php _e( "Add field", 'sem' ); ?></a>
		<?php
	}

	// Save the Metabox Data

	public function save_events_meta($post_id) {


	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.

		$keys = array('sem_custom_field','sem_date');
	// Add values of $events_meta as custom fields

	foreach ($keys as $key) { // Cycle through the $events_meta array!
		$value = $_POST[$key];
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		if(get_post_meta($post_id, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post_id, $key, $value);
		} else { // If the custom field doesn't have a value
		add_post_meta($post_id, $key, $value);
	}
		if(!$value) delete_post_meta($post_id, $key); // Delete if blank
	}

}


	/**
	* Register all of the hooks related to the admin area functionality
	* of the plugin.
	*
	* @since    1.0.0
	* @access   private
	*/
	private function define_admin_hooks() {

		$plugin_admin = new SEM_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $this, 'register_post_types' );
		$this->loader->add_action( 'add_meta_boxes', $this, 'add_sem_meta_boxes' );
		$this->loader->add_action( 'save_post', $this, 'save_events_meta');

	}

/**
* Register all of the hooks related to the public-facing functionality
* of the plugin.
*
* @since    1.0.0
* @access   private
*/
private function define_public_hooks() {

	$plugin_public = new SEM_Public( $this->get_plugin_name(), $this->get_version() );

	$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
* The name of the plugin used to uniquely identify it within the context of
* WordPress and to define internationalization functionality.
*
* @since     1.0.0
* @return    string    The name of the plugin.
*/
public function get_plugin_name() {
	return $this->plugin_name;
}

/**
* The reference to the class that orchestrates the hooks with the plugin.
*
* @since     1.0.0
* @return    SEM_Loader    Orchestrates the hooks of the plugin.
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
