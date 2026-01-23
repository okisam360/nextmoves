<?php

/**
 * Module: Artículo
 * Displays an article module
 */

$title = isset($module['article_title']) ? $module['article_title'] : '';
$excerpt = isset($module['article_excerpt']) ? $module['article_excerpt'] : '';
$content = isset($module['article_content']) ? $module['article_content'] : '';
$image = isset($module['article_image']) ? $module['article_image'] : '';
$color = isset($module['article_color']) ? $module['article_color'] : 'default';
$url = isset($module['article_url']) ? $module['article_url'] : '';
$card_id = isset($module['card_id']) ? $module['card_id'] : '';

// If no card_id is provided, use a sanitized version of the title
if (!$card_id && $title) {
	$card_id = sanitize_title($title);
}

// Prepare share URL with post parameter
$share_url = $url ? $url : home_url('/');
if ($card_id) {
    $share_url = add_query_arg('post', $card_id, $share_url);
}

// Modal fields
$author_name = isset($module['article_author_name']) ? $module['article_author_name'] : '';
$author_image = isset($module['article_author_image']) ? $module['article_author_image'] : '';
$date = isset($module['article_date']) ? $module['article_date'] : '';
$read_time = isset($module['article_read_time']) ? $module['article_read_time'] : '';

// Format date: Feb 14, 2026
if ($date) {
	// Support d/m/Y format by replacing / with - for strtotime
	$clean_date = str_replace('/', '-', $date);
	$date_timestamp = strtotime($clean_date);
	if ($date_timestamp) {
		$date = date_i18n('M j, Y', $date_timestamp);
		$date = ucfirst($date); // Ensure first letter is capitalized (e.g., Feb)
	}
}
$size = isset($module['article_size']) ? $module['article_size'] : '1x1';

$image_url = is_array($image) ? $image['url'] : $image;
$author_image_url = is_array($author_image) ? $author_image['url'] : $author_image;
$modal_id = 'modal-article-' . uniqid();
?>

<div class="module module-articulo module-size-<?php echo esc_attr($size); ?> module-color-<?php echo esc_attr($color); ?>">
	<?php if ($image_url): ?>
		<div class="module-image">
			<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
		</div>
	<?php endif; ?>

	<div class="module-content">
		<?php if ($date || $read_time): ?>
			<div class="article-info">
				<?php if ($date): ?>
					<span class="article-date"><?php echo esc_html($date); ?></span>
				<?php endif; ?>
				
				<?php if ($read_time): ?>
					<span class="article-read-time">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
							<circle cx="12" cy="12" r="10"></circle>
							<polyline points="12 6 12 12 16 14"></polyline>
						</svg>
						<?php echo esc_html($read_time); ?> min leído
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
		<?php if ($title): ?>
			<h3 class="article-title"><?php echo esc_html($title); ?></h3>
		<?php endif; ?>

		<?php if ($excerpt): ?>
			<p class="article-excerpt"><?php echo esc_html($excerpt); ?></p>
		<?php endif; ?>

		<div class="module-action">
			<button class="btn-cta open-article-modal" data-modal="<?php echo esc_attr($modal_id); ?>" data-post="<?php echo esc_attr($card_id); ?>">Leer más</button>
		</div>
	</div>
</div>

