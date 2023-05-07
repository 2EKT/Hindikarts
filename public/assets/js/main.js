
$(document).ready(function(){
			// banner slider
			$('.banner-slider').slick({
				autoplay: true,
				autoplaySpeed: 3000,
				dots: true,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
			});

			// client slider
			$('.client-slider').slick({
				autoplay: true,
				autoplaySpeed: 3000,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
				dots: true,
				arrows: false,
			});

			// accordion

			$('.card').click(function(){
				$(this).find('.btn-block').toggleClass('active');
				$(this).find('i').toggleClass('active').toggleClass('fa-plus').toggleClass('fa-minus');
				$(this).siblings().find('.btn-block').removeClass('active');
				$(this).siblings().find('i').removeClass('active').removeClass('fa-minus').addClass('fa-plus');
			});

        	  // count up

        	  $('.counter').counterUp({
        	  	delay: 10,
        	  	time: 2000
        	  });

	        // window scroll

	        $(window).scroll(function(){
	        	if($(window).scrollTop() > 50){
	        		$('.top-arrow').show();
	        	}else{
	        		$('.top-arrow').hide();
	        	}
	        });

	    });