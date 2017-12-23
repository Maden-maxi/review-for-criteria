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
		'type' => 'simple', // simple | overall_all | overall_single
	));

	switch ($args['type']) {
		case 'overall_all':
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
	?>
	<fieldset class="rating<?php echo esc_attr($args['readonly'] ? ' rating-readonly' : '') ?>">
		<?php foreach ($args['stars'] as $index => $star): ?>
			<input type="radio"
					<?php
						if ($args['type'] === 'overall_single') {
							checked(in_range($current_value,$star['checked'] - 0.5, $star['checked'] ) );
						} else {
							checked($star['checked'], $current_value);
						}

					?>
				data-val="<?php echo esc_attr($star['value']) ?>"
			       id="<?php echo esc_attr($field_id) ?>_star<?php echo esc_attr($index) ?>"
			       name="<?php echo esc_attr($field_name) ?>"
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