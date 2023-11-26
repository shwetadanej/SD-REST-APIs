<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://shwetadanej.com
 * @since      1.0.0
 *
 * @package    Sd_Rest_Api
 * @subpackage Sd_Rest_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sd_Rest_Api
 * @subpackage Sd_Rest_Api/public
 * @author     Shweta Danej <shwetadanej@gmail.com>
 */
class Sd_Rest_Api_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sd_Rest_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sd_Rest_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sd-rest-api-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sd_Rest_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sd_Rest_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sd-rest-api-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Register custom post type for the REST API operations
	 *
	 * @return void
	 */
	public function sd_register_custom_post_type(){
		$labels = array(
			'name'                  => _x( 'Events', 'Post type general name', 'sd-rest-api' ),
			'singular_name'         => _x( 'Event', 'Post type singular name', 'sd-rest-api' ),
			'menu_name'             => _x( 'Events', 'Admin Menu text', 'sd-rest-api' ),
			'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'sd-rest-api' ),
			'add_new'               => __( 'Add New', 'sd-rest-api' ),
			'add_new_item'          => __( 'Add New event', 'sd-rest-api' ),
			'new_item'              => __( 'New event', 'sd-rest-api' ),
			'edit_item'             => __( 'Edit event', 'sd-rest-api' ),
			'view_item'             => __( 'View event', 'sd-rest-api' ),
			'all_items'             => __( 'All recipes', 'sd-rest-api' ),
			'search_items'          => __( 'Search recipes', 'sd-rest-api' ),
			'parent_item_colon'     => __( 'Parent recipes:', 'sd-rest-api' ),
			'not_found'             => __( 'No recipes found.', 'sd-rest-api' ),
			'not_found_in_trash'    => __( 'No recipes found in Trash.', 'sd-rest-api' )
		); 
		register_post_type('event', array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'custom-fields', 'author'),
		));
	}

	/**
	 * Register all the REST API end points
	 *
	 * @return void
	 */
	public function sd_register_cpt_rest_api_endpoints()
	{
		register_rest_route('demo/v1', '/events', array(
			'methods' => 'GET',
			'callback' => array($this, 'get_events'),
		));
	
		register_rest_route('demo/v1', '/events/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array($this, 'get_event'),
		));
	
		register_rest_route('demo/v1', '/events', array(
			'methods' => 'POST',
			'callback' => array($this, 'create_event'),
			'permission_callback' => array($this, 'is_user_permitted'),
		));
	
		register_rest_route('demo/v1', '/events/(?P<id>\d+)', array(
			'methods' => 'PUT',
			'callback' => array($this, 'update_event'),
			'permission_callback' => array($this, 'is_user_permitted'),
		));
	
		register_rest_route('demo/v1', '/events/(?P<id>\d+)', array(
			'methods' => 'DELETE',
			'callback' => array($this, 'delete_event'),
			'permission_callback' => array($this, 'is_user_permitted'),
		));
	}

	/**
	 * Get all the events
	 *
	 * @return object
	 */
	public function get_events() {
		$args = array(
			'post_type' => 'event',
			'posts_per_page' => -1,
		);
	
		$events = get_posts($args);
	
		$formatted_events = array();
	
		foreach ($events as $event) {
			$formatted_events[] = $this->format_event_response($event);
		}
	
		return rest_ensure_response($formatted_events);
	}
	
	/**
	 * Get single event
	 *
	 * @param array $data
	 * @return object
	 */
	public function get_event($data) {
		$event = get_post($data['id']);
	
		if (!$event || $event->post_type !== 'event') {
			return new WP_Error('event_not_found', 'Event not found', array('status' => 404));
		}
	
		$formatted_event = $this->format_event_response($event);
	
		return rest_ensure_response($formatted_event);
	}
	
	/**
	 * Create new event
	 *
	 * @param array $data
	 * @return object
	 */
	public function create_event($data) {
		$user = wp_get_current_user();
		if (!user_can($user, 'edit_posts')) {
			return new WP_Error('permission_error', 'Permission denied', array('status' => 403));
		}
	
		$new_event_id = wp_insert_post(array(
			'post_type' => 'event',
			'post_title' => sanitize_text_field($data['title']),
			'post_content' => sanitize_text_field($data['description']),
			'post_status' => 'publish',
			'meta_input' => array(
				'event_date' => sanitize_text_field($data['date']),
				'event_location' => sanitize_text_field($data['location']),
			),
		));
	
		if (is_wp_error($new_event_id)) {
			return $new_event_id;
		}
	
		$new_event = get_post($new_event_id);
		$formatted_event = $this->format_event_response($new_event);
	
		return rest_ensure_response($formatted_event);
	}
	
	/**
	 * Update event data by event ID
	 *
	 * @param array $data
	 * @return object
	 */
	public function update_event($data) {
		$user = wp_get_current_user();
		$event_id = $data['id'];
	
		if (!user_can($user, 'edit_posts') || !current_user_can('edit_post', $event_id)) {
			return new WP_Error('permission_error', 'Permission denied', array('status' => 403));
		}
	
		$event = get_post($event_id);
		$title = sanitize_text_field($data['title']);
		$description = sanitize_text_field($data['description']);
		$date = sanitize_text_field($data['date']);
		$location = sanitize_text_field($data['location']);
		$updated_event_id = wp_update_post(array(
			'ID' => $event_id,
			'post_title' => $title ? $title : $event->post_title,
			'post_content' => $description ? $description : $event->post_content,
			'post_status' => 'publish',
			'meta_input' => array(
				'event_date' => $date ? $date : get_post_meta($event_id, 'event_date', true),
				'event_location' => $location ? $location : get_post_meta($event_id, 'event_location', true),
			),
		));
	
		if (is_wp_error($updated_event_id)) {
			return $updated_event_id;
		}
	
		$updated_event = get_post($updated_event_id);
		$formatted_event = $this->format_event_response($updated_event);
	
		return rest_ensure_response($formatted_event);
	}
	
	/**
	 * Delete event record
	 *
	 * @param array $data
	 * @return object
	 */
	public function delete_event($data) {
		$user = wp_get_current_user();
		$event_id = $data['id'];
	
		if (!user_can($user, 'edit_posts') || !current_user_can('delete_post', $event_id)) {
			return new WP_Error('permission_error', 'Permission denied', array('status' => 403));
		}
	
		$result = wp_delete_post($event_id, true);
	
		if ($result === false) {
			return new WP_Error('delete_error', 'Error deleting event', array('status' => 500));
		}
	
		return rest_ensure_response(array('success' => true));
	}
	
	/**
	 * Formatted response to send to API response
	 *
	 * @param object $event
	 * @return array
	 */
	public function format_event_response($event) {
		return array(
			'id' => $event->ID,
			'title' => $event->post_title,
			'description' => $event->post_content,
			'date' => get_post_meta($event->ID, 'event_date', true),
			'location' => get_post_meta($event->ID, 'event_location', true),
		);
	}
	
	/**
	 * Validate user permissions
	 *
	 * @return void
	 */
	public function is_user_permitted() {
		return current_user_can('edit_posts');
	}

}
