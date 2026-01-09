<div class="bg-white">
	<div class="box mx-a mt-45 pt-20 px-15 mb-25">
		<div class="d-f fxww ai-c">
			<div class="col-12 col-md-8 ta-c mx-a pt-25"> 

				<div class="red-line mx-a"></div>
				<h1 class="my-20 pb-15">
					<span class="d-b ff-canela fz-48 fw-700 c-gray-6">
						Categoría
					</span>
					<span class="d-b ff-canela c-red fz-48 fw-700">
						<?php echo single_term_title("", false); ?>
					</span>
				</h1>
			</div>
		</div>
	</div>
</div> 

<div class="bg-white">
	<div class="box mx-a my-30 px-15">
		<div class="d-f fxww ai-c">
			<div class="col-12 ta-c"> 
				<?php $term = get_queried_object(); ?>
				<ul class="list-n">

					<?php 
						$args = array(
						  'orderby' => 'name',
						  'order' => 'ASC',
						  'exclude' => array(16, 15, 18, 17),
						  //'parent' => 0
						);
					?>
					<?php $categories = get_categories($args); foreach($categories as $category) { ?>
						<?php $class = ( is_category( $category->name ) ) ? ' bd-red c-red' : ' bd-gray-6 c-gray-6'; ?>
						<li class="d-ib mx-15 mb-20">
							<a class="d-ib tt-u bd-1 bdrs-32 fz-14 fw-500 py-5 px-15 lh-24 opacity-hover<?php echo $class; ?>" href="<?php echo get_category_link($category->term_id);?>">
								<?php echo $category->name; ?>		
							</a>
						</li>
					<?php } ?>
				</ul>
<!-- 				<ul class="list-n">
					
					<?php $children = get_terms( $term->taxonomy, array( 'parent' => $term->term_id, 'hide_empty' => false ) ); ?>
					<?php if ( $children ) {  ?>
					    <?php foreach( $children as $subcat ) { ?>
					    	<li class="d-ib mx-15 mb-20">
						    	<a class="d-ib tt-u bd-1 bd-gray-6 bdrs-32 c-gray-6 fz-12 fw-500 py-5 px-15 lh-20" href="<?php echo esc_url(get_term_link($subcat, $subcat->taxonomy)) ;?>">
						    		<?php echo $subcat->name; ?>		
						    	</a>
					    	</li>
					    <?php } ?>
					<?php } ?> 
					
				</ul> -->
			</div>
		</div>
	</div>
</div> 

<?php get_template_part('templates/search-form'); ?>

<div class="box mx-a px-15">
	<div class="d-f fxww m-ng">
		<?php if (have_posts()): ?>
		    <?php while ( have_posts() ) : the_post(); ?>  
				<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
		    <?php endwhile; ?>
		<?php endif ?>
		<?php wp_reset_query(); ?>
	</div>
</div> 

<div class="box mx-a px-15">
	<div class="d-f fxww ai-c">
		<div class="col-12"> 
			<div class="loadmore d-f fxww m-ng"></div>
			<div class="pos-r">
				<div class="center-all pos-a d-n" id="loading-gif">
					<span class="loader"></span>
				</div>
			</div>
			<div class="col-12 ta-c">
					<?php
						global $wp_query;
						if (  $wp_query->max_num_pages > 1 ) { 
					?>
					<p class="mx-a ta-c my-45">
						<span data-paged="1" class="d-ib bg-red bdrs-32 c-white px-30 py-15 button_cats cur-p fz-14 lh-24">
						        Ver más       
						</span>
					</p>
					<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="py-45">
	<div class="box mx-a px-15 bg-gray-6 py-45 mb-45">
		<div class="d-f fxww ai-c">
			<div class="col-12 col-lg-5 mx-a ta-c"> 
				<?php if( have_rows('titulo_page_blog_b4', get_option( 'page_for_posts' )) ): ?>
				    <?php while ( have_rows('titulo_page_blog_b4', get_option( 'page_for_posts' )) ) : the_row(); ?>
				    	<<?php echo get_sub_field('tipo_de_etiqueta'); ?> class="my-45 py-5">
							<?php if( get_sub_field('texto_canela_rojo') ): ?>
								<span class="d-i ff-canela fz-46 fw-700 c-red">
									<?php echo get_sub_field('texto_canela_rojo'); ?> 
								</span>
							<?php endif; ?>
							<?php if( get_sub_field('texto_canela_blanco') ): ?>
								<span class="d-i ff-canela fz-46 fw-700 c-white">
									<?php echo get_sub_field('texto_canela_blanco'); ?>
								</span>
							<?php endif; ?>
						</<?php echo get_sub_field('tipo_de_etiqueta'); ?>>
				    <?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="d-f fxww ai-c">
			<div class="col-12 col-lg-5 mx-a ta-c"> 
				<div class="c-white mb-45 pb-5">
					Formulario (Necesito más info aquí, estoy a espera de respuesta)
				</div>
			</div>
		</div>
	</div>
</div>