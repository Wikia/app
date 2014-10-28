$(function(){
	window.stickyElement(document.getElementsByClassName('left-nav')[0], document.getElementById('mw-content-text'), 100);

	//var $el = $('.left-nav'),
	//	offset = 0,
	//	topSticked = 0,
	//	topFixed = 100,
	//	switchPoint = 0;
	//
	//function init() {
	//	topSticked = document.getElementById('mw-content-text').offsetTop;
	//	switchPoint = topSticked - topFixed;
	//	stick();
	//}
	//
	//function stick() {
	//	$el.css({
	//		position: 'absolute',
	//		top: topSticked + 'px'
	//	});
	//}
	//
	//function unstick() {
	//	$el.css({
	//		position: 'fixed',
	//		top: topFixed + 'px'
	//	});
	//}
	//
	//function recalc() {
	//	if (offset <= switchPoint) {
	//		stick();
	//	} else {
	//		unstick();
	//	}
	//}
	//
	//init();
	//
	//$(window).on('scroll wheel', $.debounce(1, function(e){
	//	if (window.pageYOffset != offset) {
	//		offset = window.pageYOffset;
	//		recalc();
	//	}
	//})).on('orientationchange resize', function(e) {
	//	init();
	//});
});
