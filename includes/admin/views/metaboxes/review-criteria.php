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
            <?php wp_editor($el_key_tab_value, $el_key_tab) ?>

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
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
    <?php
        $max_rating = 5;

        $overall = array(
            'max_review_weight' => 0,
            'rating' => 0,
            'weight' => 0,
            'value' => 0,
            'overall' => 0
        );
        foreach ($criteria as $crit):
            $crit_name = $this->criteria_prefix . str_replace(' ', '_', trim( strtolower($crit->criteria) ));
            $curr_val = get_post_meta($post->ID, '_' . $crit_name, true);
            $curr_val = $curr_val ? $curr_val : 0;
            $overall['max_review_weight'] += ($max_rating * $crit->weight);
            $overall['rating'] += ($curr_val * $crit->weight);
            $overall['weight'] += $crit->weight;
            $overall['value'] += $curr_val;
	        $overall['overall'] += ($crit->weight * $curr_val);
    ?>
            <tr>
                <td><?php echo $crit->criteria ?></td>
                <td><?php echo $crit->explanation ?></td>
                <td><?php echo $crit->weight ?>%</td>
                <td>
                    <?php rfc_star_rating($curr_val, $crit_name) ?>
                </td>
                <td><?php echo $curr_val; ?></td>
            </tr>

    <?php endforeach; ?>
    <?php
    $overall_review_rating_key = $this->criteria_prefix . $this->criteria_overall;
    $overall['overall_review_rating'] = $overall['rating'] / $overall['max_review_weight'];
    $overall_review_rating = $overall['overall_review_rating'];

    ?>
        <tr>
            <td>Overall Review Rating</td>
            <td> </td>
            <td> </td>
            <td>
                <input type="hidden" name="<?php echo $overall_review_rating_key ?>" value="<?php echo $overall['overall_review_rating']; ?>">
                <?php
                rfc_star_rating($overall_review_rating, 'rfc_sr', array(
                    'type' => 'overall_all',
                    'readonly' => true
                ));
                ?>
            </td>
            <td><?php echo $overall['overall_review_rating']; ?></td>
        </tr>
        </tbody>
    </table>
</div>