<?php
$post_id = get_the_ID();

// Base post data
$post_title   = get_the_title();
$post_date    = get_the_date('d/m/Y');
$post_excerpt = get_the_excerpt();
$post_content = apply_filters('the_content', get_the_content());
$post_cats    = get_the_category($post_id);

// ACF fields
$doctor_post          = get_field('post_doctor_consult', $post_id);
$faq_items            = get_field('post_faq_items', $post_id);
$references           = get_field('post_references', $post_id);
$post_related_heading = get_field('post_related_heading', $post_id);

if (!$post_related_heading) {
	$post_related_heading = 'Bài viết cùng chủ đề';
}

// Doctor data
$doctor_id          = $doctor_post ? (int) $doctor_post->ID : 0;
$doctor_name        = $doctor_id ? get_the_title($doctor_id) : '';
$doctor_credential  = $doctor_id ? get_field('doctor_credential', $doctor_id) : '';
$doctor_permalink   = $doctor_id ? get_permalink($doctor_id) : '';
$doctor_booking     = $doctor_id ? get_field('doctor_booking_link', $doctor_id) : array();
$doctor_avatar_html = '';

if ($doctor_id) {
	$doctor_avatar_html = function_exists('get_image_post') ? get_image_post($doctor_id, 'image') : '';
	if (!$doctor_avatar_html) {
		$doctor_avatar_html = get_the_post_thumbnail($doctor_id, 'full', array('class' => 'lozad'));
	}
}

// TOC: parse headings from content, inject IDs
$toc_headings = array();
$post_content_with_ids = preg_replace_callback(
	'/<(h[2-4])([^>]*)>(.*?)<\/h[2-4]>/is',
	function ($matches) use (&$toc_headings) {
		$tag   = strtolower($matches[1]);
		$attrs = $matches[2];
		$inner = $matches[3];
		$text  = wp_strip_all_tags($inner);
		$id    = sanitize_title($text);

		// Ensure unique ID
		$base_id = $id;
		$count   = 1;
		$used    = array_column($toc_headings, 'id');
		while (in_array($id, $used, true)) {
			$id = $base_id . '-' . $count++;
		}

		$toc_headings[] = array('id' => $id, 'text' => $text, 'tag' => $tag);

		if (!preg_match('/\bid\s*=/i', $attrs)) {
			$attrs .= ' id="' . esc_attr($id) . '"';
		}

		return '<' . $tag . $attrs . '>' . $inner . '</' . $tag . '>';
	},
	$post_content
);

// Related posts by category
$related_query = null;
if (!empty($post_cats)) {
	$cat_ids = wp_list_pluck($post_cats, 'term_id');
	$related_query = new WP_Query(array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'post__not_in'        => array($post_id),
		'category__in'        => $cat_ids,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	));
}

