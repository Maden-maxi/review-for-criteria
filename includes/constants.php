<?php
function in_range($n, $min, $max) {
	return $n <= $max && $n > $min;
}
function rfc_star_rating($current_value, $field_name = 'rfc_star_rating', $args = array()) {
	$field_id = uniqid('rfc');
	$stars = array(
		array(
			'checked' => 0.5,
			'value' => 0.5,
			'title' => __('Sucks big time - 0.5 stars')
		),
		array(
			'checked' => 1,
			'value' => 1,
			'title' => __('Sucks big time - 1 star')
		),
		array(
			'checked' => 1.5,
			'value' => 1.5,
			'title' => __('Meh - 1.5 stars')
		),
		array(
			'checked' => 2,
			'value' => 2,
			'title' => __('Kinda bad - 2 stars')
		),
		array(
			'checked' => 2.5,
			'value' => 2.5,
			'title' => __('Kinda bad - 2.5 stars')
		),
		array(
			'checked' => 3,
			'value' => 3,
			'title' => __('Meh - 3 stars')
		),
		array(
			'checked' => 3.5,
			'value' => 3.5,
			'title' => __('Meh - 3.5 stars')
		),
		array(
			'checked' => 4,
			'value' => 4,
			'title' => __('Pretty good - 4 stars')
		),
		array(
			'checked' => 4.5,
			'value' => 4.5,
			'title' => __('Pretty good - 4.5 stars')
		),
		array(
			'checked' => 5,
			'value' => 5,
			'title' => __('Awesome - 5 stars')
		),
	);

	$args = wp_parse_args($args, array(
		'readonly' => false,
		'stars' => $stars,
		'type' => 'simple', // simple | overall_all | overall_single,
        'size' => 0
	));


	switch ($args['type']) {
		case 'overall_all':
			$current_value = round($current_value * 10);
			foreach ($args['stars'] as $i => $star) {
				$v = $i + 1;
				$args['stars'][$i]['checked'] = $v;
				$args['stars'][$i]['value'] = $v;
			}
			break;
		case 'overall_single':
			foreach ($args['stars'] as $i => $star) {
				$v = $star['value'] - 0.5;
			}
			break;
	}

	$args['stars'] = array_reverse($args['stars']);
	$toggler = true;
	$size = $args['size'] ? ' rating_x' . $args['size'] : '';
	?>
	<fieldset class="rating<?php echo esc_attr($args['readonly'] ? ' rating-readonly' : '') . $size ?>">
		<?php foreach ($args['stars'] as $index => $star): ?>
			<input type="radio"
					<?php
                        $name_attr = $field_name ? ' name="' . esc_attr($field_name) . '" ' : '';
						if ($args['type'] === 'overall_single') {
							checked(in_range($current_value,$star['checked'] - 0.5, $star['checked'] ) );
						} else {
							checked($star['checked'], $current_value);
						}

					?>
                   data-val="<?php echo esc_attr($star['value']) ?>"
                   data-current="<?php echo esc_attr($current_value) ?>"
			       id="<?php echo esc_attr($field_id) ?>_star<?php echo esc_attr($index) ?>"
			       <?php echo $name_attr ?>
			       value="<?php echo esc_attr($star['value']) ?>" />
			<label class ="<?php echo esc_attr($toggler ? 'full' : 'half'); ?>"
			       for="<?php echo esc_attr($field_id) ?>_star<?php echo esc_attr($index) ?>"
			       title="<?php echo esc_attr($star['title']) ?>"></label>
		<?php
		$toggler = !$toggler;
		endforeach;
		?>
	</fieldset>
	<?php
}

function rfc_table_star_rating($post_id) {

$criteria = json_decode(get_option('review_for_criteria_options'));
?>
<table class="rfc-star-rating-table">
    <tr>
        <th colspan="2">Editor's Rating</th>
    </tr>
	<?php
	foreach ($criteria as $k => $v): ?>
		<?php
		$crit_name = 'criteria_' . str_replace(' ', '_', trim( strtolower($v->criteria) ));
		$rating = $curr_val = get_post_meta($post_id, '_' . $crit_name, true);
		?>
        <tr>
            <td><?php echo $v->criteria ?></td>
            <td>
				<?php rfc_star_rating($rating, '', array(
					'readonly' => true
				)); ?>
            </td>
        </tr>
	<?php endforeach; ?>
    <tr>
        <td>Overall Rating</td>
        <td>
			<?php
			$rating = get_post_meta($post_id, '_criteria_overall', true);

			rfc_star_rating($rating, 'rfc_stars', array(
				'type' => 'overall_all',
				'readonly' => true
			)); ?>
        </td>
    </tr>
</table>
<?php
}