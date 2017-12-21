<table class="form-table company-info">
    <?php
    $storages = $this->reviews_meta_storage;
    $storage_prefix = $this->reviews_meta_prefix;
    ?>
	<tr>
		<th>
			<label for="review_storage">Storage</label>
		</th>
		<td>
            <?php foreach ($storages as $key => $storage):
                $el_key = $storage_prefix . $key;
	            $el_val = get_post_meta($post->ID, '_' . $el_key, true);
                ?>
			<input type="<?php echo $storage['type'] ?>" id="<?php echo $el_key ?>" name="<?php echo $el_key ?>" value="<?php echo $el_val ?>">
            <?php endforeach; ?>
		</td>
	</tr>

</table>
<div id="review_tabs">
    <?php
    $review_tabs = $this->reviews_meta_tabs;
    ?>
    <ul class="nav-tab-wrapper">
        <?php foreach ($review_tabs as $tab_key => $tab_value):
            $el_key = $this->reviews_meta_prefix . $tab_key;
        ?>
            <li><a href="#<?php echo $el_key . '_tab' ?>" class="nav-tab"><?php echo $tab_value['label'] ?></a></li>
        <?php endforeach; ?>

    </ul>
	<?php foreach ($review_tabs as $tab_key => $tab_value):
	$el_key_tab = $this->reviews_meta_prefix . $tab_key;
	$el_key_tab_value = get_post_meta($post->ID, '_' . $el_key_tab, true);

	?>
        <div id="<?php echo $el_key_tab . '_tab' ?>">
            <textarea name="<?php echo $el_key_tab ?>" id="<?php echo $el_key_tab ?>" cols="30" rows="10"><?php echo $el_key_tab_value ?></textarea>
        </div>
	<?php endforeach; ?>
</div>

<div id="review_criteria">
    <pre>
        <?php
            # var_dump($this->criteria);
            $criteria = $this->criteria;
        ?>
    </pre>
    <table class="form-table form-table-th-padding">
        <thead>
            <tr>
                <th>Criteria</th>
                <th>Explanation</th>
                <th>Weight</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
    <?php
        foreach ($criteria as $crit):
            $crit_name = $this->criteria_prefix . str_replace(' ', '_', trim( strtolower($crit->criteria) ));
            $curr_val = get_post_meta($post->ID, '_' . $crit_name, true);
    ?>
            <tr>
                <td><?php echo $crit->criteria ?></td>
                <td><?php echo $crit->explanation ?></td>
                <td><?php echo $crit->weight ?>%</td>
                <td>
                    <fieldset class="rating">
                        <input type="radio" <?php checked(5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star5" name="<?php echo esc_attr($crit_name) ?>" value="5" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star5" title="Awesome - 5 stars"></label>
                        <input type="radio" <?php checked(4.5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star4half" name="<?php echo esc_attr($crit_name) ?>" value="4.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" <?php checked(4, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star4" name="<?php echo esc_attr($crit_name) ?>" value="4" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" <?php checked(3.5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star3half" name="<?php echo esc_attr($crit_name) ?>" value="3.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" <?php checked(3, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star3" name="<?php echo esc_attr($crit_name) ?>" value="3" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star3" title="Meh - 3 stars"></label>
                        <input type="radio" <?php checked(2.5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star2half" name="<?php echo esc_attr($crit_name) ?>" value="2.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" <?php checked(2, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star2" name="<?php echo esc_attr($crit_name) ?>" value="2" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" <?php checked(1.5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star1half" name="<?php echo esc_attr($crit_name) ?>" value="1.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" <?php checked(1, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_star1" name="<?php echo esc_attr($crit_name) ?>" value="1" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" <?php checked(0.5, $curr_val) ?> id="<?php echo esc_attr($crit_name) ?>_starhalf" name="<?php echo esc_attr($crit_name) ?>" value="0.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
                </td>
            </tr>

    <?php endforeach; ?>
        </tbody>
    </table>
</div>