<div class="navigation-posts">
	<div class="box box-xl box-xxl mx-a my-30 px-15">
		<div class="d-f fxww m-ng">
			<div class="col-12 col-lg-10 px-45 py-45 mx-a">
				<?php 
					$site_url = get_site_url();
					$args = wp_parse_args(
						$args,
						array(
							'prev_text'          => "<span class='d-b d-md-ib pr-10 c-darkred'>Anterior</span> <img src='$site_url/app/images/prev-post.svg'>" . '<span class="d-b c-darkblue fz-18">%title</span>',
							'next_text'          => "<span class='d-b d-md-ib pr-10 c-darkred'>Siguiente</span> <img src='$site_url/app/images/next-post.svg'>" . '<span class="d-b c-darkblue fz-18">%title</span>',
							'excluded_terms'     => '',
							//'taxonomy'           => 'category',
							'screen_reader_text' => ' ',
							'class'              => 'post-navigation',
							'in_same_term' => false,
						)
					);
				?>
				<?php echo get_the_post_navigation( $args ); ?>
			</div>
		</div>
	</div>
</div>