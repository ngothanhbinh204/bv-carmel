<?php
function log_dump($data)
{
	ob_start();
	var_dump($data);
	$dump = ob_get_clean();

	$highlighted = highlight_string("<?php\n" . $dump . "\n?>", true);

$formatted = '
<pre>' . substr($highlighted, 27, -8) . '</pre>';

$custom_css = 'pre {position: static;
background: #ffffff80;
width: 100vw;
}
pre::-webkit-scrollbar{
width: 1rem;}';
$formatted_css = '<style>
' . $custom_css . '
</style>';
echo ($formatted_css . $formatted);
}

function empty_content($str)
{
return trim(str_replace('&nbsp;', '', strip_tags($str, '<img>'))) == '';
}

function carmel_render_dropfilter_basic($taxonomy, $args = array())
{
$defaults = array(
'label' => 'Danh mục',
'name' => 'service_term',
'placeholder' => 'Danh mục',
'selected' => 'all',
'all_label' => 'Tất cả',
'parent' => 0,
'class' => '',
'terms' => array(),
);

$args = wp_parse_args($args, $defaults);
$terms = $args['terms'];

if (empty($terms)) {
$terms = get_terms(array(
'taxonomy' => $taxonomy,
'hide_empty' => false,
'parent' => $args['parent'],
'orderby' => 'name',
'order' => 'ASC',
));
}

if (is_wp_error($terms) || empty($terms)) {
return '';
}

$selected_label = $args['placeholder'];
if ($args['selected'] && $args['selected'] !== 'all') {
$selected_term = get_term_by('slug', $args['selected'], $taxonomy);
if ($selected_term && !is_wp_error($selected_term)) {
$selected_label = $selected_term->name;
}
}

ob_start();
?>
<div class="dropfilter-basic <?php echo esc_attr($args['class']); ?>" data-dropfilter-basic
	data-taxonomy="<?php echo esc_attr($taxonomy); ?>">
	<button class="dropfilter-toggle" type="button" aria-expanded="false">
		<span class="selected-text"><?php echo esc_html($selected_label); ?></span>
		<i class="fa-solid fa-chevron-down"></i>
	</button>
	<input type="hidden" name="<?php echo esc_attr($args['name']); ?>"
		value="<?php echo esc_attr($args['selected']); ?>" data-dropfilter-input />
	<div class="dropfilter-menu">
		<ul>
			<li><a href="#" data-value="all"
					data-label="<?php echo esc_attr($args['all_label']); ?>"><?php echo esc_html($args['all_label']); ?></a>
			</li>
			<?php foreach ($terms as $term) : ?>
			<li>
				<a href="#" data-value="<?php echo esc_attr($term->slug); ?>"
					data-label="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
	return ob_get_clean();
}

function carmel_render_dropfilter_options($options = array(), $args = array())
{
	$defaults = array(
		'name' => 'dropfilter_value',
		'placeholder' => 'Chọn',
		'selected' => 'all',
		'all_label' => 'Tất cả',
		'class' => '',
	);

	$args = wp_parse_args($args, $defaults);

	if (empty($options)) {
		return '';
	}

	$selected_label = $args['placeholder'];
	if ($args['selected'] !== 'all') {
		foreach ($options as $option) {
			if (!isset($option['value'], $option['label'])) {
				continue;
			}

			if ($option['value'] === $args['selected']) {
				$selected_label = $option['label'];
				break;
			}
		}
	}

	ob_start();
	?>
<div class="dropfilter-basic <?php echo esc_attr($args['class']); ?>" data-dropfilter-basic>
	<button class="dropfilter-toggle" type="button" aria-expanded="false">
		<span class="selected-text"><?php echo esc_html($selected_label); ?></span>
		<i class="fa-solid fa-chevron-down"></i>
	</button>
	<input type="hidden" name="<?php echo esc_attr($args['name']); ?>"
		value="<?php echo esc_attr($args['selected']); ?>" data-dropfilter-input />
	<div class="dropfilter-menu">
		<ul>
			<li><a href="#" data-value="all"
					data-label="<?php echo esc_attr($args['all_label']); ?>"><?php echo esc_html($args['all_label']); ?></a>
			</li>
			<?php foreach ($options as $option) : ?>
			<?php if (!isset($option['value'], $option['label'])) {
						continue;
					} ?>
			<li>
				<a href="#" data-value="<?php echo esc_attr($option['value']); ?>"
					data-label="<?php echo esc_attr($option['label']); ?>"><?php echo esc_html($option['label']); ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php

	return ob_get_clean();
}

