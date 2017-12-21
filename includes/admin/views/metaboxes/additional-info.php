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
	var_dump($query->post_count);
	?>
</div>