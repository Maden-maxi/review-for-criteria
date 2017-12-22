<table class="form-table company-info">
    <?php foreach ($this->entries_meta as $key => $value):
        $key = $this->entries_meta_prefix . $key;
	    $v = get_post_meta( $post->ID, '_' . $key, true );
        ?>
        <tr>
            <th>
                <label for="<?php echo $key ?>"><?php _e($value['label'] . ':', RFC_PLUGIN_DOMAIN) ?> <span class="dashicons dashicons-<?php echo $value['icon'] ?> add-company-address"></span></label>
            </th>
            <td class="company-address-list">
                <input type="<?php echo $value['type'] ?>" id="<?php echo $key ?>" name="<?php echo $key ?>" value="<?php echo $v ?>">
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<div id="overall-rating">
	<?php
	$query = new WP_Query( array(
		'post_type' => 'reviews',
		'meta_query' => array(
			array(
				'key' => '_review_storage_value',
				'value' => $post->ID
			)
		)
	) );
	$crit_key = 'criteria_';
	$criterias = get_option('review_for_criteria_options') ? json_decode(get_option('review_for_criteria_options')) : [];


	foreach ($criterias as $criteria) {
		// $crit_name = $crit_key . str_replace(' ', '_', trim( strtolower($criteria->criteria) ));
		$criteria->value = 0;
    }


	$ov = 0;
	while ($query->have_posts()): $query->the_post();
        $v = get_post_meta(get_the_ID(), '_' . $crit_key . 'overall', true );
        if (is_numeric($v)) {
	        $ov += $v;
        }
        foreach ($criterias as $v) {
	        $crit_name = $crit_key . str_replace(' ', '_', trim( strtolower($v->criteria) ));
            $cv = get_post_meta(get_the_ID(), '_' . $crit_name, true );
            $v->value += $cv;
        }
        //echo get_the_ID() . ':' . $ov . '<br>';
    endwhile;
	wp_reset_postdata();
	?>
    <table class="form-table form-table-th-padding">
        <thead>
            <tr>
                <th>Criteria</th>
                <th>Explanation</th>
                <th>Weight</th>
                <th>Rating</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
        <?php
        function in_range($n, $min, $max) {
	        return $n <= $max && $n > $min;
        }
        ?>
            <?php foreach ($criterias as $value): ?>
            <tr>
                <td><?php echo $value->criteria ?></td>
                <td><?php echo $value->explanation ?></td>
                <td><?php echo $value->weight ?></td>
                <td>
                    <?php

                    $crit_name = $crit_key . str_replace(' ', '_', trim( strtolower($value->criteria) ));
                    $orrc_v = $value->value / $query->post_count;
                    // $orrc_v = round($orrc_v * 10);

                    ?>
                    <fieldset class="rating rating-readonly">
                        <input type="radio" <?php checked(in_range($orrc_v, 4.5, 5.5)) ?> id="<?php echo esc_attr($crit_name) ?>_star5" name="<?php echo esc_attr($crit_name) ?>_" value="5" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star5" title="Awesome - 5 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 4, 4.5)) ?> id="<?php echo esc_attr($crit_name) ?>_star4half" name="<?php echo esc_attr($crit_name) ?>_" value="4.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 3.5, 4)) ?> id="<?php echo esc_attr($crit_name) ?>_star4" name="<?php echo esc_attr($crit_name) ?>_" value="4" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 3, 3.5)) ?> id="<?php echo esc_attr($crit_name) ?>_star3half" name="<?php echo esc_attr($crit_name) ?>_" value="3.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 2.5, 3)) ?> id="<?php echo esc_attr($crit_name) ?>_star3" name="<?php echo esc_attr($crit_name) ?>_" value="3" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star3" title="Meh - 3 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 2, 2.5)) ?> id="<?php echo esc_attr($crit_name) ?>_star2half" name="<?php echo esc_attr($crit_name) ?>_" value="2.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 1.5, 2)) ?> id="<?php echo esc_attr($crit_name) ?>_star2" name="<?php echo esc_attr($crit_name) ?>_" value="2" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 1, 1.5)) ?> id="<?php echo esc_attr($crit_name) ?>_star1half" name="<?php echo esc_attr($crit_name) ?>_" value="1.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 0.5, 1)) ?> id="<?php echo esc_attr($crit_name) ?>_star1" name="<?php echo esc_attr($crit_name) ?>_" value="1" /><label class = "full" for="<?php echo esc_attr($crit_name) ?>_star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" <?php checked(in_range($orrc_v, 0, 0.5)) ?> id="<?php echo esc_attr($crit_name) ?>_starhalf" name="<?php echo esc_attr($crit_name) ?>_" value="0.5" /><label class="half" for="<?php echo esc_attr($crit_name) ?>_starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
                </td>
                <td><?php echo $orrc_v; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td>Overall Storage Rating</td>
                <td></td>
                <td></td>
                <td>
                    <?php
                    $orr_v = $ov / $query->post_count;
                    $orr_v = round($orr_v * 10);

                    $orr_key = 'star';
                    ?>
                    <fieldset class="rating rating-readonly">
                        <input type="radio" <?php checked(10, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star5" name="<?php echo esc_attr($orr_key) ?>_" value="5" /><label class = "full" for="<?php echo esc_attr($orr_key) ?>_star5" title="Awesome - 5 stars"></label>
                        <input type="radio" <?php checked(9, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star4half" name="<?php echo esc_attr($orr_key) ?>_" value="4.5" /><label class="half" for="<?php echo esc_attr($orr_key) ?>_star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" <?php checked(8, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star4" name="<?php echo esc_attr($orr_key) ?>_" value="4" /><label class = "full" for="<?php echo esc_attr($orr_key) ?>_star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" <?php checked(7, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star3half" name="<?php echo esc_attr($orr_key) ?>_" value="3.5" /><label class="half" for="<?php echo esc_attr($orr_key) ?>_star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" <?php checked(6, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star3" name="<?php echo esc_attr($orr_key) ?>_" value="3" /><label class = "full" for="<?php echo esc_attr($orr_key) ?>_star3" title="Meh - 3 stars"></label>
                        <input type="radio" <?php checked(5, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star2half" name="<?php echo esc_attr($orr_key) ?>_" value="2.5" /><label class="half" for="<?php echo esc_attr($orr_key) ?>_star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" <?php checked(4, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star2" name="<?php echo esc_attr($orr_key) ?>_" value="2" /><label class = "full" for="<?php echo esc_attr($orr_key) ?>_star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" <?php checked(3, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star1half" name="<?php echo esc_attr($orr_key) ?>_" value="1.5" /><label class="half" for="<?php echo esc_attr($orr_key) ?>_star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" <?php checked(2, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_star1" name="<?php echo esc_attr($orr_key) ?>_" value="1" /><label class = "full" for="<?php echo esc_attr($orr_key) ?>_star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" <?php checked(1, $orr_v) ?> id="<?php echo esc_attr($orr_key) ?>_starhalf" name="<?php echo esc_attr($orr_key) ?>_" value="0.5" /><label class="half" for="<?php echo esc_attr($orr_key) ?>_starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
                </td>
                <td>
                    <?php  echo $ov / $query->post_count; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>