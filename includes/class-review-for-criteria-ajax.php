<?php
/**
 * Review for criteria.
 *
 * @package   Review_For_Criteria_AJAX
 * @author    Your Company
 * @license   GPL-2.0+
 * @link      http://yourcompany.com
 * @copyright 2018 Your Company
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/

/**
 * Handle AJAX calls
 */
class Review_For_Criteria_AJAX
{

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class
     *
     * @since     1.0.0
     */
    private function __construct()
    {

        // Backend AJAX calls
        if (current_user_can('manage_options')) {
            add_action('wp_ajax_admin_backend_call', array($this, 'ajax_backend_call'));
	        add_action('wp_ajax_admin_get_storages_call', array($this, 'ajax_get_storages_call'));
        }

        // Frontend AJAX calls
        add_action('wp_ajax_admin_frontend_call', array($this, 'ajax_frontend_call'));
        add_action('wp_ajax_nopriv_frontend_call', array($this, 'ajax_frontend_call'));

    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Handle AJAX: Backend Example
     *
     * @since    1.0.0
     */
    public function ajax_backend_call()
    {

        // Security check
        check_ajax_referer('reviews', 'security');

        $response = 'OK';
        // Send response in JSON format
        // wp_send_json( $response );
        // wp_send_json_error();
        wp_send_json_success($response);

        die();
    }
	public function ajax_get_storages_call()
	{

		// Security check
		check_ajax_referer('reviews', 'security');
		$args = array(
			's'         => trim( esc_attr( strip_tags( $_POST['s'] ) ) ),
			'post_type' => 'entries',
			'fields' => array('id', 'post_name'),
		);
		$query = new WP_Query($args);
		$items = array();
		while ($query->have_posts()): $query->the_post();
			$items[] = array('value' => get_the_ID(), 'label' => get_the_title());
		endwhile;
		wp_reset_postdata();
		// Send response in JSON format
		// wp_send_json( $response );
		// wp_send_json_error();
		wp_send_json_success($items);

		die();
	}

    /**
     * Handle AJAX: Frontend Example
     *
     * @since    1.0.0
     */
    public function ajax_frontend_call()
    {

        // Security check
        check_ajax_referer('referer_id', 'nonce');

        $response = 'OK';
        // Send response in JSON format
        // wp_send_json( $response );
        // wp_send_json_error();
        wp_send_json_success($response);

        die();
    }

}
