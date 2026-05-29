<?php if (get_field('show_section_achievements') !== false):
	$title    = get_field('achievements_title');
	$subtitle = get_field('achievements_subtitle');
	$posts    = get_field('achievements_posts');
?>
<section class="section-achievements">
	<div class="section-py">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
				<h2 class="heading-1 text-primary-1 title-heading block text-center"><?php echo esc_html($title); ?>
				</h2>
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
							<?php if (!empty($posts)): ?>
							<?php foreach ($posts as $post_item): ?>
							<?php
									$post_id = is_object($post_item) ? (int) $post_item->ID : (int) $post_item;
									if (!$post_id) {
										continue;
									}

									$post_title = get_the_title($post_id);
									$post_link = get_permalink($post_id);
									$post_date = get_the_date('d/m/Y', $post_id);
									$post_desc = get_the_excerpt($post_id, 999);
									$post_thumb = get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
								?>
							<div class="swiper-slide">
								<a class="card-new group"
									href="<?php echo esc_url($post_link ? $post_link : 'javascript:void(0)'); ?>">
									<div class="img img-ratio ratio:pt-[220_440] zoom-img">
										<?php if (!empty($post_thumb)): ?>
										<?php echo $post_thumb; ?>
										<?php endif; ?>
									</div>
									<div class="content-new">
										<?php if (!empty($post_date)): ?>
										<div class="date"><span><?php echo esc_html($post_date); ?></span></div>
										<?php endif; ?>
										<div class="content">
											<?php if (!empty($post_title)): ?>
											<div class="title-new"><?php echo esc_html($post_title); ?></div>
											<?php endif; ?>
											<?php if (!empty($post_desc)): ?>
											<div class="desc-new"><?php echo esc_html($post_desc); ?></div>
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
						<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="achievements">
							<div class="icon"></div>
						</div>
						<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="achievements">
							<div class="icon"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>