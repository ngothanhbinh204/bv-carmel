<?php if (get_field('show_section_achievements') !== false):
	$title    = get_field('achievements_title');
	$subtitle = get_field('achievements_subtitle');
	$items    = get_field('achievements_items'); // repeater: image, date, title, desc, link
?>
<section class="section-achievements">
	<div class="section-py">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="heading-1 text-primary-1 title-heading block text-center"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($subtitle): ?>
					<div class="sub-title">
						<?php echo wp_kses_post($subtitle); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="block-swiper mt-base">
				<div class="swiper-column-auto auto-3-column relative" data-id-swiper="achievements">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php if ($items): ?>
								<?php foreach ($items as $item): ?>
								<div class="swiper-slide">
									<a class="card-new group" href="<?php echo !empty($item['link']['url']) ? esc_url($item['link']['url']) : 'javascript:void(0)'; ?>">
										<div class="img img-ratio ratio:pt-[220_440] zoom-img">
											<?php if (!empty($item['image']) && function_exists('get_image_attrachment')): ?>
												<?php echo get_image_attrachment($item['image'], 'image'); ?>
											<?php endif; ?>
										</div>
										<div class="content-new">
											<?php if (!empty($item['date'])): ?>
												<div class="date"><span><?php echo esc_html($item['date']); ?></span></div>
											<?php endif; ?>
											<div class="content">
												<?php if (!empty($item['title'])): ?>
													<div class="title-new"><?php echo esc_html($item['title']); ?></div>
												<?php endif; ?>
												<?php if (!empty($item['desc'])): ?>
													<div class="desc-new"><?php echo wp_kses_post($item['desc']); ?></div>
												<?php endif; ?>
											</div>
											<button class="btn btn-primary btn-icon">
												<span>Xem chi tiết</span>
												<div class="icon is-secondary"></div>
											</button>
										</div>
									</a>
								</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="button-swiper">
						<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="achievements"><div class="icon"></div></div>
						<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="achievements"><div class="icon"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
