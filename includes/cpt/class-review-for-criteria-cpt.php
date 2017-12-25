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
 * Register custom post types and taxonomies
 */
class Review_For_Criteria_CPT
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
     * List of all Custom Post Types to be registered
     *
     * @since    1.0.0
     *
     * @var      array
     */
    private static $cpt_list = array();

    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        self::load_cpt();
        add_action('init', array($this, 'register_cpt_and_taxonomies'));
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
     * Assign Custom Post Types to class variable.
     *
     * @since     1.0.0
     */
    private static function load_cpt()
    {
        $cpt = array(
            'entries' => array(
                'labels'             => array(
                    'name'               => _x('Entries', 'post type general name', RFC_PLUGIN_DOMAIN),
                    'singular_name'      => _x('Entry', 'post type singular name', RFC_PLUGIN_DOMAIN),
                    'menu_name'          => _x('Entries', 'admin menu', RFC_PLUGIN_DOMAIN),
                    'name_admin_bar'     => _x('Entry', 'add new on admin bar', RFC_PLUGIN_DOMAIN),
                    'add_new'            => _x('Add New', 'entry', RFC_PLUGIN_DOMAIN),
                    'add_new_item'       => __('Add New Entry', RFC_PLUGIN_DOMAIN),
                    'new_item'           => __('New Entry', RFC_PLUGIN_DOMAIN),
                    'edit_item'          => __('Edit Entry', RFC_PLUGIN_DOMAIN),
                    'view_item'          => __('View Entry', RFC_PLUGIN_DOMAIN),
                    'all_items'          => __('All Entry', RFC_PLUGIN_DOMAIN),
                    'search_items'       => __('Search Entry', RFC_PLUGIN_DOMAIN),
                    'parent_item_colon'  => __('Parent Entries:', RFC_PLUGIN_DOMAIN),
                    'not_found'          => __('No Entries found.', RFC_PLUGIN_DOMAIN),
                    'not_found_in_trash' => __('No Entries found in Trash.', RFC_PLUGIN_DOMAIN),
                ),
                'description'        => __('Manage your entries', RFC_PLUGIN_DOMAIN),
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => false,
                'rewrite'            => array('slug' => 'entries'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => 25,
                'menu_icon'          => 'dashicons-layout',
                'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'post-formats'),
            ),
            'reviews' => array(
	            'labels'             => array(
		            'name'               => _x('Reviews', 'post type general name', RFC_PLUGIN_DOMAIN),
		            'singular_name'      => _x('Review', 'post type singular name', RFC_PLUGIN_DOMAIN),
		            'menu_name'          => _x('Reviews', 'admin menu', RFC_PLUGIN_DOMAIN),
		            'name_admin_bar'     => _x('Review', 'add new on admin bar', RFC_PLUGIN_DOMAIN),
		            'add_new'            => _x('Add New', 'entry', RFC_PLUGIN_DOMAIN),
		            'add_new_item'       => __('Add New Review', RFC_PLUGIN_DOMAIN),
		            'new_item'           => __('New Review', RFC_PLUGIN_DOMAIN),
		            'edit_item'          => __('Edit Review', RFC_PLUGIN_DOMAIN),
		            'view_item'          => __('View Review', RFC_PLUGIN_DOMAIN),
		            'all_items'          => __('All Review', RFC_PLUGIN_DOMAIN),
		            'search_items'       => __('Search Review', RFC_PLUGIN_DOMAIN),
		            'parent_item_colon'  => __('Parent Reviews:', RFC_PLUGIN_DOMAIN),
		            'not_found'          => __('No Reviews found.', RFC_PLUGIN_DOMAIN),
		            'not_found_in_trash' => __('No Reviews found in Trash.', RFC_PLUGIN_DOMAIN),
	            ),
	            'description'        => __('Manage your reviews', RFC_PLUGIN_DOMAIN),
	            'public'             => true,
	            'publicly_queryable' => true,
	            'show_ui'            => true,
	            'show_in_menu'       => true,
	            'query_var'          => false,
	            'rewrite'            => array('slug' => 'reviews'),
	            'capability_type'    => 'post',
	            'has_archive'        => false,
	            'hierarchical'       => false,
	            'menu_position'      => 25,
	            'menu_icon'          => 'dashicons-testimonial',
	            'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'post-formats'),
            ),
        );

        self::$cpt_list = $cpt;
    }

    /**
     * Register all Custom Post Types and Taxonomies.
     *
     * @since     1.0.0
     */
    public function register_cpt_and_taxonomies()
    {
        // Register CPT
        foreach (self::$cpt_list as $slug => $args) {
            register_post_type($slug, $args);
        }
    }

}

require_once RFC_PLUGIN_PATH . 'includes/admin/metaboxes/class-review-for-criteria-metaboxes.php';