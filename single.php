<?php get_header(); ?>
<?php get_template_part('modules/common/banner'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php get_template_part('template-parts/news/section', 'detail'); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>