<?php
$queried        = get_queried_object();
$current_cat_id = 0;
$current_cat_name = 'Tất cả';

if ($queried instanceof WP_Term && $queried->taxonomy === 'category') {
	$current_cat_id   = $queried->term_id;
	$current_cat_name = $queried->name;
}

$categories = get_terms(array(
	'taxonomy'   => 'category',
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'ASC',
));

$paged = max(1, (int) (get_query_var('paged') ?: get_query_var('page') ?: 1));

$query_args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 9,
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

if ($current_cat_id) {
	$query_args['cat'] = $current_cat_id;
}

$news_query = new WP_Query($query_args);

// Archive link
$archive_link = get_post_type_archive_link('post');
if (!$archive_link) {
	$page_for_posts = get_option('page_for_posts');
	$archive_link   = $page_for_posts ? get_permalink($page_for_posts) : home_url('/');
}
?>
<section class="section-NewList">
	<div class="section-py">
		<div class="container">
			<div class="block-title">
				<div class="main-title">
					<h1 class="heading-1 text-primary-1"><?php esc_html_e('News & Events', 'canhcamtheme'); ?></h1>

					<?php if (!is_wp_error($categories) && !empty($categories)) : ?>
					<div class="filter-dropdown">
						<div class="filter-toggle">
							<span class="selected-text"><?php echo esc_html($current_cat_name); ?></span>
							<i class="fa-regular fa-chevron-down"></i>
						</div>
						<ul class="tabslet-tab filter-menu">
							<li class="<?php echo !$current_cat_id ? 'active' : ''; ?>">
								<a href="<?php echo esc_url($archive_link); ?>">
									<span><?php esc_html_e('Tất cả', 'canhcamtheme'); ?></span>
								</a>
							</li>
							<?php foreach ($categories as $cat) : ?>
							<li class="<?php echo $current_cat_id === $cat->term_id ? 'active' : ''; ?>">
								<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
									<span><?php echo esc_html($cat->name); ?></span>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="block-New">
				<?php if ($news_query->have_posts()) : ?>
					<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
						<?php get_template_part('template-parts/component/card', 'new'); ?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e('Chưa có bài viết nào.', 'canhcamtheme'); ?></p>
				<?php endif; ?>
			</div>

			<?php if ($news_query->max_num_pages > 1) : ?>
			<div class="block-pagination">
				<div class="button-pagination">
					<?php
					$big        = 999999999;
					$pagination = paginate_links(array(
						'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'format'    => '?paged=%#%',
						'current'   => $paged,
						'total'     => $news_query->max_num_pages,
						'type'      => 'array',
						'prev_next' => false,
					));

					if ($pagination) {
						foreach ($pagination as $page_link) {
							$is_active = strpos($page_link, 'current') !== false;
							$page_num  = wp_strip_all_tags($page_link);
							$href      = '';
							if (preg_match('/href=[\'"]([^\'"]+)[\'"]/', $page_link, $m)) {
								$href = $m[1];
							}
							if ($href) {
								echo '<a class="btn-pagination ' . ($is_active ? 'active' : '') . '" href="' . esc_url($href) . '"><span>' . esc_html($page_num) . '</span></a>';
							} else {
								echo '<span class="btn-pagination ' . ($is_active ? 'active' : '') . '"><span>' . esc_html($page_num) . '</span></span>';
							}
						}
					}
					?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
