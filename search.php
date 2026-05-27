<?php
add_filter('body_class', function ($classes) {
	return array_merge($classes, array('no-banner-page'));
});

$keyword = trim((string) get_search_query());
$search_map = array(
	'post' => array(
		'component' => 'new',
		'anchor' => 'search-post',
	),
	'chuyen-khoa' => array(
		'component' => 'outstanding',
		'anchor' => 'search-chuyen-khoa',
	),
	'bac-si' => array(
		'component' => 'doctor',
		'anchor' => 'search-bac-si',
	),
	'dich-vu' => array(
		'component' => 'service',
		'anchor' => 'search-dich-vu',
	),
);

$search_groups = array();

$title_search_filter = function ($where, $query) {
	if (!($query instanceof WP_Query) || !$query->get('carmel_title_only_search')) {
		return $where;
	}

	$search_keyword = $query->get('carmel_title_only_search');
	if ($search_keyword === '') {
		return $where;
	}

	global $wpdb;
	$like = '%' . $wpdb->esc_like($search_keyword) . '%';
	$where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", $like);

	return $where;
};

if ($keyword !== '') {
	add_filter('posts_where', $title_search_filter, 10, 2);

	foreach ($search_map as $post_type => $config) {
		$group_query = new WP_Query(array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC',
			'ignore_sticky_posts' => true,
			'suppress_filters' => false,
			'carmel_title_only_search' => $keyword,
		));

		if (!$group_query->have_posts()) {
			wp_reset_postdata();
			continue;
		}

		$post_type_object = get_post_type_object($post_type);
		$search_groups[$post_type] = array(
			'label' => $post_type_object ? $post_type_object->labels->name : ucfirst($post_type),
			'anchor' => $config['anchor'],
			'component' => $config['component'],
			'count' => (int) $group_query->found_posts,
			'query' => $group_query,
		);
	}

	remove_filter('posts_where', $title_search_filter, 10);
}

get_header();
?>

<section class="search-page section">
	<div class="container">
		<h1 class="heading-2 text-primary-1 text-center mb-base"><?php _e('Tìm kiếm', 'canhcamtheme'); ?></h1>

		<div class="wrap-form-search">
			<form class="searchbox flex items-center w-full relative" action="<?php echo esc_url(home_url('/')); ?>"
				method="GET" role="search">
				<input class="w-full" name="s" type="text"
					placeholder="<?php esc_attr_e('Tìm kiếm', 'canhcamtheme'); ?>"
					value="<?php echo esc_attr($keyword); ?>">
				<button type="submit" class="flex items-center justify-center"
					aria-label="<?php esc_attr_e('Tìm kiếm', 'canhcamtheme'); ?>">
					<em class="fa-regular fa-magnifying-glass"></em>
				</button>
			</form>
		</div>

		<?php if ($keyword !== '') : ?>
		<div class="search-query">
			<?php _e('Kết quả tìm kiếm từ khóa', 'canhcamtheme'); ?>: " <span><?php echo esc_html($keyword); ?></span> "
		</div>

		<?php if (!empty($search_groups)) : ?>
		<nav class="post-filter-nav mb-4" data-aos="fade-up" data-aos-delay="150">
			<?php foreach ($search_groups as $group) : ?>
			<a href="#<?php echo esc_attr($group['anchor']); ?>" class="filter-btn">
				<?php echo esc_html($group['label']); ?> (<?php echo esc_html($group['count']); ?>)
			</a>
			<?php endforeach; ?>
		</nav>

		<?php foreach ($search_groups as $group) : ?>
		<div class="search-group mt-base" id="<?php echo esc_attr($group['anchor']); ?>">
			<h2 class="heading-3 text-primary-1 mb-base">
				<?php echo esc_html($group['label']); ?> (<?php echo esc_html($group['count']); ?>)
			</h2>
			<div class="block-grid grid grid-cols-2 lg:grid-cols-4 gap-base mb-base">
				<?php while ($group['query']->have_posts()) : $group['query']->the_post(); ?>
				<?php get_template_part('template-parts/component/card', $group['component']); ?>
				<?php endwhile; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
		<?php endforeach; ?>
		<?php else : ?>
		<div class="search-no-result body-1 text-center font-bold">
			<?php _e('Không tìm thấy kết quả', 'canhcamtheme'); ?>
		</div>
		<?php endif; ?>
		<?php else : ?>
		<div class="search-no-result body-1 text-center font-bold">
			<?php _e('Vui lòng nhập từ khóa để tìm kiếm.', 'canhcamtheme'); ?>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>