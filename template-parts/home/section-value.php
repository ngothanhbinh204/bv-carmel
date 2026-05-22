<?php if (get_field('show_section_value') !== false): 
	$title = get_field('value_title');
	$desc = get_field('value_description');
?>
<section class="section-value">
	<div class="section-py-60">
		<div class="container">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="heading-1 text-primary title-heading block text-center"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($desc): ?>
					<div class="sub-title">
						<div><?php echo wp_kses_post($desc); ?></div>
					</div>
				<?php endif; ?>
			</div>
			<div class="box-grid">
				<?php if (have_rows('value_items')): ?>
					<?php while (have_rows('value_items')): the_row(); 
						$icon = get_sub_field('icon');
						$content = get_sub_field('content');
						$link = get_sub_field('link');
					?>
					<a class="card-value group" href="<?php echo $link ? esc_url($link['url']) : 'javascript:void(0)'; ?>">
						<div class="icon">
							<?php if ($icon): ?>
								<span class="material-symbols-outlined"><?php echo esc_html($icon); ?></span>
							<?php else: ?>
								<!-- Tạm dùng icon material nếu không nhập -->
								<span class="material-symbols-outlined">groups</span>
							<?php endif; ?>
						</div>
						<div class="content">
							<span><?php echo esc_html($content); ?></span>
						</div>
					</a>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
