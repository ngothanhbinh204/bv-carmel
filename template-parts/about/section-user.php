<?php if (get_field('show_section_user') !== false):
	$title       = get_field('user_title');
	$testimonials = get_field('user_testimonials'); // repeater: quote, name, role, image
?>
<section class="section-user">
	<div class="section-py">
		<?php if ($title): ?>
			<h2 class="heading-1 title-heading text-primary-1 block text-center"><?php echo esc_html($title); ?></h2>
		<?php endif; ?>
		<div class="swiper-dynamic-config my-base" data-id-swiper="user"
			data-swiper-options='{"slidesPerView": 1, "spaceBetween": "getVw(20,40)", "centeredSlides": true, "loop": true, "breakpoints": {"1024": {"slidesPerView": 1.8}}}'>
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php if ($testimonials): ?>
						<?php foreach ($testimonials as $item): ?>
						<div class="swiper-slide">
							<div class="box-content">
								<div class="content-left">
									<div class="icon">
										<div class="img img-ratio ratio:pt-[49_65] zoom-img">
											<img class="lozad" data-src="<?php echo esc_url(get_template_directory_uri() . '/img/user-icon.svg'); ?>" alt="quote"/>
										</div>
									</div>
									<?php if (!empty($item['quote'])): ?>
										<div class="content">
											<p><?php echo esc_html($item['quote']); ?></p>
										</div>
									<?php endif; ?>
									<div class="name">
										<strong><?php echo esc_html($item['name'] ?? ''); ?></strong>
										<span><?php echo esc_html($item['role'] ?? ''); ?></span>
									</div>
								</div>
								<div class="content-right">
									<div class="img img-ratio ratio:pt-[371_362] rounded-6 zoom-img">
										<?php if (!empty($item['image']) && function_exists('get_image_attrachment')): ?>
											<?php echo get_image_attrachment($item['image'], 'image'); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="button-swiper-ues flex-center mt-base gap-6">
			<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="user"><div class="icon"></div></div>
			<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="user"><div class="icon"></div></div>
		</div>
	</div>
</section>
<?php endif; ?>
