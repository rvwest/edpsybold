<?php
if ($query->have_posts()):
	global $wp_query;
	$wp_query->wpbdp_in_the_loop = true;

	$grouped_listings = array();

	// Group listings by 'methodology' field.
	while ($query->have_posts()) {
		$query->the_post();
		$listing_id = get_the_ID();

		$fields = wpbdp_get_form_fields();
		$methodology_value = '';

		foreach ($fields as $field) {
			if (strtolower($field->get_short_name()) === 'methodology') {
				$methodology_value = $field->plain_value($listing_id);
				break;
			}
		}

		if (is_array($methodology_value)) {
			$methodology_value = $methodology_value[0] ?? '';
		}

		$methodology_value = trim(strip_tags((string) $methodology_value));

		if (empty($methodology_value)) {
			$methodology_value = 'Other';
		}

		if (!isset($grouped_listings[$methodology_value])) {
			$grouped_listings[$methodology_value] = array();
		}

		$grouped_listings[$methodology_value][] = $listing_id;
	}

	// Output listings grouped by methodology.
	foreach ($grouped_listings as $methodology => $listing_ids):
		?>
		<h4><?php echo esc_html($methodology); ?></h4>
		<?php
		foreach ($listing_ids as $listing_id) {
			wpbdp_render_listing($listing_id, 'excerpt', 'echo');
		}
	endforeach;

	$wp_query->wpbdp_in_the_loop = false;

	if ($display_pagination_in_listings_wrapper):
		wpbdp_x_part(
			'parts/pagination',
			array('query' => $query)
		);
	endif;

else:
	?>
	<span class="no-listings">
		<?php esc_html_e('No listings found.', 'business-directory-plugin'); ?>
	</span>
	<?php
endif;
