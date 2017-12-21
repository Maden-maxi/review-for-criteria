<?php
/**
 * @package   Review_For_Criteria
 * @author    Your Company
 * @license   GPL-2.0+
 * @link      http://yourcompany.com
 * @copyright 2018 Your Company
 *
 * @wordpress-plugin
 * Plugin Name:       Review for criteria
 * Plugin URI:        http://yourcompany.com/plugins/review-for-criteria
 * Description:       Plugin Description
 * Version:           1.0.0
 * Author:            Your Company
 * Author URI:        http://yourcompany.com
 * Text Domain:       review-for-criteria
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/
/*----------------------------------------------------------------------------*
 * Plugin Constants
 *----------------------------------------------------------------------------*/
define('RFC_PLUGIN_PATH', plugin_dir_path(__FILE__  ));
define('RFC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RFC_PLUGIN_DOMAIN', 'review-for-criteria');
/*----------------------------------------------------------------------------*
 * * * ATTENTION! * * *
 * FOR DEVELOPMENT ONLY
 * SHOULD BE DISABLED ON PRODUCTION
 *----------------------------------------------------------------------------*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*----------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------*
 * Plugin Settings
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Settings ----- */
require_once RFC_PLUGIN_PATH . 'includes/class-review-for-criteria-settings.php';

register_activation_hook(__FILE__, array('Review_For_Criteria_Settings', 'activate'));
add_action('plugins_loaded', array('Review_For_Criteria_Settings', 'get_instance'));
/* ----- Module End: Settings ----- */

/*----------------------------------------------------------------------------*
 * Include extensions and CPT
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: CPT ----- */
require_once RFC_PLUGIN_PATH . 'includes/cpt/class-review-for-criteria-cpt.php';
add_action('plugins_loaded', array('Review_For_Criteria_CPT', 'get_instance'));
/* ----- Module End: CPT ----- */

/*----------------------------------------------------------------------------*
 * Custom DB Tables
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Database ----- */
require_once RFC_PLUGIN_PATH . 'includes/class-review-for-criteria-db.php';

register_activation_hook(__FILE__, array('Review_For_Criteria_DB', 'activate'));
add_action('plugins_loaded', array('Review_For_Criteria_DB', 'db_check'));
/* ----- Module End: Database ----- */

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once RFC_PLUGIN_PATH . 'includes/class-review-for-criteria.php';

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook(__FILE__, array('Review_For_Criteria', 'activate'));
register_deactivation_hook(__FILE__, array('Review_For_Criteria', 'deactivate'));

add_action('plugins_loaded', array('Review_For_Criteria', 'get_instance'));

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {

    /* ----- Plugin Module: CRUD ----- */
    require_once RFC_PLUGIN_PATH . 'includes/admin/class-review-for-criteria-admin-crud-list.php';
    /* ----- Module End: CRUD ----- */

    require_once RFC_PLUGIN_PATH . 'includes/admin/class-review-for-criteria-admin.php';
    add_action('plugins_loaded', array('Review_For_Criteria_Admin', 'get_instance'));

    require_once RFC_PLUGIN_PATH . 'includes/admin/class-review-for-criteria-admin-pages.php';
    add_action('plugins_loaded', array('Review_For_Criteria_Admin_Pages', 'get_instance'));

    require_once RFC_PLUGIN_PATH . 'includes/admin/class-review-for-criteria-admin-pages-crud.php';
    add_action('plugins_loaded', array('Review_For_Criteria_Admin_Pages_CRUD', 'get_instance'));

    require_once RFC_PLUGIN_PATH . 'includes/admin/class-review-for-criteria-admin-pages-settings.php';
    add_action('plugins_loaded', array('Review_For_Criteria_Admin_Pages_Settings', 'get_instance'));

}

/*----------------------------------------------------------------------------*
 * Register Plugin Shortcode
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Shortcode ----- */
// Admin Side
require_once RFC_PLUGIN_PATH . 'includes/shortcode/class-review-for-criteria-shortcode-admin.php';
add_action('plugins_loaded', array('Review_For_Criteria_Shortcode_Admin', 'get_instance'));

// Public Side
require_once RFC_PLUGIN_PATH . 'includes/shortcode/class-review-for-criteria-shortcode-public.php';
add_action('plugins_loaded', array('Review_For_Criteria_Shortcode_Public', 'get_instance'));
/* ----- Module End: Shortcode ----- */

/*----------------------------------------------------------------------------*
 * Handle AJAX Calls
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: AJAX ----- */
require_once RFC_PLUGIN_PATH . 'includes/class-review-for-criteria-ajax.php';
add_action('plugins_loaded', array('Review_For_Criteria_AJAX', 'get_instance'));
/* ----- Module End: AJAX ----- */
