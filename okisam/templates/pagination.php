<div class="pagination">
	<?php 
		echo paginate_links(array(
			'format' => 'page/%#%',
			'prev_text'    => 'Siguiente',
			'next_text'    => 'Anterior',
			'before_page_number'    => '<span>',
			'after_page_number'    => '</span>',
		));
	?>
</div>