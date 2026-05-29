<?php
$doctor_intro_title = get_field('doctor_intro_title');
$doctor_intro_content = get_field('doctor_intro_content');
$doctor_list_title = get_field('doctor_list_title');
$doctor_list_subtitle = get_field('doctor_list_subtitle');
$doctor_search_placeholder = get_field('doctor_search_placeholder');
$doctor_specialty_placeholder = get_field('doctor_specialty_placeholder');
$doctor_search_button_text = get_field('doctor_search_button_text');
$doctor_empty_text = get_field('doctor_empty_text');

$specialty_options = function_exists('carmel_get_specialty_options_with_doctors') ? carmel_get_specialty_options_with_doctors() : array();
$doctor_query = function_exists('carmel_build_doctor_query') ? carmel_build_doctor_query('', 'all', 1) : new WP_Query(array(
	'post_type' => 'bac-si',
	'post_status' => 'publish',
	'posts_per_page' => 12,
));
?>
<section class="section-doctor-intro">
	<div class="container">
		<div class="block-head">
			<?php if ($doctor_intro_title): ?>
			<h2 class="heading-1 text-center text-primary-1"><?php echo esc_html($doctor_intro_title); ?></h2>
			<?php endif; ?>
			<?php if ($doctor_intro_content): ?>
			<div class="sub-title">
				<div><?php echo wp_kses_post($doctor_intro_content); ?></div>
			</div>
			<?php endif; ?>
		</div>
		<div class="block-values">
			<?php if (have_rows('doctor_intro_values')): ?>
			<?php while (have_rows('doctor_intro_values')): the_row();
					$value_icon = get_sub_field('value_icon');
					$value_title = get_sub_field('value_title');
					$value_desc = get_sub_field('value_desc');
				?>
			<div class="value-item">
				<div class="icon">
					<?php if ($value_icon && function_exists('get_image_attrachment')): ?>
					<?php echo get_image_attrachment($value_icon, 'image'); ?>
					<?php else: ?>
					<img src="<?php echo esc_url(get_template_directory_uri() . '/img/icon_doctor.svg'); ?>"
						alt="icon" />
					<?php endif; ?>
				</div>
				<div class="content">
					<?php if ($value_title): ?>
					<h3 class="value-title"><?php echo wp_kses_post($value_title); ?></h3>
					<?php endif; ?>
					<?php if ($value_desc): ?>
					<div class="value-desc">
						<div><?php echo wp_kses_post($value_desc); ?></div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="section-doctor-grid" data-doctor-archive="wrapper">
	<div class="container">
		<div class="block-head">
			<h2 class="heading-1 text-primary-1 text-center"><?php echo esc_html($doctor_list_title); ?></h2>
			<div class="sub-title">
				<div><?php echo wp_kses_post($doctor_list_subtitle); ?></div>
			</div>
		</div>
		<div class="block-search">
			<form class="search-form" action="#" method="get" data-doctor-search="form">
				<input class="search-input" type="text" name="q"
					placeholder="<?php echo esc_attr($doctor_search_placeholder); ?>" data-doctor-search="keyword" />
				<?php echo function_exists('carmel_render_dropfilter_options') ? carmel_render_dropfilter_options($specialty_options, array(
					'name' => 'doctor_specialty',
					'placeholder' => $doctor_specialty_placeholder,
					'selected' => 'all',
					'all_label' => esc_html__('Chuyên khoa', 'canhcamtheme'),
				)) : ''; ?>
				<button class="btn-search" type="submit"
					data-doctor-search="button"><span><?php echo esc_html($doctor_search_button_text); ?></span><span
						class="material-symbols-outlined">search</span></button>
			</form>
		</div>
		<div class="block-grid" data-doctor-archive="results">
			<?php if ($doctor_query->have_posts()): ?>
			<?php while ($doctor_query->have_posts()): $doctor_query->the_post(); ?>
			<?php get_template_part('template-parts/component/card', 'doctor'); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php else: ?>
			<p><?php echo esc_html($doctor_empty_text); ?></p>
			<?php endif; ?>
		</div>
		<div data-doctor-archive="pagination">
			<?php
			if (function_exists('carmel_render_doctor_pagination')) {
				echo carmel_render_doctor_pagination(1, (int) $doctor_query->max_num_pages);
			}
			?>
		</div>
	</div>
</section>