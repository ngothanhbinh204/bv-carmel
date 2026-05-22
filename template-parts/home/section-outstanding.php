<?php if (get_field('show_section_outstanding') !== false): 
	$title = get_field('outstanding_title');
	$btn = get_field('outstanding_button');
?>
<section class="section-outstanding">
	<div class="section-py">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="title-heading text-center block heading-1 text-primary-1"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
			</div>
			<div class="block-swiper">
				<div class="swiper-column-auto auto-4-column" data-id-swiper="outstanding">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php 
							$args = array(
								'post_type' => 'chuyen-khoa',
								'posts_per_page' => 12,
								'post_status' => 'publish'
							);
							$specialty_query = new WP_Query($args);
							if ($specialty_query->have_posts()):
								// Chia nhóm 2 item vào 1 slide
								$posts_chunk = array_chunk($specialty_query->posts, 2);
								foreach ($posts_chunk as $chunk):
							?>
							<div class="swiper-slide">
								<div class="box-grid">
									<?php 
									foreach ($chunk as $post): 
										setup_postdata($post);
										get_template_part('template-parts/component/card', 'outstanding');
									endforeach; 
									?>
								</div>
							</div>
							<?php 
								endforeach;
								wp_reset_postdata();
							endif; 
							?>
						</div>
					</div>
				</div>
				<div class="button-swiper">
					<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="outstanding">
						<div class="icon"></div>
					</div>
					<div class="btn-swiper btn-next btn-swiper-secondary" data-id-swiper="outstanding">
						<div class="icon"></div>
					</div>
				</div>
			</div>
			
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