function carmel_get_specialty_options_with_doctors()
{
	$specialty_posts = get_posts(array(
		'post_type' => 'chuyen-khoa',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	));

	if (empty($specialty_posts)) {
		return array();
	}

	$options = array();
	foreach ($specialty_posts as $specialty_post) {
		$doctor_rel = get_field('specialty_doctors', $specialty_post->ID);
		if (empty($doctor_rel)) {
			continue;
		}

		$options[] = array(
			'value' => $specialty_post->post_name,
			'label' => $specialty_post->post_title,
		);
	}

	return $options;
}

function carmel_get_doctor_ids_by_specialty_slug($specialty_slug)
{
	if (!$specialty_slug || $specialty_slug === 'all') {
		return array();
	}

	$specialty_post = get_page_by_path($specialty_slug, OBJECT, 'chuyen-khoa');
	if (!$specialty_post) {
		return array();
	}

	$doctor_rel = get_field('specialty_doctors', $specialty_post->ID);
	if (empty($doctor_rel)) {
		return array();
	}

	$doctor_ids = array();
	foreach ($doctor_rel as $doctor_item) {
		$doctor_ids[] = is_object($doctor_item) ? (int) $doctor_item->ID : (int) $doctor_item;
	}

	$doctor_ids = array_values(array_unique(array_filter($doctor_ids)));
	return $doctor_ids;
}

function carmel_get_doctor_specialty_names($doctor_id)
{
	$doctor_id = (int) $doctor_id;
	if (!$doctor_id) {
		return array();
	}

	$specialty_query = new WP_Query(array(
		'post_type' => 'chuyen-khoa',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'meta_query' => array(
			array(
				'key' => 'specialty_doctors',
				'value' => '"' . $doctor_id . '"',
				'compare' => 'LIKE',
			),
		),
	));

	if (!$specialty_query->have_posts()) {
		return array();
	}

	$names = array();
	foreach ($specialty_query->posts as $specialty_id) {
		$names[] = get_the_title($specialty_id);
	}

	wp_reset_postdata();
	return array_values(array_filter($names));
}

function carmel_render_doctor_pagination($current_page, $total_pages)
{
	$current_page = max(1, (int) $current_page);
	$total_pages = max(1, (int) $total_pages);

	if ($total_pages <= 1) {
		return '';
	}

	ob_start();
	?>
<div class="button-pagination" data-doctor-pagination>
	<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
	<button class="btn-pagination <?php echo $i === $current_page ? 'active' : ''; ?>" type="button"
		data-page="<?php echo esc_attr($i); ?>"><span><?php echo esc_html($i); ?></span></button>
	<?php endfor; ?>
</div>
<?php
	return ob_get_clean();
}

function carmel_build_doctor_query($keyword = '', $specialty_slug = 'all', $paged = 1)
{
	$paged = max(1, (int) $paged);

	$query_args = array(
		'post_type' => 'bac-si',
		'post_status' => 'publish',
		'posts_per_page' => 12,
		'paged' => $paged,
		'orderby' => 'date',
		'order' => 'DESC',
	);

	if ($keyword !== '') {
		$query_args['s'] = $keyword;
	}

	if ($specialty_slug !== 'all' && $specialty_slug !== '') {
		$doctor_ids = carmel_get_doctor_ids_by_specialty_slug($specialty_slug);
		if (empty($doctor_ids)) {
			$query_args['post__in'] = array(0);
		} else {
			$query_args['post__in'] = $doctor_ids;
			$query_args['orderby'] = 'post__in';
		}
	}

	return new WP_Query($query_args);
}

