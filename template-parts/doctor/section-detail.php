<?php
$post_id = get_the_ID();

$doctor_image = function_exists('get_image_post') ? get_image_post($post_id, 'image') : get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
$doctor_credential = get_field('doctor_credential');
$doctor_position_list = get_field('doctor_position_list');
$doctor_intro_heading = get_field('doctor_intro_heading');
$doctor_intro_content = get_field('doctor_intro_content');
$doctor_booking_link = get_field('doctor_booking_link');
$doctor_content_tabs = get_field('doctor_content_tabs');
$doctor_related_heading = get_field('doctor_related_heading');
$doctor_specialties = get_field('doctor_specialties');

$doctor_specialty_ids = array();
if (!empty($doctor_specialties)) {
	foreach ($doctor_specialties as $specialty_item) {
		$doctor_specialty_ids[] = is_object($specialty_item) ? (int) $specialty_item->ID : (int) $specialty_item;
	}
}
$doctor_specialty_ids = array_values(array_unique(array_filter($doctor_specialty_ids)));

$other_doctors_args = array(
	'post_type' => 'bac-si',
	'post_status' => 'publish',
	'posts_per_page' => 6,
	'post__not_in' => array($post_id),
);

if (!empty($doctor_specialty_ids)) {
	$meta_query = array('relation' => 'OR');
	foreach ($doctor_specialty_ids as $specialty_id) {
		$meta_query[] = array(
			'key' => 'doctor_specialties',
			'value' => '"' . $specialty_id . '"',
			'compare' => 'LIKE',
		);
	}
	$other_doctors_args['meta_query'] = $meta_query;
} else {
	$other_doctors_args['post__in'] = array(0);
}

$other_doctors_query = new WP_Query($other_doctors_args);

if (!$doctor_intro_heading) {
    $doctor_intro_heading = 'Giới thiệu';
}

if (!$doctor_related_heading) {
    $doctor_related_heading = 'Xem thêm đội ngũ chuyên gia - bác sĩ';
}

// Lấy chuyên khoa nếu có
// $doctor_position_primary = '';
// if (function_exists('carmel_get_doctor_specialty_names')) {
//     $specialty_names = carmel_get_doctor_specialty_names($post_id);
//     if (!empty($specialty_names)) {
//         $doctor_position_primary = implode(', ', $specialty_names);
//     }
// }
?>

<section class="section-DoctorDetail">
	<div class="section-doctor-summary">
		<div class="section-py">
			<div class="container">
				<div class="summary-layout">
					<div class="summary-left">
						<div class="doctor-img">
							<div class="img img-ratio ratio:pt-[704_528] zoom-img">
								<?php if ($doctor_image) : ?>
								<?php echo $doctor_image; ?>
								<?php endif; ?>
							</div>
						</div>
						<?php if (!empty($doctor_booking_link)) : ?>
						<div class="block-button">
							<a class="btn btn-book" href="<?php echo esc_url($doctor_booking_link['url']); ?>"
								<?php echo !empty($doctor_booking_link['target']) ? 'target="' . esc_attr($doctor_booking_link['target']) . '"' : ''; ?>>
								<span><?php echo esc_html($doctor_booking_link['title']); ?></span>
								<span class="material-symbols-outlined">keyboard_arrow_right</span>
							</a>
						</div>
						<?php endif; ?>
					</div>

					<div class="summary-right">
						<?php if ($doctor_credential) : ?>
						<span class="doctor-credential"><?php echo esc_html($doctor_credential); ?></span>
						<?php endif; ?>

						<h1 class="doctor-name"><?php echo esc_html(get_the_title()); ?></h1>

						<?php if ($doctor_position_list) : ?>
						<div class="doctor-position">
							<?php if (have_rows('doctor_position_list')) : ?>
							<?php while (have_rows('doctor_position_list')) : the_row();
                                        $doctor_position_item = get_sub_field('doctor_position_item');
                                        if ($doctor_position_item) :
                                    ?>
							<span><?php echo esc_html($doctor_position_item); ?></span>
							<?php endif; ?>
							<?php endwhile; ?>
							<?php endif; ?>




						</div>
						<?php endif; ?>

						<div class="info-divider"></div>

						<?php if ($doctor_intro_content) : ?>
						<div class="doctor-intro">
							<h3 class="intro-heading"><?php echo esc_html($doctor_intro_heading); ?></h3>
							<div class="desc">
								<?php echo wp_kses_post($doctor_intro_content); ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (have_rows('doctor_content_tabs')) : ?>
	<div class="section-doctor-tabs">
		<div class="section-py">
			<div class="container">
				<div class="tabs-wrapper" data-gsap-tabs-options="{'effect': 'fade'}">
					<div class="tab-triggers">
						<?php $tab_index = 0; ?>
						<?php while (have_rows('doctor_content_tabs')) : the_row();
                                $label_tab = get_sub_field('label_tab');
                                if (!$label_tab) {
                                    $label_tab = 'Tab ' . ($tab_index + 1);
                                }
                            ?>
						<button data-tab-trigger="<?php echo esc_attr($tab_index); ?>">
							<?php echo esc_html($label_tab); ?>
						</button>
						<?php $tab_index++; ?>
						<?php endwhile; ?>
					</div>

					<div class="tab-contents">
						<?php $tab_index = 0; ?>
						<?php while (have_rows('doctor_content_tabs')) : the_row();
                                $label_tab = get_sub_field('label_tab');
                                $content_tab = get_sub_field('content_tab');
                                if (!$label_tab) {
                                    $label_tab = 'Tab ' . ($tab_index + 1);
                                }
                            ?>
						<div class="tab-panel" data-tab-content="<?php echo esc_attr($tab_index); ?>">
							<div class="tab-box">
								<h2 class="tab-box-heading"><?php echo esc_html($label_tab); ?></h2>

								<?php if (have_rows('content_tab')) : ?>
								<?php while (have_rows('content_tab')) : the_row();
                                                $expertise_sub_heading = get_sub_field('expertise_sub_heading');
                                                $expertise_content = get_sub_field('expertise_content');
                                            ?>
								<div class="content-block">
									<?php if ($expertise_sub_heading) : ?>
									<h4 class="content-sub-heading">
										<?php echo esc_html($expertise_sub_heading); ?>
									</h4>
									<?php endif; ?>

									<?php if ($expertise_content) : ?>
									<div class="desc">
										<div><?php echo wp_kses_post($expertise_content); ?></div>
									</div>
									<?php endif; ?>
								</div>
								<?php endwhile; ?>
								<?php endif; ?>
							</div>
						</div>
						<?php $tab_index++; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="section-other-doctors">
		<div class="section-py">
			<div class="container">
				<h2 class="heading-2 text-primary-1 text-center mb-base">
					<?php echo esc_html($doctor_related_heading); ?>
				</h2>

				<div class="other-wrapper relative">
					<div class="swiper-column-auto auto-4-column" data-id-swiper="other-doctors">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php if ($other_doctors_query->have_posts()) : ?>
								<?php while ($other_doctors_query->have_posts()) : $other_doctors_query->the_post(); ?>
								<div class="swiper-slide">
									<?php get_template_part('template-parts/component/card', 'doctor'); ?>
								</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
								<?php else : ?>
								<div class="swiper-slide">
									<p><?php esc_html_e('Chưa có thông tin bác sĩ', 'canhcamtheme'); ?></p>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="button-swiper">
						<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="other-doctors">
							<div class="icon"></div>
						</div>
						<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="other-doctors">
							<div class="icon"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>