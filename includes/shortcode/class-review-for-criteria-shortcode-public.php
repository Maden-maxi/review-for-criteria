<?php
/**
 * Review for criteria
 *
 * @package   Review_For_Criteria_Shortcode_Public
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
 * Handle Plugin Shortcode Public Side Features
 */
class Review_For_Criteria_Shortcode_Public
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
        /**
         * Call $plugin_slug from public plugin class.
         */
        $plugin               = Review_For_Criteria::get_instance();
        $this->plugin_slug    = $plugin->get_plugin_slug();
        $this->plugin_version = $plugin->get_plugin_version();
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
     * Render Shortcode [plugin_shorcode]
     *
     * @since     1.0.0
     */
    public function render_sc($atts, $content = "")
    {
        extract(shortcode_atts(array(
            'id' => '',
        ), $atts));

        $id = (int) $id;

        if (!$id) {
            return '';
        }

        $contentValue = $content ? $content : __('Review for criteria Shorcode', 'review-for-criteria');

        return '<span data-some-attr-id="' . $id . '" style="cursor:pointer;">' . $contentValue . '</span>';

    }

}

/**
 * Register [plugin_shorcode] shortcode
 *
 * usage: [plugin_shorcode id='entry-id']Preview[/plugin_shorcode]
 * or: [plugin_shorcode id='entry-id' /]
 *
 * @since    1.0.0
 */
add_shortcode('plugin_shorcode', array(Review_For_Criteria_Shortcode_Public::get_instance(), 'render_sc'));