function carmel_ajax_search_specialties()
{
	$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
	if (!wp_verify_nonce($nonce, 'carmel_specialty_search_nonce')) {
		wp_die();
	}

	$keyword = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';

	$query_args = array(
		'post_type' => 'chuyen-khoa',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order' => 'DESC',
	);

	if ($keyword !== '') {
		$query_args['s'] = $keyword;
	}

	$specialty_query = new WP_Query($query_args);

	if ($specialty_query->have_posts()) {
		while ($specialty_query->have_posts()) {
			$specialty_query->the_post();
			get_template_part('template-parts/component/card', 'outstanding');
		}
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__('Khong tim thay chuyen khoa phu hop.', 'canhcamtheme') . '</p>';
	}

	wp_die();
}
add_action('wp_ajax_carmel_search_specialties', 'carmel_ajax_search_specialties');
add_action('wp_ajax_nopriv_carmel_search_specialties', 'carmel_ajax_search_specialties');

function carmel_ajax_filter_services()
{
	$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
	if (!wp_verify_nonce($nonce, 'carmel_service_archive_nonce')) {
		wp_die();
	}

	$term_slug = isset($_POST['term']) ? sanitize_text_field(wp_unslash($_POST['term'])) : 'all';
	$topic_slug = isset($_POST['topic']) ? sanitize_text_field(wp_unslash($_POST['topic'])) : 'all';
	$keyword = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';

	$query_args = array(
		'post_type' => 'dich-vu',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	);

	$tax_query = array();

	if ($term_slug !== 'all' && $term_slug !== '') {
		$tax_query[] = array(
			'taxonomy' => 'danh-muc-dich-vu',
			'field' => 'slug',
			'terms' => $term_slug,
		);
	}

	if ($topic_slug !== 'all' && $topic_slug !== '') {
		$tax_query[] = array(
			'taxonomy' => 'chu-de-dich-vu',
			'field' => 'slug',
			'terms' => $topic_slug,
		);
	}

	if (!empty($tax_query)) {
		if (count($tax_query) > 1) {
			$tax_query['relation'] = 'AND';
		}
		$query_args['tax_query'] = $tax_query;
	}

	if ($keyword !== '') {
		$query_args['s'] = $keyword;
	}

	$service_query = new WP_Query($query_args);

	if ($service_query->have_posts()) {
		while ($service_query->have_posts()) {
			$service_query->the_post();
			get_template_part('template-parts/component/card', 'service');
		}
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__('Không tìm thấy dịch vụ phù hợp.', 'canhcamtheme') . '</p>';
	}

	wp_die();
}
add_action('wp_ajax_carmel_filter_services', 'carmel_ajax_filter_services');
add_action('wp_ajax_nopriv_carmel_filter_services', 'carmel_ajax_filter_services');

function carmel_ajax_filter_doctors()
{
	$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
	if (!wp_verify_nonce($nonce, 'carmel_doctor_archive_nonce')) {
		wp_send_json_error(array('message' => 'Invalid nonce'));
	}

	$keyword = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
	$specialty_slug = isset($_POST['specialty']) ? sanitize_text_field(wp_unslash($_POST['specialty'])) : 'all';
	$paged = isset($_POST['paged']) ? (int) $_POST['paged'] : 1;

	$doctor_query = carmel_build_doctor_query($keyword, $specialty_slug, $paged);

	ob_start();
	if ($doctor_query->have_posts()) {
		while ($doctor_query->have_posts()) {
			$doctor_query->the_post();
			get_template_part('template-parts/component/card', 'doctor');
		}
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__('Không tìm thấy bác sĩ phù hợp.', 'canhcamtheme') . '</p>';
	}
	$grid_html = ob_get_clean();

	$pagination_html = carmel_render_doctor_pagination($paged, (int) $doctor_query->max_num_pages);

	wp_send_json_success(array(
		'grid' => $grid_html,
		'pagination' => $pagination_html,
	));
}
add_action('wp_ajax_carmel_filter_doctors', 'carmel_ajax_filter_doctors');
add_action('wp_ajax_nopriv_carmel_filter_doctors', 'carmel_ajax_filter_doctors');

?>