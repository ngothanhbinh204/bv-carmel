<?php
$post_id = get_the_ID();

$service_banner_image = get_field('service_banner_image', $post_id);
$service_banner_title = get_field('service_banner_title', $post_id);
$tag_name = get_field('tag_name', $post_id);

$service_table_heading = get_field('service_table_heading', $post_id);
$service_table_items = get_field('service_table_items', $post_id);

$service_prepare_heading = get_field('service_prepare_heading', $post_id);
$service_prepare_intro = get_field('service_prepare_intro', $post_id);
$service_prepare_items = get_field('service_prepare_items', $post_id);

$service_related_heading = get_field('service_related_heading', $post_id);
$service_related_posts = get_field('service_related_posts', $post_id);

if (!$service_banner_title) {
    $service_banner_title = get_the_title($post_id);
}

if (!$service_table_heading) {
    $service_table_heading = 'Dich vu bao gom';
}

if (!$service_prepare_heading) {
    $service_prepare_heading = 'Nhung dieu can chuan bi';
}

if (!$service_consult_heading) {
    $service_consult_heading = 'De lai thong tin tu van';
}

if (!$service_related_heading) {
    $service_related_heading = 'Goi dich vu khac';
}

if (!$service_hotline_label) {
    $service_hotline_label = 'Lien he Bo phan Kinh doanh:';
}

if (!$service_hotline_number) {
    $service_hotline_number = '0977 851 818';
}

$service_banner_html = '';
if ($service_banner_image && function_exists('get_image_attrachment')) {
    $service_banner_html = get_image_attrachment($service_banner_image, 'image');
} elseif (has_post_thumbnail($post_id) && function_exists('get_image_post')) {
    $service_banner_html = get_image_post($post_id, 'image');
} elseif (has_post_thumbnail($post_id)) {
    $service_banner_html = get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
}

$category_terms = get_the_terms($post_id, 'danh-muc-dich-vu');
$topic_terms = get_the_terms($post_id, 'chu-de-dich-vu');

