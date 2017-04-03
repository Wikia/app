var admixMode = location.search.split('admix=')[1];

if(admixMode === '3') {
	$(function () {
		var ad2 = $('.prototype3-ad2');
		var recirc = $('.prototype3-recirc');
		var recircOffsetTop = recirc.offset().top;
		var adSrc = '/skins/oasis/images/premium-ads-mix-prototype/ad2.png';
		var adSrc2 = '/skins/oasis/images/premium-ads-mix-prototype/ad3.png';

		function resetInlineStyles() {
			recirc.css({
				position: '',
				bottom: ''
			});
		}

		function apply1() {
			resetInlineStyles();
			recirc.removeClass('fixed');
			recirc.removeClass('hidden');
			ad2.removeClass('fixed');
		}

		function apply2() {
			resetInlineStyles();
			recirc.addClass('fixed');
			recirc.removeClass('hidden');
			ad2.removeClass('fixed');
		}

		function apply3() {
			resetInlineStyles();
			recirc.addClass('hidden');
			recirc.removeClass('fixed');
			ad2.addClass('fixed');
		}

		function apply4(offset) {
			resetInlineStyles();
			if(Math.floor(offset/3000) % 2 === 0) {
				if(!recirc.hasClass('fixed')) {
					if(ad2.attr('src') === adSrc) {
						ad2.attr('src', adSrc2);
					} else {
						ad2.attr('src', adSrc);
					}
				}
				recirc.removeClass('hidden');
				recirc.addClass('fixed');
				ad2.removeClass('fixed');
			} else {
				recirc.addClass('hidden');
				recirc.removeClass('fixed');
				ad2.addClass('fixed');
			}
		}

		function apply5() {
			recirc.css({
				position: 'absolute',
				bottom: (20 + $('#WikiaFooter').height() + 320) + 'px'
			});
			recirc.removeClass('hidden');
			recirc.removeClass('fixed');
			ad2.removeClass('fixed');
		}

		$(window).scroll(function () {
			var point1 = recircOffsetTop - 60;
			var point2 = recircOffsetTop + 3000 - 60;
			var point3 = recircOffsetTop + 6000 - 60;
			var point4 = $('.WikiaPageContentWrapper').height() - (383+250) - $('#WikiaFooter').height();

			var scrollTop = $(this).scrollTop();

			if(scrollTop > point1 && scrollTop < point2) {
				apply2();
			} else if(scrollTop < point1) {
				apply1();
			} else if(scrollTop > point2 && scrollTop < point3) {
				apply3();
			} else if(scrollTop > point3 && scrollTop < point4) {
				apply4(scrollTop - point3);
			} else if(scrollTop > point4) {
				apply5();
			}
		});
	});
}
