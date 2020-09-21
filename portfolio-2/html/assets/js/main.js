(function ($) {
 "use strict";

  // STICKY ACTIVE
  var activeSticky = $('#active-sticky'),
      winD = $(window);
    winD.on('scroll',function() {
      var scroll = $(window).scrollTop(),
  		    isSticky = activeSticky;
      if (scroll < 1) {
       		isSticky.removeClass("is-sticky");
      }
      else{
       	isSticky.addClass("is-sticky");
      }
   });

   // MENU A ACTIVE JQUERY
  var pageUrl = window.location.href.substr(window.location.href.lastIndexOf("/")+1),
      aActive = $('nav ul li a');
  if (aActive.length) {
    aActive.each(function(){
      if($(this).attr("href") === pageUrl || $(this).attr("href") === '' )
      $(this).addClass("active");
    });
  }

  // Scroll UP
  $.scrollUp({
      scrollText: '<i class="ti-angle-up"></i>', // Text for element, can contain HTML
      scrollSpeed: 800
  });


  // AOS ACTIVATION
  AOS.init({
    disable: function ($) {
			var maxWidth = 1024;
			return window.innerWidth < maxWidth;
		},
    offset: 120, // offset (in px) from the original trigger point
    delay: 200, // values from 0 to 3000, with step 50ms
    duration: 800, // values from 0 to 3000, with step 50ms
    once: true, // whether animation should happen only once - while scrolling down
  });

  // VenoBox
  $('.venobox').venobox();


})(jQuery);
