<?php
$current_term = get_queried_object();
$current_term_slug = 'all';
$current_title = 'Danh sách các gói khám';
$current_category_label = 'Tất cả';

if ($current_term instanceof WP_Term && $current_term->taxonomy === 'danh-muc-dich-vu') {
	$current_term_slug = $current_term->slug;
	$current_title = $current_term->name;
	$current_category_label = $current_term->name;
}

$service_terms = get_terms(array(
	'taxonomy' => 'danh-muc-dich-vu',
	'hide_empty' => false,
	'parent' => 0,
	'orderby' => 'name',
	'order' => 'ASC',
));

$query_args = array(
	'post_type' => 'dich-vu',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
);

if ($current_term_slug !== 'all') {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'danh-muc-dich-vu',
			'field' => 'slug',
			'terms' => $current_term_slug,
		),
	);
}

$service_query = new WP_Query($query_args);

$topic_terms = array();
if ($current_term_slug !== 'all') {
	$service_ids = get_posts(array(
		'post_type' => 'dich-vu',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'tax_query' => array(
			array(
				'taxonomy' => 'danh-muc-dich-vu',
				'field' => 'slug',
				'terms' => $current_term_slug,
			),
		),
	));

	if (!empty($service_ids)) {
		$topic_terms = wp_get_object_terms($service_ids, 'chu-de-dich-vu', array(
			'hide_empty' => true,
			'orderby' => 'name',
			'order' => 'ASC',
		));
	}
}

if ($current_term_slug === 'all') {
	$topic_terms = get_terms(array(
		'taxonomy' => 'chu-de-dich-vu',
		'hide_empty' => true,
		'orderby' => 'name',
		'order' => 'ASC',
	));
}
?>
<section class="section-ServicesList" data-service-archive="wrapper"
	data-service-category="<?php echo esc_attr($current_term_slug); ?>">
	<div class="section-py">
		<div class="container">
			<?php if ($current_title): ?>
			<h2 class="heading-1 text-primary-1 mb-base"><?php echo esc_html($current_title); ?></h2>
			<?php endif; ?>

			<div class="filter-bar">
				<div class="filter-tags">
					<a class="tag-btn <?php echo $current_term_slug === 'all' ? 'active' : ''; ?>"
						href="<?php echo esc_url(get_post_type_archive_link('dich-vu')); ?>">Tất cả gói khám</a>
					<?php if (!is_wp_error($service_terms) && !empty($service_terms)) : ?>
					<?php foreach ($service_terms as $term) : ?>
					<a class="tag-btn <?php echo $current_term_slug === $term->slug ? 'active' : ''; ?>"
						href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class="filter-right">
					<?php if (!is_wp_error($topic_terms) && !empty($topic_terms)) : ?>
					<?php echo function_exists('carmel_render_dropfilter_basic') ? carmel_render_dropfilter_basic('chu-de-dich-vu', array(
							'label' => 'Chủ đề',
							'name' => 'service_topic',
							'selected' => 'all',
							'all_label' => 'Tất cả chủ đề',
							'terms' => $topic_terms,
							'placeholder' => 'Chủ đề',
						)) : ''; ?>
					<?php endif; ?>
					<button class="btn-search" type="button" data-service-search="button"><span>Tìm kiếm</span><span
							class="material-symbols-outlined">search</span></button>
				</div>
			</div>

			<div class="block-grid" data-service-archive="results">
				<?php if ($service_query->have_posts()) : ?>
				<?php while ($service_query->have_posts()) : $service_query->the_post(); ?>
				<?php get_template_part('template-parts/component/card', 'service'); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else : ?>
				<p><?php echo esc_html__('Không có dịch vụ nào.', 'canhcamtheme'); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>