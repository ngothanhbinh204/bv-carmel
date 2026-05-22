<?php if (get_field('show_section_space') !== false):
	$title    = get_field('space_title');
	$subtitle = get_field('space_subtitle');
	$tabs     = get_field('space_tabs'); // repeater: tab_name + images (gallery)
?>
<section class="section-space">
	<div class="section-py">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="heading-1 title-heading text-primary-1 block text-center"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($subtitle): ?>
					<div class="sub-title">
						<?php echo wp_kses_post($subtitle); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="gsap-tabs-wrapper" data-gsap-tabs-options="{'effect': 'fade-up', 'event': 'click', 'mobileEvent': 'click', 'triggerScale': 1}">
				<?php if ($tabs): ?>
				<div class="filter-dropdown">
					<div class="filter-toggle">
						<span class="selected-text"><?php echo esc_html($tabs[0]['tab_name']); ?></span>
						<i class="fa-regular fa-chevron-down"></i>
					</div>
					<ul class="tab-triggers filter-menu">
						<?php foreach ($tabs as $i => $tab): ?>
						<li class="<?php echo $i === 0 ? 'active' : ''; ?>" data-tab-trigger="<?php echo $i; ?>">
							<a class="nav-link" href="javascript:void(0)"><span><?php echo esc_html($tab['tab_name']); ?></span></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="tab-contents relative mt-base">
					<?php foreach ($tabs as $i => $tab): ?>
					<div class="tab-pane w-full" data-tab-content="<?php echo $i; ?>">
						<div class="swiper-dynamic-config" data-id-swiper="space-<?php echo $i; ?>"
							data-swiper-options='{"slidesPerView": "1.5", "spaceBetween": "getVw(20,40)", "centeredSlides": true, "loop": true}'>
							<div class="swiper">
								<div class="swiper-wrapper">
									<?php if (!empty($tab['images'])): ?>
										<?php foreach ($tab['images'] as $img): ?>
										<div class="swiper-slide">
											<div class="img img-ratio ratio:pt-[518_919] zoom-img rounded-6">
												<?php if (function_exists('get_image_attrachment')): ?>
													<?php echo get_image_attrachment($img, 'image'); ?>
												<?php endif; ?>
											</div>
										</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="button-swiper">
								<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="space-<?php echo $i; ?>"><div class="icon"></div></div>
								<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="space-<?php echo $i; ?>"><div class="icon"></div></div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
