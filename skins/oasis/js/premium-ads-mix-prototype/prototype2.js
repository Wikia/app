var admixMode = location.search.split('admix=')[1];

if(admixMode === '2') {
	$(function () {
		var recirc = $('.prototype2-recirc');
		var recircOffsetTop = recirc.offset().top;
		var ad1 = $('.prototype2-ad1');
		var ad1OffsetTop = ad1.offset().top;

		function resetInlineStyles() {
			recirc.css({
				position: '',
				bottom: ''
			});
		}

		function apply1() {
			resetInlineStyles();
			ad1.removeClass('fixed');
			ad1.removeClass('moved');
			recirc.removeClass('fixed');
		}

		function apply2() {
			resetInlineStyles();
			ad1.addClass('fixed');
			ad1.removeClass('moved');
			recirc.removeClass('fixed');
		}

		function apply3() {
			resetInlineStyles();
			ad1.addClass('moved');
			ad1.removeClass('fixed');
			recirc.removeClass('fixed');
		}

		function apply4() {
			resetInlineStyles();
			recirc.addClass('fixed');
		}

		function apply5() {
			recirc.css({
				position: 'absolute',
				bottom: (20 + $('#WikiaFooter').height()) + 'px'
			});
			recirc.removeClass('fixed');
		}

		$(window).scroll(function () {
			var point1 = ad1OffsetTop - 60;
			var point2 = ad1OffsetTop + 250 - 60;
			var point3 = recircOffsetTop - 60;
			var point4 = $('.WikiaPageContentWrapper').height() - 383 - $('#WikiaFooter').height();

			var scrollTop = $(this).scrollTop();

			if (scrollTop > point1 && scrollTop < point2) {
				apply2();
			} else if (scrollTop < point1) {
				apply1();
			} else if (scrollTop > point2 && scrollTop < point3) {
				apply3();
			} else if (scrollTop > point3 && scrollTop < point4) {
				apply4();
			} else if (scrollTop > point4) {
				apply5();
			}
		});
	});
}
