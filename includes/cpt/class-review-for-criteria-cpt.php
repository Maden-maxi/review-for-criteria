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
                    'name'               => _x('Entries', 'post type general name', 'review-for-criteria'),
                    'singular_name'      => _x('Entry', 'post type singular name', 'review-for-criteria'),
                    'menu_name'          => _x('Entries', 'admin menu', 'review-for-criteria'),
                    'name_admin_bar'     => _x('Entry', 'add new on admin bar', 'review-for-criteria'),
                    'add_new'            => _x('Add New', 'entry', 'review-for-criteria'),
                    'add_new_item'       => __('Add New Entry', 'review-for-criteria'),
                    'new_item'           => __('New Entry', 'review-for-criteria'),
                    'edit_item'          => __('Edit Entry', 'review-for-criteria'),
                    'view_item'          => __('View Entry', 'review-for-criteria'),
                    'all_items'          => __('All Entry', 'review-for-criteria'),
                    'search_items'       => __('Search Entry', 'review-for-criteria'),
                    'parent_item_colon'  => __('Parent Entries:', 'review-for-criteria'),
                    'not_found'          => __('No Entries found.', 'review-for-criteria'),
                    'not_found_in_trash' => __('No Entries found in Trash.', 'review-for-criteria'),
                ),
                'description'        => __('Manage your entries', 'review-for-criteria'),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => false,
                'rewrite'            => array('slug' => 'entries'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => 25,
                'menu_icon'          => 'dashicons-layout',
                'supports'           => array('title'),
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
