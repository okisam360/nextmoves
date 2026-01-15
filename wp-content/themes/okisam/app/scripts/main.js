(function($) {

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

})(jQuery);
