<?php if (get_field('show_section_new') !== false): 
	$title = get_field('new_title');
?>
<section class="section-new">
	<div class="section-py">
		<div class="container">
			<div class="gsap-tabs-wrapper" data-gsap-tabs-options="{'effect': 'fade-up', 'event': 'click', 'mobileEvent': 'click', 'triggerScale': 1}">
				<div class="content">
					<?php if ($title): ?>
						<h2 class="heading-1 text-center block text-primary-1"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>
					<?php 
					$categories = get_terms(array(
						'taxonomy' => 'category',
						'hide_empty' => true,
					));
					if (!empty($categories) && !is_wp_error($categories)): 
						$first_cat = $categories[0]->name;
					?>
					<div class="filter-dropdown">
						<div class="filter-toggle"><span class="selected-text"><?php echo esc_html($first_cat); ?></span><i class="fa-regular fa-chevron-down"></i></div>
						<ul class="tab-triggers filter-menu">
							<?php foreach ($categories as $index => $cat): ?>
							<li class="<?php echo $index === 0 ? 'active' : ''; ?>" data-tab-trigger="<?php echo $index; ?>"><a class="nav-link" href="javascript:void(0)"><span><?php echo esc_html($cat->name); ?></span></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
				<div class="tab-contents relative mt-base">
					<?php 
					if (!empty($categories) && !is_wp_error($categories)): 
						foreach ($categories as $index => $cat): 
					?>
					<!-- Tab <?php echo esc_html($cat->name); ?> -->
					<div class="tab-pane w-full" data-tab-content="<?php echo $index; ?>">
						<div class="swiper-column-auto auto-3-column relative" data-id-swiper="new-<?php echo $index; ?>">
							<div class="swiper">
								<div class="swiper-wrapper">
									<?php 
									$args = array(
										'post_type' => 'post',
										'posts_per_page' => 6,
										'post_status' => 'publish',
										'cat' => $cat->term_id
									);
									$query = new WP_Query($args);
									if ($query->have_posts()):
										while ($query->have_posts()): $query->the_post();
									?>
									<div class="swiper-slide">
										<?php get_template_part('template-parts/component/card', 'new'); ?>
									</div>
									<?php 
										endwhile;
										wp_reset_postdata();
									endif; 
									?>
								</div>
							</div>
							<div class="button-swiper">
								<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="new-<?php echo $index; ?>">
									<div class="icon"></div>
								</div>
								<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="new-<?php echo $index; ?>">
									<div class="icon"></div>
								</div>
							</div>
						</div>
					</div>
					<?php 
						endforeach; 
					endif; 
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