// Share URLs
$share_url   = rawurlencode(get_permalink());
$share_title = rawurlencode(get_the_title());
$theme_uri   = get_template_directory_uri();
?>
<section class="section-NewDetail">
	<div class="section-pt">
		<div class="container block-flex">

			<div class="block-social">
				<div class="main-social">
					<span class="share"><?php esc_html_e('Chia sẻ', 'canhcamtheme'); ?></span>
					<ul>
						<li>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"
								target="_blank" rel="noopener noreferrer">
								<img src="<?php echo esc_url($theme_uri . '/img/facebook-f.svg'); ?>" alt="Facebook">
							</a>
						</li>
						<li>
							<a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>"
								target="_blank" rel="noopener noreferrer">
								<img src="<?php echo esc_url($theme_uri . '/img/twitter-x.svg'); ?>" alt="Twitter/X">
							</a>
						</li>
						<li>
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>"
								target="_blank" rel="noopener noreferrer">
								<img src="<?php echo esc_url($theme_uri . '/img/linkedin.svg'); ?>" alt="LinkedIn">
							</a>
						</li>
						<li>
							<a href="mailto:?subject=<?php echo $share_title; ?>&body=<?php echo $share_url; ?>">
								<img src="<?php echo esc_url($theme_uri . '/img/email.svg'); ?>" alt="Email">
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="block-row row">
				<div class="col-xl-8">
					<div class="main-new">

						<div class="title-new">
							<h1 class="heading-36 text-primary-1 title-heading"><?php echo esc_html($post_title); ?></h1>
							<div class="category-date">
								<div class="date"><?php echo esc_html($post_date); ?></div>
								<?php if (!empty($post_cats)) : ?>
								<div class="cate">
									<?php foreach ($post_cats as $cat) : ?>
									<span><?php echo esc_html($cat->name); ?></span>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>

						<?php if ($doctor_id && $doctor_name) : ?>
						<div class="profile-doctor">
							<div class="doctor-info">
								<?php if ($doctor_avatar_html) : ?>
								<div class="avatar">
									<div class="img img-ratio ratio:pt-[1_1]">
										<?php echo $doctor_avatar_html; ?>
									</div>
								</div>
								<?php endif; ?>
								<div class="profile">
									<span class="consultation"><?php esc_html_e('Tham vấn y khoa:', 'canhcamtheme'); ?></span>
									<span class="name"><?php echo esc_html(trim(($doctor_credential ? $doctor_credential . ' ' : '') . $doctor_name)); ?></span>
									<span class="hospital"><?php echo esc_html(get_bloginfo('name')); ?></span>
								</div>
							</div>
							<div class="doctor-button">
								<?php if ($doctor_permalink) : ?>
								<a class="btn btn-blue btn-icon" href="<?php echo esc_url($doctor_permalink); ?>">
									<span><?php esc_html_e('Xem thông tin', 'canhcamtheme'); ?></span>
									<div class="icon is-tertiary"></div>
								</a>
								<?php endif; ?>
								<?php if (!empty($doctor_booking['url'])) : ?>
								<a class="btn btn-green btn-icon"
									href="<?php echo esc_url($doctor_booking['url']); ?>"
									<?php echo !empty($doctor_booking['target']) ? 'target="' . esc_attr($doctor_booking['target']) . '"' : ''; ?>>
									<span><?php echo esc_html(!empty($doctor_booking['title']) ? $doctor_booking['title'] : 'Đặt lịch hẹn'); ?></span>
									<div class="icon is-tertiary"></div>
								</a>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>

						<?php if ($post_excerpt) : ?>
						<div class="describe">
							<p><?php echo esc_html($post_excerpt); ?></p>
						</div>
						<?php endif; ?>

						<?php if (!empty($toc_headings)) : ?>
						<div class="category">
							<div class="title-category">
								<span class="material-symbols-outlined">format_list_bulleted</span>
								<span><?php esc_html_e('Nội dung chính', 'canhcamtheme'); ?></span>
							</div>
							<div class="main-category" id="menu-spy">
								<ul>
									<?php foreach ($toc_headings as $idx => $heading) : ?>
									<li class="<?php echo $idx === 0 ? 'active' : ''; ?>">
										<a class="item-scroll"
											href="#<?php echo esc_attr($heading['id']); ?>"><?php echo esc_html($heading['text']); ?></a>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php endif; ?>

						<div class="prose">
							<?php echo $post_content_with_ids; ?>
						</div>

					</div>

					<?php if (!empty($faq_items)) : ?>
					<div class="wrap-item-toggle auto-active-first" data-lenis-prevent>
						<h2 class="heading-3 text-primary-1 mb-4">
							<?php esc_html_e('Những câu hỏi thường gặp', 'canhcamtheme'); ?>
						</h2>
						<?php foreach ($faq_items as $faq) :
							$question = isset($faq['question']) ? $faq['question'] : '';
							$answer   = isset($faq['answer']) ? $faq['answer'] : '';
							if (!$question && !$answer) continue;
						?>
						<div class="item-toggle">
							<div class="title">
								<span><?php echo esc_html($question); ?></span>
								<span class="material-symbols-outlined">keyboard_arrow_down</span>
							</div>
							<?php if ($answer) : ?>
							<div class="content">
								<?php echo wp_kses_post($answer); ?>
							</div>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<?php if (!empty($references)) : ?>
					<div class="reference" data-lenis-prevent>
						<div class="title"><span><?php esc_html_e('Nguồn tham khảo', 'canhcamtheme'); ?></span></div>
						<ul>
							<?php foreach ($references as $ref) :
								$ref_label = isset($ref['ref_label']) ? $ref['ref_label'] : '';
								$ref_url   = isset($ref['ref_url']) ? $ref['ref_url'] : '';
								$ref_desc  = isset($ref['ref_desc']) ? $ref['ref_desc'] : '';
								if (!$ref_label && !$ref_desc) continue;
							?>
							<li>
								<a href="<?php echo $ref_url ? esc_url($ref_url) : 'javascript:void(0)'; ?>"
									<?php echo $ref_url ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
									<strong><?php echo esc_html($ref_label); ?></strong>
									<?php if ($ref_desc) : ?>
									<p><?php echo esc_html($ref_desc); ?></p>
									<?php endif; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>

				<div class="col-xl-4">
					<?php get_template_part('template-parts/component/form', 'consult'); ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ($related_query && $related_query->have_posts()) : ?>
	<div class="pt-base">
		<div class="container">
			<div class="section-pb">
				<h2 class="heading-36 text-primary-1 uppercase mb-base">
					<?php echo esc_html($post_related_heading); ?>
				</h2>
				<div class="block-swiper relative">
					<div class="swiper-column-auto auto-3-column" data-id-swiper="NewDetail">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
								<div class="swiper-slide">
									<?php get_template_part('template-parts/component/card', 'new'); ?>
								</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
					<div class="button-swiper">
						<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="NewDetail">
							<div class="icon"></div>
						</div>
						<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="NewDetail">
							<div class="icon"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
