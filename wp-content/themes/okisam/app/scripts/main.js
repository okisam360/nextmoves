(function($) {

	let player;
	let endCheckInterval;

	// Load YouTube API
	const tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	const firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	$(document).ready(function() {
		var widthBody = $(window).width();
		if (widthBody < 1200) { 
			//  Menu mobile
			$('#open-menu-box').on('click', function () {
			  $(this).toggleClass('change');
			  $('#menu-nav').fadeToggle(300).addClass('menu-open');
			  $('.sub-menu').hide();
			}); 

			//  Submenu mobile
			$('.menu-item-has-children').on('click', function () {
			  $(this).find('.sub-menu').fadeToggle(300);
			  $(this).toggleClass('menu-item-has-children-open');
			}); 
		}
	}); 

	$(document).ready(function() {
		// go to up footer
		$(document).ready(function(callback) {
		  $(".go-to-up").on('click', function() {
		  	$('html, body').animate({ scrollTop: 0 }, callback);
		  });
		});
	}); 

	$(document).ready(function() {
	  $('#slider-casos-exito').lightSlider({
	      loop:false,
	      item:2,
	      slideMove:2,
	      easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
	      speed:800,
	      slideEndAnimation: false,
	      responsive : [
	          {
	              breakpoint:768,
	              settings: {
	                  item:1,
	                  slideMove:1
	                }
	          }
	      ]
	  });  
	});

	$(document).ready(function() {
	  $('#slider-opiniones').lightSlider({
	      loop:false,
	      // autoWidth:true,
	      item:1,
	      slideMove:1,
	      easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
	      speed:800,
	      slideEndAnimation: false,
	      responsive : [
	          {
	              breakpoint:768,
	              settings: {
	                  item:1,
	                  slideMove:1
	                }
	          }
	      ]
	  });  
	});

	$('form .search-icon').on("click", function () {
	    $('form .search-submit').trigger('click');
	});

	$('.open-modal-presupuesto').on('click', function (event) {
	  event.preventDefault();
	  var valorAtributo = $(this).data('modal');
	  $('#'+valorAtributo).fadeIn();
	}); 

	$('.modal-presupuesto').click(function() {
	  $(this).fadeOut();
	});

	$('.modal-presupuesto-close').click(function() {
	  $('.modal-presupuesto').fadeOut();
	});

	$('.modal-presupuesto-content').click(function(event){ 
	  event.stopPropagation();
	});


	$('a.link-scroll').on('click', function(e){
	    e.preventDefault();
	    var href = $(this).attr('href');
	    $('html, body').animate({ 
	        scrollTop:$(href).offset().top - 80
	    },'slow');
	});

	// Lazy load history panels
	$(document).ready(function() {
		var $historyContainer = $('#history-panels-container');
		var $loader = $('#history-loader');
		var loading = false;

		if ($historyContainer.length && $loader.length) {
			var observer = new IntersectionObserver(function(entries) {
				if (entries[0].isIntersecting && !loading) {
					var hasMore = $historyContainer.attr('data-has-more') === 'true';
					var page = parseInt($historyContainer.attr('data-page'));

					if (hasMore) {
						loading = true;
						$loader.addClass('is-loading');

						$.ajax({
							url: '/wp-json/okisam/v1/history-panels',
							data: { page: page + 1 },
							method: 'GET',
							success: function(response) {
								if (response.html) {
									$historyContainer.append(response.html);
									$historyContainer.attr('data-page', page + 1);
									$historyContainer.attr('data-has-more', response.has_more ? 'true' : 'false');
									
									if (!response.has_more) {
										$loader.remove();
										observer.unobserve($loader[0]);
									}
								}
							},
							error: function() {
								loading = false;
								$loader.removeClass('is-loading');
							},
							complete: function() {
								loading = false;
								$loader.removeClass('is-loading');
							}
						});
					}
				}
			}, {
				rootMargin: '250px'
			});

			observer.observe($loader[0]);
		}
	});

	// Unified Countdown logic (Header & Locked Quincenas)
	$(document).ready(function() {
		$('.js-countdown').each(function() {
			var $countdown = $(this);
			var remainingSeconds = parseInt($countdown.data('remaining'));
			
			if (isNaN(remainingSeconds) || remainingSeconds < 0) return;

			var $days = $countdown.find('[data-days]');
			var $hours = $countdown.find('[data-hours]');
			var $mins = $countdown.find('[data-mins]');
			var $secs = $countdown.find('[data-secs]');

			var x = setInterval(function() {
				if (remainingSeconds <= 0) {
					clearInterval(x);
					$days.text('00');
					$hours.text('00');
					$mins.text('00');
					$secs.text('00');
					location.reload(); 
					return;
				}

				var days = Math.floor(remainingSeconds / (60 * 60 * 24));
				var hours = Math.floor((remainingSeconds % (60 * 60 * 24)) / (60 * 60));
				var minutes = Math.floor((remainingSeconds % (60 * 60)) / 60);
				var seconds = Math.floor(remainingSeconds % 60);

				$days.text(days < 10 ? '0' + days : days);
				$hours.text(hours < 10 ? '0' + hours : hours);
				$mins.text(minutes < 10 ? '0' + minutes : minutes);
				$secs.text(seconds < 10 ? '0' + seconds : seconds);
				
				remainingSeconds--;
			}, 1000);
		});
	});

	// Subscription form logic (Simulated)
	$(document).ready(function() {
		$('.q-lock-form').on('submit', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $btn = $form.find('button');
			var originalText = $btn.text();

			$btn.text('Enviando...').prop('disabled', true);

			// Simulated feedback
			setTimeout(function() {
				$form.fadeOut(300, function() {
					$(this).html('<div class="h3-regular text-brand bg-white p-20 border-radius-20" style="border-radius: 20px; color: #EF5A35;">¡Gracias por suscribirte! Te avisaremos pronto.</div>').fadeIn();
				});
			}, 1500);
		});
	});

	// Video Modal Logic
	function getYouTubeId(url) {
		const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
		const match = url.match(regExp);
		return (match && match[2].length === 11) ? match[2] : null;
	}

	function closeVideoModal() {
		clearInterval(endCheckInterval);
		const $modal = $('#video-modal');
		$modal.fadeOut(300, function() {
			if (player && player.destroy) {
				player.destroy();
			}
			$modal.find('.video-responsive-container').html('<div id="player-container"></div>');
		});
		$('body').removeClass('modal-open');
	}

	$('.js-video-modal-trigger').on('click', function(e) {
		e.preventDefault();
		const videoUrl = $(this).data('video-url');
		const videoId = getYouTubeId(videoUrl);

		if (!videoId) return;

		const $modal = $('#video-modal');
		
		if (typeof YT !== 'undefined' && YT.Player) {
			player = new YT.Player('player-container', {
				videoId: videoId,
				playerVars: {
					'autoplay': 1,
					'controls': 0,
					'modestbranding': 1,
					'rel': 0,
					'playsinline': 1,
					'enablejsapi': 1,
					'origin': window.location.origin
				},
				events: {
					'onStateChange': function(event) {
						if (event.data === YT.PlayerState.PLAYING) {
							endCheckInterval = setInterval(function() {
								const duration = player.getDuration();
								const currentTime = player.getCurrentTime();
								if (duration > 0 && (duration - currentTime) <= 1) {
									closeVideoModal();
								}
							}, 200);
						} else if (event.data === YT.PlayerState.ENDED) {
							closeVideoModal();
						} else {
							clearInterval(endCheckInterval);
						}
					}
				}
			});
		} else {
			// Fallback if API not loaded
			const $container = $('#player-container');
			const embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&controls=0&modestbranding=1&rel=0&playsinline=1&enablejsapi=1`;
			$container.replaceWith(`<iframe src="${embedUrl}" allow="autoplay; encrypted-media" allowfullscreen></iframe>`);
		}
		
		$modal.fadeIn(300);
		$('body').addClass('modal-open');
	});

	$('.modal-video-close, .modal-video-overlay').on('click', function() {
		closeVideoModal();
	});

	// Article Modal Logic
	$('.open-article-modal').on('click', function(e) {
		e.preventDefault();
		var modalId = $(this).data('modal');
		var $modal = $('#' + modalId);
		
		// Append to body to avoid clipping issues with transformed parent containers
		$modal.appendTo('body');
		
		// Show modal immediately (no animation delay for blur)
		$modal.css({
			display: 'flex',
			opacity: 0
		});
		
		// Apply blur immediately, then fade in
		$('body').addClass('modal-open'); // Prevent scroll
		
		// Use requestAnimationFrame for smoother animation
		requestAnimationFrame(function() {
			$modal.css({
				transition: 'opacity 0.3s ease',
				opacity: 1
			});
		});
	});

	$('.modal-article-close, .modal-article-overlay').on('click', function() {
		var $modal = $(this).closest('.modal-article');
		$modal.css({
			transition: 'opacity 0.3s ease',
			opacity: 0
		});
		setTimeout(function() {
			$modal.css('display', 'none');
		}, 300);
		$('body').removeClass('modal-open');
	});

	// Close on ESC
	$(document).on('keydown', function(e) {
		if (e.key === "Escape") {
			$('.modal-article:visible').fadeOut(300);
			const $videoModal = $('#video-modal:visible');
			if ($videoModal.length) {
				closeVideoModal();
			}
			$('body').removeClass('modal-open');
		}
	});

	// Check for post in URL on load and open the corresponding modal
	var urlParams = new URLSearchParams(window.location.search);
	var cardId = urlParams.get('post');
	if (cardId) {
		// Use a slight timeout to ensure everything is rendered
		setTimeout(function() {
			var $targetBtn = $('.open-article-modal[data-post="' + cardId + '"]');
			if ($targetBtn.length) {
				$targetBtn.trigger('click');
			}
		}, 500);
	}

})(jQuery);