$related_query = null;
if (!empty($service_related_posts)) {
	$related_ids = array();
	foreach ($service_related_posts as $related_item) {
		$related_ids[] = is_object($related_item) ? (int) $related_item->ID : (int) $related_item;
	}
	$related_ids = array_values(array_filter(array_unique($related_ids)));

    $related_query = new WP_Query(array(
        'post_type' => 'dich-vu',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'post__in' => $related_ids,
        'orderby' => 'post__in',
    ));
} else {
    $tax_query = array('relation' => 'AND');

    if (!is_wp_error($category_terms) && !empty($category_terms)) {
        $tax_query[] = array(
            'taxonomy' => 'danh-muc-dich-vu',
            'field' => 'term_id',
            'terms' => wp_list_pluck($category_terms, 'term_id'),
            'operator' => 'IN',
        );
    }

    if (!is_wp_error($topic_terms) && !empty($topic_terms)) {
        $tax_query[] = array(
            'taxonomy' => 'chu-de-dich-vu',
            'field' => 'term_id',
            'terms' => wp_list_pluck($topic_terms, 'term_id'),
            'operator' => 'IN',
        );
    }

    $query_args = array(
        'post_type' => 'dich-vu',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'post__not_in' => array($post_id),
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    if (count($tax_query) > 1) {
        $query_args['tax_query'] = $tax_query;
    }

    $related_query = new WP_Query($query_args);
}
?>

<section class="section-textBanner">
	<div class="img img-ratio zoom-img">
		<?php if ($service_banner_html) : ?>
		<?php echo $service_banner_html; ?>
		<?php else : ?>
		<img class="lozad" data-src="<?php echo esc_url(get_template_directory_uri() . '/img/default-banner.jpg'); ?>"
			alt="<?php echo esc_attr(get_the_title($post_id)); ?>" />
		<?php endif; ?>
	</div>
	<div class="block-content">
		<div class="container">
			<h1 class="banner-title"><?php echo wp_kses_post($service_banner_title); ?></h1>
			<?php if ($tag_name) : ?>
			<p class="banner-subtitle"><?php echo esc_html($tag_name); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="global-breadcrumb">
	<div class="container">
		<nav class="rank-math-breadcrumb" aria-label="breadcrumbs">
			<?php if (function_exists('rank_math_the_breadcrumbs')) :
                rank_math_the_breadcrumbs();
            ?>

			<?php endif; ?>
		</nav>
	</div>
</section>

<section class="section-ServicesDetail">
	<div class="section-info section-py">
		<div class="container">
			<div class="info-layout">
				<div class="info-content">
					<div class="service-table">
						<h2 class="block-title"><?php echo esc_html($service_table_heading); ?></h2>
						<?php if (!empty($service_table_items)) : ?>
						<?php $table_display_index = 0; ?>
						<div class="table-head"><span class="head-stt">STT</span><span class="head-cat">
								<?php _e('Danh mục dịch vụ', 'canhcamtheme'); ?>
							</span></div>
						<div class="table-body">
							<?php foreach ($service_table_items as $index => $item) :
                                $item_title = isset($item['item_title']) ? $item['item_title'] : '';
                                $item_desc = isset($item['item_description']) ? $item['item_description'] : '';
                                if (!$item_title && !$item_desc) {
                                    continue;
                                }
								$table_display_index++;
                            ?>
							<div class="table-row"><span
									class="row-num"><?php echo esc_html(sprintf('%02d', $table_display_index)); ?></span>
								<div class="row-detail">
									<?php if ($item_title) : ?>
									<h4 class="row-title"><?php echo esc_html($item_title); ?></h4>
									<?php endif; ?>
									<?php if ($item_desc) : ?>
									<div class="row-desc"><?php echo wp_kses_post($item_desc); ?></div>
									<?php endif; ?>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>

					<?php if (!empty($service_prepare_items) || $service_prepare_intro) : ?>
					<div class="prepare-section">
						<h2 class="block-title"><?php echo esc_html($service_prepare_heading); ?></h2>
						<?php if ($service_prepare_intro) : ?>
						<div class="prepare-intro body-2 text-utility-500">
							<?php echo wp_kses_post($service_prepare_intro); ?>
						</div>
						<?php endif; ?>

						<?php if (!empty($service_prepare_items)) : ?>
						<?php $prepare_display_index = 0; ?>
						<div class="prepare-list">
							<?php foreach ($service_prepare_items as $index => $item) :
                                $prepare_title = isset($item['prepare_title']) ? $item['prepare_title'] : '';
                                $prepare_content = isset($item['prepare_content']) ? $item['prepare_content'] : '';
                                if (!$prepare_title && !$prepare_content) {
                                    continue;
                                }
								$prepare_display_index++;
                            ?>
							<div class="prepare-item"><span
									class="item-num"><?php echo esc_html(sprintf('%02d.', $prepare_display_index)); ?></span>
								<div class="item-body">
									<?php if ($prepare_title) : ?>
									<h4 class="item-title"><?php echo esc_html($prepare_title); ?></h4>
									<?php endif; ?>
									<?php if ($prepare_content) : ?>
									<div class="item-content"><?php echo wp_kses_post($prepare_content); ?></div>
									<?php endif; ?>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>

				<?php get_template_part('template-parts/component/form', 'consult'); ?>
			</div>
		</div>
	</div>

	<?php if ($related_query && $related_query->have_posts()) : ?>
	<div class="section-related">
		<div class="section-py">
			<div class="container">
				<h2 class="heading-2 text-primary-1 text-center mb-base font-semibold">
					<?php echo esc_html($service_related_heading); ?></h2>
				<div class="related-wrapper relative">
					<div class="swiper-column-auto auto-3-column" data-id-swiper="related-services">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
								<div class="swiper-slide">
									<?php get_template_part('template-parts/component/card', 'service'); ?>
								</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
					<div class="button-swiper-related button-swiper">
						<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="related-services">
							<div class="icon"></div>
						</div>
						<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="related-services">
							<div class="icon"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</section>