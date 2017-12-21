<?php
/**
 * Represents the view for the plugin settings page.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
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

<?php
$settings_tabs = Review_For_Criteria_Settings::$settings_tabs;
?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <h2 class="nav-tab-wrapper">
        <?php foreach ($settings_tabs as $tab_id => $tab) {?>
        <a href="#<?php echo $tab_id; ?>" class="nav-tab"><?php _e($tab, 'review-for-criteria');?></a>
        <?php }?>
    </h2>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables1 ui-sortable1">
                    <div class="postbox">
                        <div class="inside">
                            <?php settings_errors();?>

                            <form id="plugin-settings-form" action="options.php" method="POST">
                                <?php
settings_fields(Review_For_Criteria_Settings::$settings_group_id);
foreach ($settings_tabs as $tab_id => $tab) {
    echo '<div class="table ui-tabs-hide" id="' . $tab_id . '">';
    do_settings_sections($tab_id);
    echo '</div>';
}
submit_button();
?>
                            </form>

                        </div>
                    </div>
                </div>

            </div><!-- #post-body-content -->

            <!-- sidebar -->
            <?php include_once '_sidebar-right.php';?>
            <!-- end sidebar -->

        </div><!-- #post-body-->

        <div id="criteria-dialog" title="Create new criteria">
            <p class="validateTips">All form fields are required.</p>

            <form id="criteria-dialog-form">
                <table>
                    <tr>
                        <th><label for="name">Criteria</label></th>
                        <td>
                            <input type="text" name="criteria" id="criteria" class="text ui-widget-content ui-corner-all">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="explanation">Explanation</label></th>
                        <td>
                            <textarea name="explanation" id="explanation" cols="30" rows="10" class="text ui-widget-content ui-corner-all"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="weight">Weight</label></th>
                        <td><input type="number" name="weight" id="weight" class="text ui-widget-content ui-corner-all">%</td>
                    </tr>
                    <tr>
                        <td><input type="submit" tabindex="-1" style="position:absolute; top:-1000px"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>  <!-- #poststuff -->


</div>
