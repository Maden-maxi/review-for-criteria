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
            <?php foreach ($criterias as $value): ?>
            <tr>
                <td><?php echo $value->criteria ?></td>
                <td><?php echo $value->explanation ?></td>
                <td><?php echo $value->weight ?></td>
                <td>
                    <?php
                    $crit_name = $crit_key . str_replace(' ', '_', trim( strtolower($value->criteria) ));
                    $overall_review_criteria_rating = $value->value / $query->post_count;
                    // $overall_review_criteria_rating = round($overall_review_criteria_rating * 10);
                    rfc_star_rating($overall_review_criteria_rating, $crit_name, array(
	                    'readonly' => true,
	                    'type' => 'overall_single'
                    ));
                    ?>
                </td>
                <td><?php echo $overall_review_criteria_rating; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td>Overall Storage Rating</td>
                <td></td>
                <td></td>
                <td>
                    <?php
                    $overall_review_rating = $ov / $query->post_count;
                    $overall_review_rating = round($overall_review_rating * 10);

                    $orr_key = 'star';
                    rfc_star_rating($overall_review_rating, $orr_key, array(
                        'readonly' => true,
                        'type' => 'overall_all'
                    ));
                    ?>
                </td>
                <td>
                    <?php  echo $ov / $query->post_count; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>