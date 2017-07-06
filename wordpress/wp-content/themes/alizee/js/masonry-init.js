
//Masonry init
jQuery(function($) {
	var $container = $('.home-layout');
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: '.hentry',
	        isAnimated: true,
			isFitWidth: true,
			animationOptions: {
				duration: 500,
				easing: 'linear',
			}
	    });
	});
});
