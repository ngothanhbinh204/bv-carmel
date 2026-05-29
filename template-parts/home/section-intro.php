<?php if (get_field('show_section_intro') !== false): 
	$title = get_field('intro_title');
	$desc = get_field('intro_description');
	$image = get_field('intro_image');
	$video_url = get_field('intro_video_url');
	$sub_desc = get_field('intro_sub_description');
	$btn = get_field('intro_button');
?>
<h1 class="hidden">Carmel</h1>
<section class="section-intro">
	<div class="section-py">
		<div class="container">
			<div class="box-grid">
				<div class="item-grid-left">
					<div class="content">
						<?php if ($title): ?>
						<h2 class="heading-1 text-primary-1 title-heading"><?php echo esc_html($title); ?></h2>
						<?php endif; ?>
						<?php if ($desc): ?>
						<div class="sub-title">
							<div><?php echo wp_kses_post($desc); ?></div>
						</div>
						<?php endif; ?>
					</div>
					<div class="image">
						<div class="img img-ratio ratio:pt-[346_631] zoom-img">
							<?php if ($image && function_exists('get_image_attrachment')) echo get_image_attrachment($image, 'image'); ?>
							<?php if ($video_url): ?>
							<a class="btn btn-play" href="<?php echo esc_url($video_url); ?>"
								data-fancybox="data-fancybox" data-fancybox-options="{&quot;infinite&quot;:true}">
								<div class="icon"><i class="fa-duotone fa-solid fa-play"></i></div>
							</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="item-grid-right">
					<div class="content">
						<?php if ($sub_desc): ?>
						<div class="sub-content">
							<div><?php echo wp_kses_post($sub_desc); ?></div>
						</div>
						<?php endif; ?>

						<?php if ($btn): ?>
						<a class="btn btn-primary btn-icon" href="<?php echo esc_url($btn['url']); ?>">
							<span><?php echo esc_html($btn['title']); ?></span>
							<div class="icon is-secondary"></div>
						</a>
						<?php endif; ?>
					</div>
					<div class="countup-content">
						<?php if (have_rows('intro_stats')): ?>
						<?php while (have_rows('intro_stats')): the_row(); 
								$stat_icon = get_sub_field('icon');
								$stat_num = get_sub_field('number');
								$stat_suffix = get_sub_field('suffix');
								$stat_title = get_sub_field('title');
							?>
						<div class="item-countup">
							<div class="icon">
								<?php if ($stat_icon && function_exists('get_image_attrachment')) echo get_image_attrachment($stat_icon, 'image'); ?>
							</div>
							<div class="number-countup"><span
									data-countup-options="{&quot;number&quot;: <?php echo esc_attr($stat_num); ?>, &quot;duration&quot;: 3, &quot;padZero&quot;: false}"></span><?php if (!empty($stat_suffix)) : ?><span><?php echo esc_html($stat_suffix); ?></span><?php endif; ?>
							</div>
							<div class="content"><?php echo esc_html($stat_title); ?></div>
						</div>
						<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>