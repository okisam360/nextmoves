<?php
// Limpiar caracters especiales
class CleanImageFilenames {
	function __construct() {
		add_action( 'wp_handle_upload_prefilter', array( $this, 'upload_filter' ) );
		add_action( 'add_attachment', array( $this, 'update_attachment_title' ) );
	}
	function upload_filter( $file ) {
		$original_filename = pathinfo( $file[ 'name' ] );
		set_transient( '_clean_image_filenames_original_filename', $original_filename[ 'filename' ], 60 );
		$file = $this->clean_filename( $file );
	    return $file;
	}
	function clean_filename( $file ) {
		$input = array(
			'ß', 
			'·', 
		);
		$output = array(
			'ss', 
			'.' 
		);
		$path = pathinfo( $file[ 'name' ] );
		$new_filename = preg_replace( '/.' . $path[ 'extension' ] . '$/', '', $file[ 'name' ] );
		$new_filename = str_replace( $input, $output, $new_filename );
		$file[ 'name' ] = sanitize_title( $new_filename ) . '.' . $path[ 'extension' ];
		return $file;
	}
	function update_attachment_title( $attachment_id ) {
		$original_filename = get_transient( '_clean_image_filenames_original_filename' );
		if ( $original_filename ) {
			wp_update_post( array( 'ID' => $attachment_id, 'post_title' => $original_filename ) );
			delete_transient( '_clean_image_filenames_original_filename' );
		}
	}
}
$clean_image_filenames = new CleanImageFilenames();

// Image sizes
add_image_size( 'thumbnail', 90, 90, true );

update_option( 'thumbnail_size_w', 90 );
update_option( 'thumbnail_size_h', 90 );

update_option( 'medium_size_w', 360 );
update_option( 'medium_size_h', 360 );

update_option( 'medium_large_size_w', 720 );
update_option( 'medium_large_size_h', 720 );

update_option( 'large_size_w', 1440 );
update_option( 'large_size_h', 1440 );


// Forzar que no se guarden las imagenes por fecha
add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_zero');