<!-- Modal Structure -->
<div id="<?php echo esc_attr($modal_id); ?>" class="modal-article" style="display: none;">
	<div class="modal-article-overlay"></div>
	<div class="modal-article-container">
		<button class="modal-article-close">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg>
		</button>

		<div class="modal-article-header">
			<?php if ($title): ?>
				<h2 class="modal-article-title h2-bold"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>

			<div class="modal-article-meta">
				<div class="modal-article-author">
					<?php if ($author_image_url): ?>
						<div class="modal-article-author-image">
							<img src="<?php echo esc_url($author_image_url); ?>" alt="<?php echo esc_attr($author_name); ?>">
						</div>
					<?php endif; ?>

					<?php if ($author_name): ?>
						<span class="body-s-regular text-neutral-20"><?php echo esc_html($author_name); ?></span>
					<?php endif; ?>
				</div>

				<div class="modal-article-info">
					<?php if ($date): ?>
						<span class="modal-article-date"><?php echo esc_html($date); ?></span>
					<?php endif; ?>

					<?php if ($read_time): ?>
						<span class="modal-article-read-time">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
								<circle cx="12" cy="12" r="10"></circle>
								<polyline points="12 6 12 12 16 14"></polyline>
							</svg>
							<?php echo esc_html($read_time); ?> min leído
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="modal-article-content-wrapper">
			<div class="modal-article-content">
				<?php echo wp_kses_post(wpautop($content)); ?>
			</div>
		</div>

		<div class="modal-article-footer">
			<div class="modal-article-share">
				<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="share-icon">
					<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="41.4288" height="41.441" rx="20.7144" fill="#EF5A35" />
						<path d="M10.0942 13.7018C9.56691 13.2123 9.30469 12.6063 9.30469 11.8853C9.30469 11.1643 9.56831 10.5317 10.0942 10.0407C10.6215 9.55114 11.3002 9.30566 12.1318 9.30566C12.9633 9.30566 13.6154 9.55114 14.1413 10.0407C14.6686 10.5302 14.9308 11.1461 14.9308 11.8853C14.9308 12.6246 14.6672 13.2123 14.1413 13.7018C13.614 14.1914 12.9451 14.4369 12.1318 14.4369C11.3184 14.4369 10.6215 14.1914 10.0942 13.7018ZM14.4877 16.5101V31.5194H9.7464V16.5101H14.4877Z" fill="#171A1C" />
						<path d="M30.272 17.9938C31.3055 19.116 31.8216 20.6562 31.8216 22.6173V31.2553H27.3188V23.226C27.3188 22.2371 27.0621 21.4684 26.5503 20.9213C26.0384 20.3743 25.3485 20.0993 24.4847 20.0993C23.6209 20.0993 22.9309 20.3729 22.419 20.9213C21.9072 21.4684 21.6506 22.2371 21.6506 23.226V31.2553H17.1211V16.4691H21.6506V18.4301C22.1091 17.7764 22.7276 17.2602 23.5045 16.8801C24.2813 16.4999 25.155 16.3105 26.1268 16.3105C27.8573 16.3105 29.2399 16.8716 30.272 17.9938Z" fill="#171A1C" />
					</svg>
				</a>
				<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="share-icon">
					<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="41.4288" height="41.4409" rx="20.7144" fill="#EF5A35" />
						<path d="M9.36219 9.30566L18.5923 21.6497L9.30469 31.6863H11.3956L19.5276 22.8996L26.0975 31.6863H33.2114L23.4625 18.6479L32.1078 9.30566H30.017L22.5286 17.3981L16.4776 9.30566H9.36357H9.36219ZM12.4361 10.8459H15.7035L30.1348 30.1461H26.8673L12.4361 10.8459Z" fill="#171A1C" />
					</svg>
				</a>
				<a href="https://www.instagram.com/" target="_blank" rel="noopener" class="share-icon">
					<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="41.4288" height="41.4409" rx="20.7144" fill="#EF5A35" />
						<path d="M26.7331 9.30566H14.3478C10.9262 9.30566 8.14258 12.0901 8.14258 15.5128V26.8468C8.14258 30.2695 10.9262 33.0539 14.3478 33.0539H26.7331C30.1548 33.0539 32.9384 30.2695 32.9384 26.8468V15.5128C32.9384 12.0901 30.1548 9.30566 26.7331 9.30566ZM10.3316 15.5128C10.3316 13.2978 12.1336 11.4953 14.3478 11.4953H26.7331C28.9474 11.4953 30.7494 13.2978 30.7494 15.5128V26.8468C30.7494 29.0617 28.9474 30.8643 26.7331 30.8643H14.3478C12.1336 30.8643 10.3316 29.0617 10.3316 26.8468V15.5128Z" fill="#171A1C" />
						<path d="M20.5395 26.9516C23.7214 26.9516 26.3115 24.3621 26.3115 21.1779C26.3115 17.9937 23.7228 15.4043 20.5395 15.4043C17.3563 15.4043 14.7676 17.9937 14.7676 21.1779C14.7676 24.3621 17.3563 26.9516 20.5395 26.9516ZM20.5395 17.5953C22.5154 17.5953 24.1225 19.2029 24.1225 21.1793C24.1225 23.1558 22.5154 24.7633 20.5395 24.7633C18.5637 24.7633 16.9566 23.1558 16.9566 21.1793C16.9566 19.2029 18.5637 17.5953 20.5395 17.5953Z" fill="#171A1C" />
						<path d="M26.8442 16.3378C27.701 16.3378 28.3994 15.6407 28.3994 14.7822C28.3994 13.9237 27.7025 13.2266 26.8442 13.2266C25.986 13.2266 25.2891 13.9237 25.2891 14.7822C25.2891 15.6407 25.986 16.3378 26.8442 16.3378Z" fill="#171A1C" />
					</svg>
				</a>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="share-icon">
					<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="41.4288" height="41.4409" rx="20.7144" fill="#EF5A35" />
						<path d="M23.7611 12.2241V16.5852H29.1544L28.3004 22.4598H23.7611V35.9948C22.851 36.121 21.9198 36.187 20.9747 36.187C19.8837 36.187 18.8123 36.1 17.769 35.9317V22.4598H12.7949V16.5852H17.769V11.2492C17.769 7.93874 20.4516 5.25391 23.7625 5.25391V5.25671C23.7723 5.25671 23.7807 5.25391 23.7905 5.25391H29.1558V10.3346H25.65C24.6081 10.3346 23.7625 11.1804 23.7625 12.2227L23.7611 12.2241Z" fill="#171A1C" />
					</svg>
				</a>
				<a href="https://api.whatsapp.com/send?text=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="share-icon">
					<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="41.4288" height="41.4409" rx="20.7144" fill="#EF5A35" />
						<path d="M25.0828 26.6106C19.9601 26.6106 15.7924 22.4403 15.791 17.3161C15.7924 16.0172 16.8498 14.9609 18.1455 14.9609C18.2787 14.9609 18.4105 14.9722 18.5368 14.9946C18.8144 15.0409 19.0781 15.1349 19.3207 15.2766C19.3557 15.2976 19.3796 15.3313 19.3852 15.3706L19.9265 18.7834C19.9335 18.8241 19.9209 18.8633 19.8942 18.8928C19.5955 19.2238 19.2141 19.4623 18.7892 19.5816L18.5844 19.6391L18.6616 19.8368C19.3599 21.6155 20.7819 23.0365 22.5614 23.7379L22.7592 23.8164L22.8166 23.6116C22.9358 23.1866 23.1742 22.805 23.5052 22.5062C23.529 22.4838 23.5613 22.4726 23.5935 22.4726C23.6005 22.4726 23.6076 22.4726 23.616 22.474L27.0278 23.0155C27.0685 23.0225 27.1021 23.0449 27.1232 23.08C27.2634 23.3226 27.3574 23.5877 27.405 23.8655C27.4275 23.9889 27.4373 24.1194 27.4373 24.2555C27.4373 25.553 26.3813 26.6092 25.0828 26.6106Z" fill="#171A1C" />
						<path d="M34.1669 19.631C33.8906 16.5085 32.4602 13.6118 30.1394 11.4755C27.8045 9.32649 24.7755 8.14258 21.6077 8.14258C14.655 8.14258 8.99801 13.8012 8.99801 20.7559C8.99801 23.0901 9.64166 25.3639 10.8603 27.3446L8.14258 33.3623L16.844 32.4351C18.3571 33.0551 19.9585 33.3693 21.6063 33.3693C22.0396 33.3693 22.4841 33.3469 22.9301 33.3006C23.3227 33.2585 23.7196 33.1968 24.1094 33.1183C29.9319 31.9414 34.1823 26.7723 34.2159 20.8233V20.7559C34.2159 20.3772 34.1991 19.9985 34.1655 19.6324L34.1669 19.631ZM17.1791 29.7937L12.365 30.3072L13.8024 27.1216L13.5149 26.7358C13.4938 26.7078 13.4728 26.6797 13.449 26.6474C12.2009 24.9235 11.5418 22.8867 11.5418 20.7574C11.5418 15.2053 16.0573 10.6885 21.6077 10.6885C26.8075 10.6885 31.215 14.7466 31.6399 19.9269C31.6623 20.2047 31.6749 20.4838 31.6749 20.7588C31.6749 20.8373 31.6735 20.9145 31.6721 20.9972C31.5655 25.6417 28.322 29.5862 23.7841 30.5905C23.4377 30.6677 23.0829 30.7266 22.7295 30.7645C22.3621 30.8065 21.9849 30.8276 21.6105 30.8276C20.2769 30.8276 18.9811 30.5695 17.7569 30.0589C17.6209 30.0042 17.4876 29.9453 17.3628 29.8849L17.1805 29.7966L17.1791 29.7937Z" fill="#171A1C" />
					</svg>
				</a>
			</div>
		</div>
	</div>
</div>


