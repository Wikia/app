var admixMode = location.search.split('admix=')[1];

if(admixMode === '1') {
	$(function () {
		var recirc = $('.prototype1-recirc');
		var recircOffsetTop = recirc.offset().top;
		var ad2 = $('.prototype1-ad2');
		var ad2OffsetTop = ad2.offset().top;
		var ad3 = $('.prototype1-ad3');

		function resetInlineStyles() {
			recirc.css({
				position: '',
				bottom: ''
			});
			ad3.css({
				opacity: '',
				position: '',
				bottom: ''
			});
			ad2.css('display', '');
		}

		function apply1() {
			resetInlineStyles();
			recirc.removeClass('fixed');
			ad2.removeClass('fixed');
			ad2.removeClass('hidden');
			ad3.removeClass('fixed');
		}

		function apply2() {
			resetInlineStyles();
			recirc.addClass('fixed');
			ad2.removeClass('fixed');
			ad2.removeClass('hidden');
			ad3.removeClass('fixed');
		}

		function apply3() {
			resetInlineStyles();
			recirc.addClass('fixed');
			ad2.addClass('fixed');
			ad2.removeClass('hidden');
			ad3.removeClass('fixed');
		}

		function apply4(offset) {
			resetInlineStyles();
			recirc.addClass('fixed');
			console.log(offset);
			console.log(offset / 3000);
			if(Math.floor(offset / 3000) % 2 === 0) {
				ad3.addClass('fixed');
				ad2.addClass('hidden');
			} else {
				ad2.removeClass('hidden');
				ad3.removeClass('fixed');
			}
		}

		function apply5() {
			recirc.css({
				position: 'absolute',
				bottom: (20 + 250 + 20 + $('#WikiaFooter').outerHeight() + 30) +'px'
			});
			recirc.removeClass('fixed');
			ad3.css({
				opacity: '1',
				position: 'absolute',
				bottom: (20 + $('#WikiaFooter').outerHeight() + 30) + 'px'
			});
			ad3.removeClass('fixed');
			ad2.css('display', 'none');
		}

		$(window).scroll(function () {
			var point1 = recircOffsetTop - 60;
			var point2 = ad2OffsetTop - 20 - recirc.height() - 60;
			var point3 = ad2OffsetTop - 20 - recirc.height() - 60 + 3000;
			var point4 = $('.WikiaPageContentWrapper').offset().top + $('.WikiaPageContentWrapper').height() - (250 + 359 + 60 + 20 + 20) - ($('#WikiaFooter').outerHeight() + 30);

			var scrollTop = $(this).scrollTop();

			if (scrollTop > point1 && scrollTop < point2) {
				apply2();
			} else if (scrollTop < point1) {
				apply1();
			} else if (scrollTop > point2 && scrollTop < point3) {
				apply3();
			} else if (scrollTop > point3 && scrollTop < point4) {
				apply4(scrollTop - point3);
			} else if (scrollTop > point4) {
				apply5();
			}
		});
	});
}
