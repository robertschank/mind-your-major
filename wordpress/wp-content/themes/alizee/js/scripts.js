
//Page loader
jQuery(document).ready(function($) {
	$("#page").show();
});

//Menu dropdown animation
jQuery(function($) {
	$('.sub-menu').hide();
	$('.main-navigation .children').hide();
	$('.menu-item').hover( 
		function() {
			$(this).children('.sub-menu').slideDown();
		}, 
		function() {
			$(this).children('.sub-menu').hide();
		}
	);
	$('.main-navigation li').hover( 
		function() {
			$(this).children('.main-navigation .children').slideDown();
		}, 
		function() {
			$(this).children('.main-navigation .children').hide();
		}
	);	
});

//Toggle sidebar
jQuery(function($) {
	$('.sidebar-toggle').click(function()
	{
		$('.widget-area').toggle('fast').toggleClass('slide-sidebar');
		$('.content-area').toggleClass('slide-content');
		$('.site-content').toggleClass('clearfix');
		$('.sidebar-toggle').find('i').toggleClass('fa-plus fa-times');
	});
});

//Social toggle
jQuery(function($) {
	$('.social-toggle').toggle(function() {
	  $('.social-navigation').animate({'left':'60px'});
	  $('.social-toggle').find('i').toggleClass('fa-facebook fa-times');
	}, function() {
	 $('.social-navigation').animate({'left':'-600px'});
	 $('.social-toggle').find('i').toggleClass('fa-facebook fa-times');
	});
});

//Fit Vids
jQuery(function($) {
  
  $(document).ready(function(){
    $("body").fitVids();
  });
  
});

//Scroll to top
jQuery(function($) {
	
	$('.scrollup').click(function(){
		$('body').animate({scrollTop : 0},600);
		return false;
	});
	
});