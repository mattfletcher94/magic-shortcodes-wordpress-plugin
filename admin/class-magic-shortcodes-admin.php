<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Magic_Shortcodes
 * @subpackage Magic_Shortcodes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Magic_Shortcodes
 * @subpackage Magic_Shortcodes/admin
 * @author     Matt Fletcher <mattfletcher94@outlook.com>
 */
class Magic_Shortcodes_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ($_GET['page'] == 'magic-shortcodes-admin') {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/style.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ($_GET['page'] == 'magic-shortcodes-admin') {
			wp_enqueue_script( 'prism', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js', array(), $this->version, true);
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/main.js', array(), $this->version, true);
			wp_localize_script($this->plugin_name, 'magic_shortcodes_ajax', array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('ajax-nonce')
			));
		}
	}

	/** 
	 * Register menu items for the admin area.
	 * 
	 * @since    1.0.0
	 */
	public function register_menu() {
		add_menu_page(
			'Magic Shortcodes', 
			'Magic Shortcodes', 
			'manage_options', 
			$this->plugin_name . '-admin', 
			array($this, 'render_plugin'), 
			'data:image/svg+xml;base64,' . base64_encode('<svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'), 
			100
		);
	}

	/**
	 * Render ajax fucntions
	 * 
	 * @since    1.0.0
	 */
	public function register_ajax() {

		// Get pages
		add_action("wp_ajax_magic_shortcodes_get_pages", function () {
			$this->auth_middleware($_POST['nonce']);
			$pages = new WP_Query(array('post_type' => 'any'));
			$response = $pages->posts;
			echo json_encode($response);
			die();
		});

		// Create popup
		add_action("wp_ajax_magic_shortcodes_create_popup", function () {
			
			// Run auth middleware
			$this->auth_middleware($_POST['nonce']);

			// Get and sanitize popup details
			$popupDetails = $this->sanitize_popup($_POST['popup']) ?? null;

			// If no popup details were provided.
			if (!$popupDetails) {
				echo json_encode(array(
					'success' => false,
					'message' => 'No popup details provided.',
				));
				die();
			}

			// Get popups
			$popups = get_option('magic_shortcodes_popups', array());
			$popups = $popups ? $popups : array();

			// Do some validation
			if (!$popupDetails->title) {
				echo json_encode(array(
					'success' => false,
					'message' => 'Title is required.',
				));
				die();
			}

			// Add unique id
			$id = strval(time());
			$popupDetails->id = $id;

			// Default popup options
			$defaults = array(
				'id' => $id,
				'title' => 'Popup',
				'content' => '',
				'displayFrequency' => 'session',
				'openingDelay' => 5,
				'buttonEnabled' => false,
				'buttonLabel' => '',
				'buttonURL' => '',
				'buttonBackgroundColor' => '#6f47e5',
				'buttonTextColor' => '#FFFFFF',
				'backdropColor' => '#000000',
				'backdropOpacity' => 70,
				'maxWidth' => 600,
				'roundedCornersEnabled' => true,
				'showOnAllPages' => true,
				'showOnThesePages' => array(),
				'testModeEnabled' => false,
				'deactivated' => false
			);

			// Merge popoup details
			array_push($popups, $popupDetails);

			// Update option
			update_option("magic_shortcodes_popups", $popups);

			// Echo response
			echo json_encode(array(
				'success' => true,
				'message' => 'Popup added succesfully.',
				'popupDetails' => $popupDetails,
			), JSON_UNESCAPED_SLASHES);
			die();
		});

		// Get popups
		add_action("wp_ajax_magic_shortcodes_get_popups", function () {
			$this->auth_middleware($_POST['nonce']);
			$popups = get_option('magic_shortcodes_popups', array());
			$popups = $popups ? $popups : array();
			echo json_encode($popups);
			die();
		});

		// Get popup by id
		add_action("wp_ajax_magic_shortcodes_get_popup_by_id", function () {

			// Check auth
			$this->auth_middleware($_POST['nonce']);

			// Sanitize id
			$id = sanitize_text_field($_POST['id']) ?? null;

			// If no id was provided.
			if (!$id) {
				echo json_encode(array(
					'success' => false,
					'message' => 'No popup id provided.',
				));
				die();
			}

			// Get popups
			$popups = get_option('magic_shortcodes_popups', array());
			$popups = $popups ? $popups : array();
			$popup = null;
			foreach ($popups as $p) {
				if ($p->id == $id) {
					$popup = $p;
					break;
				}
			}

			// Check if this popup exists
			if (!$popup) { 
				echo json_encode(array(
					'success' => false,
					'message' => 'Popup does not exist.',
				));
				die();
			}

			// Popup was found.
			echo json_encode(array(
				'success' => true,
				'message' => 'Popup found.',
				'popupDetails' => $popup,
			));
			die();
		});

		// Update popup
		add_action("wp_ajax_magic_shortcodes_update_popup", function () {
			$this->auth_middleware($_POST['nonce']);

			// If no popup details were provided.
			$popupDetails = $this->sanitize_popup($_POST['popup']) ?? null;
			if (!$popupDetails) {
				echo json_encode(array(
					'success' => false,
					'message' => 'No popup details provided.',
				));
				die();
			}

			// Get popups
			$popups = get_option('magic_shortcodes_popups', array());
			$popups = $popups ? $popups : array();

			// Do some validation
			if (!$popupDetails->title) {
				echo json_encode(array(
					'success' => false,
					'message' => 'Title is required.',
				));
				die();
			}

			// Find popup and replace with this
			$popup_found = false;
			for ($i = 0; $i < count($popups); $i++) {
				if ($popups[$i]->id == $popupDetails->id) {
					$popup_found = true;
					$popups[$i] = $popupDetails;
					break;
				}
			}

			// If popup was never found, let user know.
			if (!$popup_found) {
				echo json_encode(array(
					'success' => false,
					'message' => 'Popup does not exist.',
				));
				die();
			}

			// Update option
			update_option("magic_shortcodes_popups", $popups);

			// Echo response
			echo json_encode(array(
				'success' => true,
				'message' => 'Popup added succesfully.',
				'popupDetails' => $popupDetails,
			), JSON_UNESCAPED_SLASHES);
			die();

		});

		// Delete popup
		add_action("wp_ajax_magic_shortcodes_delete_popup", function () {
			$this->auth_middleware($_POST['nonce']);

			// Get popup id
			$id = sanitize_text_field($_POST['id']) ?? null;
			if (!$id) {
				echo json_encode(array(
					'success' => false,
					'message' => 'No popup id provided.',
				));
				die();
			}

			// Get popups
			$popups = get_option('magic_shortcodes_popups', array());
			$popups = $popups ? $popups : array();

			// Remove popup from array
			$new_popups_array = array();
			foreach ($popups as $popup) {
				if ($popup->id != $id) {
					array_push($new_popups_array, $popup);
				}
			}

			// Update option
			update_option("magic_shortcodes_popups", $new_popups_array);

			// Echo response
			echo json_encode(array(
				'success' => true,
				'message' => 'Popup deleted succesfully.',
			));
			die();
		});
	}

	/** 
	 * Authentaction middleware
	 * Ensures that the user is logged in and has the correct permissions.
	 */
	public function auth_middleware($nonce) {
		if (!wp_verify_nonce(sanitize_text_field($nonce), 'ajax-nonce')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Unauthorized.',
			));
			die();
		}
		if (!current_user_can('manage_options')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Unauthorized.',
			));
			die();
		}
	}

	/**
	 * Sanitize popup details.
	 */
	public function sanitize_popup($popupDetails) {
		if (!$popupDetails) {
			return null;
		}
		$popupDetailsJSON = json_decode(stripslashes($popupDetails));
		$popupDetailsSanitized = new stdClass();
		$popupDetailsSanitized->id = sanitize_text_field($popupDetailsJSON->id ? $popupDetailsJSON->id : '');
		$popupDetailsSanitized->title = wp_kses_post($popupDetailsJSON->title);
		$popupDetailsSanitized->content = wp_kses_post($popupDetailsJSON->content);
		$popupDetailsSanitized->displayFrequency = sanitize_text_field($popupDetailsJSON->displayFrequency);
		$popupDetailsSanitized->openingDelay = intval($popupDetailsJSON->openingDelay);
		$popupDetailsSanitized->buttonEnabled = boolval($popupDetailsJSON->buttonEnabled);
		$popupDetailsSanitized->buttonLabel = sanitize_text_field($popupDetailsJSON->buttonLabel);
		$popupDetailsSanitized->buttonURL = sanitize_text_field($popupDetailsJSON->buttonURL);
		$popupDetailsSanitized->buttonBackgroundColor = sanitize_text_field($popupDetailsJSON->buttonBackgroundColor);
		$popupDetailsSanitized->buttonTextColor = sanitize_text_field($popupDetailsJSON->buttonTextColor);
		$popupDetailsSanitized->backdropColor = sanitize_text_field($popupDetailsJSON->backdropColor);
		$popupDetailsSanitized->backdropOpacity = floatval($popupDetailsJSON->backdropOpacity);
		$popupDetailsSanitized->maxWidth = intval($popupDetailsJSON->maxWidth);
		$popupDetailsSanitized->roundedCornersEnabled = boolval($popupDetailsJSON->roundedCornersEnabled);
		$popupDetailsSanitized->showOnAllPages = boolval($popupDetailsJSON->showOnAllPages);
		$popupDetailsSanitized->testModeEnabled = boolval($popupDetailsJSON->testModeEnabled);
		$popupDetailsSanitized->deactivated = boolval($popupDetailsJSON->deactivated);
		$popupDetailsSanitized->showOnThesePages = $popupDetailsJSON->showOnThesePages ? $popupDetailsJSON->showOnThesePages : array();
		for ($i = 0; $i < count($popupDetailsSanitized->showOnThesePages); $i++) {
			$popupDetailsSanitized->showOnThesePages[$i] = intval($popupDetailsSanitized->showOnThesePages[$i]);
		}
		return $popupDetailsSanitized;
	} 

	public function render_plugin() {
		include_once(plugin_dir_path(__FILE__) . 'magic-shortcodes-admin-display.php');
	}

}
