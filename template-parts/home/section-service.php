<?php if (get_field('show_section_service') !== false): 
	$title = get_field('service_title');
	$desc = get_field('service_description');
	$btn = get_field('service_button');
	
	// ACF Relationship field cho Dịch vụ
	$services = get_field('home_services');
?>
<section class="section-service">
	<div class="section-py">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="title-heading block text-center heading-1 text-primary-1 mb-5"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($desc): ?>
					<div class="sub-title">
						<div><?php echo wp_kses_post($desc); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="container-fluid">
			<?php if ($services): ?>
			<div class="block-swiper my-base">
				<!-- Main Swiper (Hình ảnh) -->
				<div class="swiper-main">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php foreach ($services as $post): setup_postdata($post); ?>
							<div class="swiper-slide">
								<div class="img img-ratio ratio:pt-[640_1760] -lg:h-[50dvh]">
									<?php echo function_exists('get_image_post') ? get_image_post($post->ID, 'image') : get_the_post_thumbnail($post->ID, 'full', array('class' => 'lozad')); ?>
								</div>
							</div>
							<?php endforeach; wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
				<!-- Thumb Swiper (Nội dung) -->
				<div class="swiper-thumb">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php foreach ($services as $post): setup_postdata($post); ?>
							<div class="swiper-slide">
								<div class="box">
									<a class="main-content" href="<?php echo esc_url(get_permalink()); ?>" data-height-options="{&quot;source&quot;: &quot;child&quot;, &quot;var&quot;: &quot;--header-h&quot;}">
										<div class="title-service"><span><?php echo esc_html(get_the_title()); ?></span></div>
										<div class="content-hidden" data-height-child>
											<div class="sub-content-service">
												<div class="scroll">
													<p><?php echo esc_html(get_the_excerpt()); ?></p>
												</div>
											</div>
											<button class="btn btn-service btn-icon"><span>Tìm hiểu thêm</span>
												<div class="icon is-primary"></div>
											</button>
										</div>
									</a>
								</div>
							</div>
							<?php endforeach; wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if ($btn): ?>
			<div class="block-button">
				<a class="btn btn-primary btn-icon" href="<?php echo esc_url($btn['url']); ?>">
					<span><?php echo esc_html($btn['title']); ?></span>
					<div class="icon is-secondary"></div>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>
