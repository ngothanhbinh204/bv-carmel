<?php
$list_title = get_field('specialty_list_title');
$list_placeholder = get_field('specialty_list_search_placeholder');
$list_empty_text = get_field('specialty_list_empty_text');

if (!$list_title) {
    $list_title = esc_html__('Danh sách các chuyên khoa', 'canhcamtheme');
}

if (!$list_placeholder) {
    $list_placeholder = esc_html__('Tìm chuyên khoa', 'canhcamtheme');
}

if (!$list_empty_text) {
    $list_empty_text = esc_html__('Không tìm thấy chuyên khoa phù hợp.', 'canhcamtheme');
}

$specialty_query = new WP_Query(array(
    'post_type' => 'chuyen-khoa',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
));
?>
<section class="section-SpecialtiesList" data-specialty-search="wrapper">
	<div class="section-py">
		<div class="container">
			<div class="title-content">
				<?php if ($list_title): ?>
				<h2 class="heading-1 text-primary-1"><?php echo esc_html($list_title); ?></h2>
				<?php endif; ?>
				<div class="Search-SpecialtiesList">
					<form action="#" method="get" data-specialty-search="form">
						<input type="text" name="keyword" value=""
							placeholder="<?php echo esc_attr($list_placeholder); ?>" data-specialty-search="input" />
						<button class="btn btn-green" type="submit">
							<span>
								<?php echo esc_html__('Tìm kiếm', 'canhcamtheme'); ?>
							</span>
							<span class="material-symbols-outlined">search</span>
						</button>
					</form>
				</div>
			</div>

			<div class="block-grid" data-specialty-search="results" style="transition: opacity .25s ease;">
				<?php if ($specialty_query->have_posts()): ?>
				<?php while ($specialty_query->have_posts()): $specialty_query->the_post(); ?>
				<?php get_template_part('template-parts/component/card', 'outstanding'); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else: ?>
				<p><?php echo esc_html($list_empty_text); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>