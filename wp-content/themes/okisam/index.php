<div class="box mx-a mt-25 px-15 py-25">
	<div class="d-f fxww">
		<div class="col-12 p-45 ta-c">
			Blog
		</div>
	</div>
	<div class="d-f fxww ta-c">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		<?php endif; ?>
	</div>
</div>