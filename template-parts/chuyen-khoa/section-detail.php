<?php
// Lấy dữ liệu từ ACF
$detail_intro_title = get_field('specialty_intro_title');
$detail_intro_content = get_field('specialty_intro_content');
$detail_intro_image = get_field('specialty_intro_image');

$detail_service_title = get_field('specialty_services_title');
$detail_service_content = get_field('specialty_services_content');

$detail_doctor_title = get_field('specialty_doctors_title');
$detail_doctor_content = get_field('specialty_doctors_content');
$detail_doctors_query = new WP_Query(array(
	'post_type' => 'bac-si',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC',
	'meta_query' => array(
		array(
			'key' => 'doctor_specialties',
			'value' => '"' . get_the_ID() . '"',
			'compare' => 'LIKE',
		),
	),
));

$detail_article_title = get_field('specialty_articles_title');
$detail_article_content = get_field('specialty_articles_content');
$detail_articles = get_field('specialty_articles');
?>

<section class="section-SpecialtiesDetail">
	<div class="gsap-tabs-wrapper"
		data-gsap-tabs-options="{'effect': 'fade-up', 'event': 'click', 'mobileEvent': 'click', 'triggerScale': 1}">
		<div class="container">
			<div class="filter-dropdown">
				<div class="filter-toggle">
					<span class="selected-text"><?php esc_html_e('Giới thiệu', 'canhcamtheme'); ?></span>
					<i class="fa-regular fa-chevron-down"></i>
				</div>
				<ul class="tab-triggers filter-menu">
					<li class="active" data-tab-trigger="0">
						<a class="nav-link" href="javascript:void(0)">
							<span><?php esc_html_e('Giới thiệu', 'canhcamtheme'); ?></span>
						</a>
					</li>
					<li data-tab-trigger="1">
						<a class="nav-link" href="javascript:void(0)">
							<span><?php esc_html_e('Dịch vụ', 'canhcamtheme'); ?></span>
						</a>
					</li>
					<li data-tab-trigger="2">
						<a class="nav-link" href="javascript:void(0)">
							<span><?php esc_html_e('Danh sách bác sĩ', 'canhcamtheme'); ?></span>
						</a>
					</li>
					<li data-tab-trigger="3">
						<a class="nav-link" href="javascript:void(0)">
							<span><?php esc_html_e('Kiến thức y khoa', 'canhcamtheme'); ?></span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="tab-contents relative mt-base">
			<!-- TAB 0: GIỚI THIỆU -->
			<div class="tab-pane w-full" data-tab-content="0">
				<div class="container">
					<div class="section-py">
						<?php if ($detail_intro_title): ?>
						<h2 class="title"><?php echo esc_html($detail_intro_title); ?></h2>
						<?php else: ?>
						<h2 class="title"><?php echo esc_html(get_the_title()); ?></h2>
						<?php endif; ?>

						<?php if ($detail_intro_content): ?>
						<div class="main-content"><?php echo wp_kses_post($detail_intro_content); ?></div>
						<?php endif; ?>

						<?php if ($detail_intro_image): ?>
						<div class="image">
							<div class="img img-ratio ratio:pt-[540_1400] zoom-img rounded-6">
								<?php echo get_image_attrachment($detail_intro_image, 'image'); ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>

				<?php if (have_rows('specialty_intro_blocks')): ?>
				<?php $is_alt_layout = false; ?>
				<?php while (have_rows('specialty_intro_blocks')): the_row();
                        $block_title = get_sub_field('block_title');
                        $block_content = get_sub_field('block_content');
                        $block_image = get_sub_field('block_image');
                        $block_layout = get_sub_field('block_layout');

                        $is_image_left = $block_layout === 'image_left';
                        $is_alt_layout = !$is_alt_layout;
                    ?>
				<div class="<?php echo $is_alt_layout ? 'wrap-padding' : 'section-py'; ?>">
					<div class="container">
						<div class="block-grid">
							<?php if ($is_image_left): ?>
							<div class="image">
								<?php if ($block_image): ?>
								<div class="img img-ratio ratio:pt-[690_660] zoom-img">
									<?php echo get_image_attrachment($block_image, 'image'); ?></div>
								<?php endif; ?>
							</div>
							<div class="content">
								<?php if ($block_title): ?>
								<h3 class="title"><?php echo esc_html($block_title); ?></h3>
								<?php endif; ?>
								<?php if ($block_content): ?>
								<div class="main-content"><?php echo wp_kses_post($block_content); ?></div>
								<?php endif; ?>
							</div>
							<?php else: ?>
							<div class="box-left">
								<?php if ($block_title): ?>
								<h3 class="title"><?php echo esc_html($block_title); ?></h3>
								<?php endif; ?>
								<?php if ($block_content): ?>
								<div class="main-content"><?php echo wp_kses_post($block_content); ?></div>
								<?php endif; ?>
							</div>
							<div class="box-right">
								<?php if ($block_image): ?>
								<div class="img img-ratio ratio:pt-[690_660] zoom-img rounded-6">
									<?php echo get_image_attrachment($block_image, 'image'); ?></div>
								<?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<!-- TAB 1: DỊCH VỤ -->
			<div class="tab-pane w-full" data-tab-content="1">
				<div class="section-py">
					<div class="container">
						<div class="block-row row product-slider-vertical">
							<div class="col-lg-4">
								<?php if ($detail_service_title): ?>
								<h3 class="title mb-6"><?php echo esc_html($detail_service_title); ?></h3>
								<?php endif; ?>
								<?php if ($detail_service_content): ?>
								<div class="content">
									<div><?php echo wp_kses_post($detail_service_content); ?></div>
								</div>
								<?php endif; ?>

								<?php if (have_rows('specialty_services_items')): ?>
								<div class="product-thumbs mt-6">
									<div class="swiper">
										<div class="swiper-wrapper">
											<?php while (have_rows('specialty_services_items')): the_row();
                                                    $service_title = get_sub_field('service_title');
                                                ?>
											<div class="swiper-slide">
												<div class="item"><span
														class="heading-4"><?php echo esc_html($service_title); ?></span>
												</div>
											</div>
											<?php endwhile; ?>
										</div>
									</div>
								</div>
								<?php endif; ?>
							</div>

							<div class="col-lg-8">
								<div class="product-main">
									<div class="swiper">
										<div class="swiper-wrapper">
											<?php if (have_rows('specialty_services_items')): ?>
											<?php while (have_rows('specialty_services_items')): the_row();
                                                    $service_title = get_sub_field('service_title');
                                                    $service_content = get_sub_field('service_content');
                                                    $service_image = get_sub_field('service_image');
                                                ?>
											<div class="swiper-slide">
												<div class="card">
													<?php if ($service_image): ?>
													<div class="img img-ratio ratio:pt-[468_832] zoom-img">
														<?php echo get_image_attrachment($service_image, 'image'); ?>
													</div>
													<?php endif; ?>
													<div class="content-main">
														<?php if ($service_title): ?>
														<div class="title-main"><?php echo esc_html($service_title); ?>
														</div>
														<?php endif; ?>
														<?php if ($service_content): ?>
														<div class="content-main">
															<div><?php echo wp_kses_post($service_content); ?></div>
														</div>
														<?php endif; ?>
													</div>
												</div>
											</div>
											<?php endwhile; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- TAB 2: DANH SÁCH BÁC SĨ -->
			<div class="tab-pane w-full" data-tab-content="2">
				<div class="section-py">
					<div class="container">
						<div class="title-content flex-between-row -lg:flex-column gap-base mb-6">
							<?php if ($detail_doctor_title): ?>
							<h2 class="heading-1 text-primary-1"><?php echo esc_html($detail_doctor_title); ?></h2>
							<?php else: ?>
							<h2 class="heading-1 text-primary-1"><?php esc_html_e('Đội ngũ bác sĩ', 'canhcamtheme'); ?>
							</h2>
							<?php endif; ?>
						</div>

						<?php if ($detail_doctor_content): ?>
						<div class="content-desc body-2 flex-column gap-2">
							<div><?php echo wp_kses_post($detail_doctor_content); ?></div>
						</div>
						<?php else: ?>
						<div class="content-desc body-2 flex-column gap-2">
							<div>
								<?php esc_html_e('Đội ngũ bác sĩ giàu kinh nghiệm, tận tâm với nghề', 'canhcamtheme'); ?>
							</div>
						</div>
						<?php endif; ?>

						<?php if ($detail_doctors_query->have_posts()): ?>
						<div class="block-gridDoctor">
							<?php while ($detail_doctors_query->have_posts()): $detail_doctors_query->the_post(); ?>
							<?php get_template_part('template-parts/component/card', 'doctor'); ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
						<?php else: ?>
						<div class="text-center py-10">
							<p><?php esc_html_e('Chưa có thông tin bác sĩ', 'canhcamtheme'); ?></p>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- TAB 3: KIẾN THỨC Y KHOA -->
			<div class="tab-pane w-full" data-tab-content="3">
				<div class="section-py">
					<div class="container">
						<?php if ($detail_article_title): ?>
						<h2 class="heading-1 text-center text-primary-1"><?php echo esc_html($detail_article_title); ?>
						</h2>
						<?php else: ?>
						<h2 class="heading-1 text-center text-primary-1">
							<?php esc_html_e('Kiến thức y khoa', 'canhcamtheme'); ?></h2>
						<?php endif; ?>

						<?php if ($detail_article_content): ?>
						<div class="sub-content-end text-center body-2">
							<div><?php echo wp_kses_post($detail_article_content); ?></div>
						</div>
						<?php else: ?>
						<div class="sub-content-end text-center body-2">
							<div><?php esc_html_e('Cập nhật những kiến thức y khoa mới nhất', 'canhcamtheme'); ?></div>
						</div>
						<?php endif; ?>

						<?php if (!empty($detail_articles)): ?>
						<div class="block-grid-New my-base lg:my-13 grid grid-cols-1 lg:grid-cols-3 gap-base">
							<?php foreach ($detail_articles as $article_post):
                                    $post = $article_post;
                                    setup_postdata($post);
                                    get_template_part('template-parts/component/card', 'new');
                                endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</div>
						<?php else: ?>
						<div class="text-center py-10">
							<p><?php esc_html_e('Chưa có bài viết nào', 'canhcamtheme'); ?></p>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>