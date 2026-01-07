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







})(jQuery);