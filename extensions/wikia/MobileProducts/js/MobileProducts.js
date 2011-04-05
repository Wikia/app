$(function() {
	MobileProducts.init();
});

var MobileProducts = {
	init: function(){
		WikiHeader.navtop = 35;
		$('#WikiHeader').detach().appendTo('#WikiaPageHeader');
		$('#mobileProductsSlideshow').slideshow();
		$('#mobileProductSlideshow').slideshow();
	}
};