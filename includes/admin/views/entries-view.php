<?php
/**
 * Review for criteria.
 *
 * @package   Review_For_Criteria_List
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

<div class="wrap">

    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
        <a href="<?php echo admin_url('admin.php?page=' . $this->plugin_slug . '-entry-add') ?>" class="page-title-action"><?php _e('Add New', 'review-for-criteria');?></a>
    </h1>


    <form id="review-for-criteria-filter" method="post">

        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">

        <?php $review_for_criteria_list_table->display();?>

    </form>

</div>
