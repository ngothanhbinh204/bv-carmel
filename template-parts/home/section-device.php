<?php
$show_section_device = get_field('show_section_device');
$device_slides = get_field('device_slides');

if ($show_section_device !== false && !empty($device_slides)) :
?>
<section class="section-device">
	<div class="section-pt">
		<div class="container">
			<div class="block-grid">
				<div class="swiper-left">
					<div class="swiper-img">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ($device_slides as $slide) : ?>
								<?php
								$image = isset($slide['image']) ? $slide['image'] : null;
								?>
								<div class="swiper-slide">
									<div class="img img-ratio ratio:pt-[581_720] rounded-6 zoom-img">
										<?php if ($image && function_exists('get_image_attrachment')) {
											echo get_image_attrachment($image, 'image');
										} ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="swiper-right">
					<div class="swiper-content">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ($device_slides as $slide_index => $slide) : ?>
								<?php
								$slide_title = isset($slide['title']) ? $slide['title'] : '';
								$slide_tabs = !empty($slide['slide_tabs']) && is_array($slide['slide_tabs']) ? $slide['slide_tabs'] : array();

								$first_tab_label = !empty($slide_tabs[0]['tab_label']) ? $slide_tabs[0]['tab_label'] : 'Nội dung';
								?>
								<div class="swiper-slide">
									<?php if ($slide_title) : ?>
									<h2 class="title-heading text-primary-1 heading-1 block mb-6">
										<?php echo wp_kses_post(nl2br(esc_html($slide_title))); ?></h2>
									<?php endif; ?>

									<?php if (!empty($slide_tabs)) : ?>
									<div class="tabslet-wrapper" data-toggle="tabslet">
										<div class="filter-dropdown">
											<div class="filter-toggle"><span
													class="selected-text"><?php echo esc_html($first_tab_label); ?></span><i
													class="fa-regular fa-chevron-down"></i></div>
											<ul class="tabslet-tab filter-menu">
												<?php foreach ($slide_tabs as $tab_index => $tab) : ?>
												<?php
												$tab_label = !empty($tab['tab_label']) ? $tab['tab_label'] : 'Tab ' . ($tab_index + 1);
												$tab_id = 'device-tab-' . ($slide_index + 1) . '-' . ($tab_index + 1);
												?>
												<li class="<?php echo $tab_index === 0 ? 'active' : ''; ?>"><a href=""
														data-href="#<?php echo esc_attr($tab_id); ?>"><span><?php echo esc_html($tab_label); ?></span></a>
												</li>
												<?php endforeach; ?>
											</ul>
										</div>

										<?php foreach ($slide_tabs as $tab_index => $tab) : ?>
										<?php
										$tab_content = !empty($tab['tab_content']) ? $tab['tab_content'] : '';
										$tab_id = 'device-tab-' . ($slide_index + 1) . '-' . ($tab_index + 1);
										?>
										<div class="tabslet-content <?php echo $tab_index === 0 ? 'active' : ''; ?>"
											id="<?php echo esc_attr($tab_id); ?>">
											<?php echo wp_kses_post($tab_content); ?>
										</div>
										<?php endforeach; ?>
									</div>
									<?php endif; ?>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="swiper-thumb">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ($device_slides as $slide) : ?>
								<?php
								$thumb_image = isset($slide['image']) ? $slide['image'] : null;
								?>
								<div class="swiper-slide">
									<div class="img img-ratio ratio:pt-[151_192] zoom-img rounded-6">
										<?php if ($thumb_image && function_exists('get_image_attrachment')) {
											echo get_image_attrachment($thumb_image, 'image');
										} ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="button-swiper-thumb">
							<div class="btn-swiper btn-prev btn-swiper-primary">
								<div class="icon"></div>
							</div>
							<div class="btn-swiper btn-next btn-swiper-secondary">
								<div class="icon"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>