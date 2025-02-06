	var SITEURL = $("#SITEURL").val();

	 // Header Profile Dropdown
	 $(".profile-dropdown").hide();
	 $(".profile a").click(function(){
	   $(".profile-dropdown").slideToggle();
	 });

	 $(".language-dropdown").hide();
	 $(".language-header").click(function(){
	   $(".language-dropdown").slideToggle();
	 });


	 
   
	
	// Search Modal js 

	$(document).ready(function() {
		$('#close-btn').click(function() {
			$('#search-overlay').fadeOut();
			$('#search-btn').show();
		});
		$('#search-btn').click(function() {
			$(this).hide();
			$('#search-overlay').fadeIn();
		});
	});

	// Product Page Size Filter js
				
	$('.size-caliber-control li a').mouseenter(function(){
		var pos = $(this).position();
		$(this).find('.tooltipli').css('top', (pos.top)+40 + 'px').fadeIn();
		}).mouseleave(function(){
		$(this).find('.tooltipli').fadeOut();
	});


   // Caliber slider

	$('.caliber-slider').slick({
		dots: false,
		arrows: false,
		infinite: true,
		speed: 300,
		autoplay: false,
		   autoplaySpeed: 2000,
		slidesToShow: 10,
		slidesToScroll: 6,
		responsive: [
			{
			  breakpoint: 1025,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 576,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			},
		]
	});

   
	// Caliber slider

	$('.Bought_Together').slick({
		dots: false,
		arrows: false,
		infinite: true,
		speed: 300,
		autoplay: false,
		   autoplaySpeed: 2000,
		slidesToShow: 10,
		slidesToScroll: 6,
		responsive: [
			{
			  breakpoint: 1025,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 576,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			},
		]
	});



	// sticky header js

		var stickyEl = document.querySelector('.me_sticky')
		var stickyPosition = stickyEl.getBoundingClientRect().top;
		var offset = -20
		window.addEventListener('scroll', function() {
			if (window.pageYOffset >= stickyPosition + offset) {
				stickyEl.style.position = 'fixed';
				stickyEl.style.top = '0px';
				stickyEl.style.background = '#0F75BC';
			} else {
				stickyEl.style.position = 'static';
				stickyEl.style.top = '';
				stickyEl.style.background = '';
			}
		});
				


			// Aos effect
			AOS.init();

			// Hero Banner Js
			$(document).ready(function() {
			  //parallax scroll
			  $(window).on("load scroll", function() {
			    var parallaxElement = $(".parallax_scroll"),
			      parallaxQuantity = parallaxElement.length;
			    window.requestAnimationFrame(function() {
			      for (var i = 0; i < parallaxQuantity; i++) {
			        var currentElement = parallaxElement.eq(i),
			          windowTop = $(window).scrollTop(),
			          elementTop = currentElement.offset().top,
			          elementHeight = currentElement.height(),
			          viewPortHeight = window.innerHeight * 0.5 - elementHeight * 0.5,
			          scrolled = windowTop - elementTop + viewPortHeight;
			        currentElement.css({
			          transform: "translate3d(0," + scrolled * -0.25 + "px, 0)"
			        });
			      }
			    });
			  });
			});


			// product JQuery
			$('.product-slider').slick({
				dots: true,
				arrows: false,
				infinite: true,
				speed: 300,
				autoplay: true,
               	autoplaySpeed: 2000,
				slidesToShow: 3,
				slidesToScroll: 1,
				responsive: [
			        {
				      breakpoint: 1025,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 768,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 576,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    },
		        ]
			});

			// category slider js

			$('.category-slider').slick({
				dots: false,
				arrows: true,
				infinite: true,
				autoplay: true,
                autoplaySpeed: 1000,
				slidesToShow: 5,
				slidesToScroll: 1,
				responsive: [
			        {
				      breakpoint: 1025,
				      settings: {
				        slidesToShow: 3,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 768,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 576,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    },
		        ]
			});


			// Compatible Accessories slider js

			$('.compatible-slider').slick({
				dots: false,
				arrows: true,
				infinite: true,
				autoplay: true,
                autoplaySpeed: 3000,
				slidesToShow: 3,
				slidesToScroll: 1,
				responsive: [
			        {
				      breakpoint: 1140,
				      settings: {
				        slidesToShow: 3,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 800,
				      settings: {
				        slidesToShow: 3,
				        slidesToScroll: 1
				      }
				    },
			        {
				      breakpoint: 610,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },
					{
						breakpoint: 425,
						settings: {
						  slidesToShow: 1,
						  slidesToScroll: 1
						}
					  },
		        ]
			});


			// News Slider

			$('.news-slider').slick({
				dots: true,
				arrows: false,
				infinite: false,
				autoplay: true,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 4,
				responsive: [
					{
					breakpoint: 1024,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						infinite: true,
					}
					},
					{
					breakpoint: 600,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
					},
					{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
					}
    
				]
				});

			// TESTIMONIALS Slider

				$('.testi-slider').slick({
					dots: true,
					arrows: false,
					infinite: true,
					centerMode: true,
					speed: 300,
					autoplay: true,
               		 autoplaySpeed: 2000,
					slidesToShow: 3,
					slidesToScroll: 1,
					responsive: [
						{
						breakpoint: 1025,
						settings: {
							centerMode: false,
							slidesToShow: 2,
							slidesToScroll: 2
						}
						},
						{
						breakpoint: 768,
						settings: {
							centerMode: false,
							slidesToShow: 2,
							slidesToScroll: 2
						}
						},
						{
						breakpoint: 576,
						settings: {
							centerMode: false,
							slidesToShow: 1,
							slidesToScroll: 1
						}
						},
						]
				});


				
				// mobile menu css

				$(document).ready(function(){ 
					var touch 	= $('#resp-menu');
					var menu 	= $('.menu');
				
					$(touch).on('click', function(e) {
						e.preventDefault();
						menu.slideToggle();
					});
					
					$(window).resize(function(){
						var w = $(window).width();
						if(w > 767 && menu.is(':hidden')) {
							menu.removeAttr('style');
						}
					});
					
					
				});



  
				// thumb slick slider

				$(function(){
					$('.slider-thumb').slick({
						autoplay: true,
						vertical: true,
						infinite: false,
						verticalSwiping: true,
						slidesPerRow: 4,
						slidesToShow: 4,
						asNavFor: '.slider-preview',
						focusOnSelect: true,
						prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-up"></i></button>',
						nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-down"></i></button>',
						responsive: [
							{
								breakpoint: 767,
								settings: {
									vertical: false,
								}
							},
							{
								breakpoint: 479,
								settings: {
									vertical: false,
									slidesPerRow: 3,
									slidesToShow: 3,
								}
							},
						]
					});
					$('.slider-preview').slick({
						autoplay: false,
						vertical: true,
						infinite: true,
						slidesPerRow: 1,
						slidesToShow: 1,
						asNavFor: '.slider-thumb',
						arrows: false,
						draggable: false,
						responsive: [
							{
								breakpoint: 767,
								settings: {
									vertical: false,
									fade: true,
								}
							},
						]
					});
				});


				// product JQuery
			$('.alternate-images-slider').slick({
				dots: true,
				arrows: false,
				infinite: true,
				speed: 300,
				autoplay: true,
               	autoplaySpeed: 2000,
				slidesToShow: 1,
				slidesToScroll: 1,
			});


				// Add to cart

			$(document).ready(function() {
				// $('.minus').click(function () {
				// 	var $input = $(this).parent().find('input');
				// 	var count = parseInt($input.val()) - 1;
				// 	count = count < 1 ? 1 : count;
				// 	$input.val(count);
				// 	$input.change();
				// 	return false;
				// });
				// $('.plus').click(function () {
				// 	var $input = $(this).parent().find('input');
				// 	$input.val(parseInt($input.val()) + 1);
				// 	$input.change();
				// 	return false;
				// });


			});

				// checkout page accordion





// function qty_update(qty,id)
// {
// 	$.ajax({
// 		type: "POST",
// 		url: SITEURL+"cart_db.php",
// 		data: {
// 			mode:"update_qty",
// 			qty:qty,
// 			id:id,
// 		},
// 		beforeSend: function(){
//             $(".loader").fadeIn(); 
//         },
// 		success: function(data)
// 		{
// 			$(".loader").fadeOut(); 
// 			cart_details();	
// 			header_cart();
// 			cart_totals();
// 		},
// 	});	
// }

// function remove_cart(id)
// {
// 	$.ajax({
// 		type: "POST",
// 		url: SITEURL+"cart_db.php",
// 		data: {
// 			mode:"remove_cart",
// 			id:id,
// 		},
// 		beforeSend: function(){
//             $(".loader").fadeIn(); 
//         },
// 		success: function(data)
// 		{
// 			$(".loader").fadeOut(); 
// 			cart_details();	
// 			header_cart();
// 			cart_totals();
// 		},
// 	});	
// }

function cart_details()
{
	$(".loader").fadeIn();
    $.ajax({
        type: 'POST',
        url: SITEURL+'ajax_get_cart_details.php',
        data: {},
        success: function(data)
        {
            $("#results").html(data);
            $(".loader").fadeOut();
        }
    });
}  
cart_details();

function cart_totals()
{
	$(".loader").fadeIn();
    $.ajax({
        type: 'POST',
        url: SITEURL+'ajax_cart_totals.php',
        data: {},
        success: function(data)
        {
        	$(".loader").fadeOut();
            $("#tbody_totals").html(data);
        }
    });
}  
cart_totals(); 


// loder for page reload
document.onreadystatechange = function () {
	var state = document.readyState
	if (state == 'interactive') {
	  $(".preloader").show();
	} else if (state == 'complete') {
		setTimeout(function(){
		   document.getElementById('interactive');
		   $(".preloader").hide();
		},1000);
	}
  }

  $(".google-trales").click(function(){
	// $("#filters_select_store").show();
	$('#filters_select_store').css('display', 'block');
  });
  