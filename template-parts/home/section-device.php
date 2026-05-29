<?php
$show_section_device = get_field('show_section_device');
$device_title = get_field('device_title');
$device_tabs = get_field('device_slides');

if ($show_section_device !== false && !empty($device_tabs)) :
	$prepared_tabs = array();
	foreach ($device_tabs as $tab_index => $tab_item) {
		$tab_label = !empty($tab_item['tab_label']) ? $tab_item['tab_label'] : 'Tab ' . ($tab_index + 1);
		$raw_target = !empty($tab_item['tab_target']) ? $tab_item['tab_target'] : $tab_label;
		$tab_target = sanitize_title($raw_target);
		if (!$tab_target) {
			$tab_target = 'device-tab-' . ($tab_index + 1);
		}

		$tab_gallery = !empty($tab_item['tab_gallery']) && is_array($tab_item['tab_gallery']) ? $tab_item['tab_gallery'] : array();
		$tab_content = !empty($tab_item['tab_content']) ? $tab_item['tab_content'] : '';
		$prepared_tabs[] = array(
			'label' => $tab_label,
			'target' => $tab_target,
			'gallery' => $tab_gallery,
			'content' => $tab_content,
		);
	}

	if (empty($prepared_tabs)) {
		return;
	}

	if (!$device_title) {
		$device_title = 'Co so vat chat<br>& Trang thiet bi hien dai';
	}
?>
<section class="section-device">
	<div class="section-pt">
		<div class="container">
			<div class="block-grid">
				<div class="swiper-left">
					<div class="swiper-img">
						<?php foreach ($prepared_tabs as $tab) : ?>
						<div class="swiper swiper-<?php echo esc_attr($tab['target']); ?>">
							<div class="swiper-wrapper">
								<?php foreach ($tab['gallery'] as $image) : ?>
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
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swiper-right">
					<div class="swiper-content">
						<h2 class="title-heading text-primary-1 heading-1 block mb-6">
							<?php echo wp_kses_post(nl2br(esc_html($device_title))); ?></h2>
						<div class="tabslet-wrapper">
							<div class="filter-dropdown">
								<div class="filter-toggle"><span
										class="selected-text"><?php echo esc_html($prepared_tabs[0]['label']); ?></span><i
										class="fa-regular fa-chevron-down"></i></div>
								<ul class="tabslet-tab filter-menu">
									<?php foreach ($prepared_tabs as $tab_index => $tab) : ?>
									<li class="<?php echo $tab_index === 0 ? 'active' : ''; ?> js-device-tab"
										data-target="<?php echo esc_attr($tab['target']); ?>"><a
											href="javascript:void(0)"><span><?php echo esc_html($tab['label']); ?></span></a>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="tabslet-content active">
								<?php foreach ($prepared_tabs as $tab) : ?>
								<div class="swiper swiper-<?php echo esc_attr($tab['target']); ?>">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<?php echo wp_kses_post($tab['content']); ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="swiper-thumb">
						<?php foreach ($prepared_tabs as $tab) : ?>
						<div class="swiper swiper-<?php echo esc_attr($tab['target']); ?>">
							<div class="swiper-wrapper">
								<?php foreach ($tab['gallery'] as $thumb_image) : ?>
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
						<div class="button-swiper-thumb swiper-btn-<?php echo esc_attr($tab['target']); ?>">
							<div class="btn-swiper btn-prev btn-swiper-primary"
								data-id-swiper="<?php echo esc_attr($tab['target']); ?>">
								<div class="icon"></div>
							</div>
							<div class="btn-swiper btn-next btn-swiper-secondary"
								data-id-swiper="<?php echo esc_attr($tab['target']); ?>">
								<div class="icon"></div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>