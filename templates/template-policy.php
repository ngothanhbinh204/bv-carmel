<?php
/**
 * Template Name: Policy
 */

get_header();

$post_id = get_the_ID();
$policy_banner_image = get_field('policy_banner_image', $post_id);
$policy_sidebar_title = get_field('policy_sidebar_title', $post_id);
$policy_main_title = get_field('policy_main_title', $post_id);
$policy_main_content = get_field('policy_main_content', $post_id);
$policy_sections = get_field('policy_sections', $post_id);

if (!$policy_sidebar_title) {
	$policy_sidebar_title = 'Danh mục chính';
}

if (!$policy_main_title) {
	$policy_main_title = get_the_title($post_id);
}

$banner_html = '';
if ($policy_banner_image && function_exists('get_image_attrachment')) {
	$banner_html = get_image_attrachment($policy_banner_image, 'image');
} elseif (has_post_thumbnail($post_id) && function_exists('get_image_post')) {
	$banner_html = get_image_post($post_id, 'image');
} elseif (has_post_thumbnail($post_id)) {
	$banner_html = get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
}
?>

<main>
	<?php get_template_part('modules/common/banner'); ?>

	<section class="section-Policy">
		<div class="section-py">
			<div class="container">
				<div class="block-row row">
					<div class="col-lg-3">
						<div class="sidebar">
							<div class="sidebar-wrapper">
								<button class="sidebar-toggle" type="button" aria-label="Toggle Sidebar"><i
										class="fa-solid fa-arrow-right"></i></button>
								<div class="sidebar-inner">
									<div class="sidebar-header">
										<h3><?php echo esc_html($policy_sidebar_title); ?></h3>
										<button class="close-sidebar" type="button" aria-label="Close"><i
												class="fa-solid fa-xmark text-xl"></i></button>
									</div>
									<div class="sidebar-body">
										<div class="title-side-bar"><span
												class="material-symbols-outlined">format_list_bulleted</span>
											<h3><?php echo esc_html($policy_sidebar_title); ?></h3>
										</div>
										<?php if (!empty($policy_sections)) : ?>
										<div class="sidebar-menu" id="menu-spy">
											<ul>
												<?php foreach ($policy_sections as $index => $section) : ?>
												<?php
												$anchor = !empty($section['section_anchor']) ? $section['section_anchor'] : sanitize_title($section['section_title']);
												$clause = !empty($section['section_clause']) ? $section['section_clause'] : 'Điều ' . ($index + 1) . ':';
												$section_title = !empty($section['section_title']) ? $section['section_title'] : '';
												?>
												<li><a class="nav-link item-scroll <?php echo $index === 0 ? 'active' : ''; ?>"
														href="#<?php echo esc_attr($anchor); ?>"><strong><?php echo esc_html($clause); ?>:</strong><span><?php echo esc_html($section_title); ?></span></a>
												</li>
												<?php endforeach; ?>
											</ul>
										</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="sidebar-overlay"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-9">
						<div class="main-content">
							<div class="prose">
								<div class="wrapper-top">
									<h1><?php echo esc_html($policy_main_title); ?></h1>

									<?php if ($policy_main_content) : ?>
									<div class="desc">
										<?php echo wp_kses_post($policy_main_content); ?>
									</div>
									<?php endif; ?>
								</div><!-- end wrapper-top -->

								<?php if (!empty($policy_sections)) : ?>
								<?php foreach ($policy_sections as $index => $section) : ?>
								<?php
										$anchor = !empty($section['section_anchor']) ? $section['section_anchor'] : sanitize_title($section['section_title']);
										$clause = !empty($section['section_clause']) ? $section['section_clause'] : 'Điều ' . ($index + 1) . ':';
										$section_title = !empty($section['section_title']) ? $section['section_title'] : '';
										$section_content = !empty($section['section_content']) ? $section['section_content'] : '';
										?>
								<h2 id="<?php echo esc_attr($anchor); ?>">
									<strong><?php echo esc_html($clause); ?></strong>
									<?php if ($section_title) : ?>
									<span><?php echo esc_html($section_title); ?></span>
									<?php endif; ?>
								</h2>
								<?php echo wp_kses_post($section_content); ?>
								<?php endforeach; ?>
								<?php elseif (get_the_content()) : ?>
								<?php echo apply_filters('the_content', get_the_content()); ?>
								<?php endif; ?>
							</div><!-- end prose -->
						</div><!-- end main-content -->
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>