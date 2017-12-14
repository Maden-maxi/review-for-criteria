<?php
/**
 * Right sidebar for settings page
 *
 * @package   Review_For_Criteria_Admin
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
?>


<div id="postbox-container-1" class="postbox-container sidebar-right">
    <div class="meta-box-sortables">
        <div class="postbox">
            <h3><span><?php esc_attr_e('Get help', 'review-for-criteria');?></span></h3>
            <div class="inside">
                <div>
                    <ul>
                        <li><a class="no-underline" target="_blank" href="http://yourcompany.com/plugins/review-for-criteria"><span class="dashicons dashicons-admin-home"></span> <?php esc_attr_e('Plugin Homepage', 'review-for-criteria');?></a></li>
                    </ul>
                </div>
                <div class="sidebar-footer">
                    &copy; <?php echo date('Y'); ?> <a class="no-underline text-highlighted" href="http://yourcompany.com" title="Your Company" target="_blank">Your Company</a>
                </div>
            </div>
        </div>
    </div>
</div>
