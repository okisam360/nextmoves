<div class="fz-12 c-gray-1">
	<!-- <span class="byline author vcard">
		<span rel="author" class="fn ls-1-5 cl-4 fz-14"><?= get_the_author(); ?></span>
	</span> -->
	<!-- <span class="fz-14">
		<?php $tipos = get_the_terms( $post->ID, 'category' ); ?> 
		<?php foreach ($tipos as $tipo) { ?>
		    <?php //echo '<pre>' . print_r($tipo, true) . '</pre>'; ?>
		    <a href="<?php echo bloginfo('url') . '/category/' . $tipo->slug; ?>" class="c-red">
		        <?php echo $tipo->name; ?>
		    </a>
		    <?php if (next( $tipos )) { ?>
		    	<span class="c-red"> / </span>
	    	<?php } ?>
		<?php } ?>
	</span> -->
	<span class="">
		<time class="updated tt-c" datetime="<?= get_post_time('c', true); ?>">
			<?= substr(get_the_date('F'), 0, 3); ?> 	
			<?= get_the_date('d'); ?>,  		
			<?= get_the_date('Y'); ?>		
		</time>
	</span>
	<span class="pl-15">  
		<?php echo wp_lecture_time(); ?>
	</span>
	<!-- <span class="pl-10 fw-b tt-u fz-14 cl-3 va-b num-comments">
	    <?php
			$num_comments = get_comments_number(); 
			if ( $num_comments > 0 ) {
				if ( $num_comments == 1 ) {
					echo $num_comments . ' comentario';
				}else{
					echo $num_comments . ' comentarios';
				}
			}
		?>
	</span> -->
</div>