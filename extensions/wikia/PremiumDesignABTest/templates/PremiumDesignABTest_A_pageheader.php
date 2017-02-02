<div id="premium-design-ab-test-A-pageheader">
	<?= $app->renderView( 'PremiumDesignABTest', 'video') ?>
</div>


<div class="video-scroll">
	<div class="video-thumbnail">
		<div class="scroll-to-top"></div>
		<div class="minimize"></div>
		<div class="close"></div>
	</div>
	<div class="video-details">
		<div class="video-details-left">
			<div class="video-watch">WATCH</div>
			<div class="video-title">Top 5 Best Spells in the Wizarding World</div>
			<div class="video-time">2:36</div>
		</div>
		<img src="<?= $videoPlayButtonSrc ?>" class="video-play-button"></img>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		var youtubeURL = 'https://www.youtube.com/embed/xFulu1I3yEw?showinfo=0&autoplay=1';

		var scrollPosition = getUrlVars().scroll;

		var videoScroll = $('.video-scroll').appendTo('body');

		var videoCollapsed = false;
		var videoPlays = false;

		var viewportWidth = $(window).width();
		var viewportHeight = $(window).height();

		var videoElement = $('#premium-design-ab-test-A-pageheader .video');
		var videoOffset = videoElement.offset();
		var videoWidth = videoElement.outerWidth();
		var videoHeight = videoElement.outerHeight();
		var leftInitialPosition = videoOffset.left;
		var rightInitialPosition = viewportWidth - leftInitialPosition - videoWidth;

		var scrollOffset = 100;
		var collapseOffset = videoOffset.top + videoHeight - scrollOffset;

		var ytIframe = $('<div class="yt-container"><iframe src="'+ youtubeURL +'" frameborder="0" allowfullscreen></iframe></div>');


		var ytTopRightInit = {
			'position': 'absolute',
			'width': videoWidth + 'px',
			'height': videoHeight + 'px',
			'top': '0',
			'right': '0'
		};

		var ytBottomRightInit = {
			'position': 'absolute',
			'width': videoWidth + 'px',
			'height': videoHeight + 'px',
			'bottom': '0',
			'right': '0'
		};

		var ytBottomLeftInit = {
			'position': 'absolute',
			'width': videoWidth + 'px',
			'height': videoHeight + 'px',
			'bottom': '0',
			'left': '0'
		};

		var topRightInit = {
			'top': (-videoHeight-100) + 'px',
			'right': rightInitialPosition + 'px',
			'width': videoWidth + 'px'
		};

		var bottomRightInit = {
			'bottom': (viewportHeight) + 'px',
			'right': rightInitialPosition + 'px',
			'width': videoWidth + 'px'
		};

		var bottomLeftInit = {
			'bottom': (viewportHeight) + 'px',
			'left': leftInitialPosition + 'px',
			'width': videoWidth + 'px'
		};

		var className = 'top-right';
		var init = topRightInit;
		var ytInit = ytTopRightInit;
		switch (scrollPosition) {
			case 'TOP_RIGHT':
				className = 'top-right';
				init = topRightInit;
				ytInit = ytTopRightInit;
				break;
			case 'BOTTOM_RIGHT':
				className = 'bottom-right';
				init = bottomRightInit;
				ytInit = ytBottomRightInit;
				break;
			case 'BOTTOM_LEFT':
				className = 'bottom-left';
				init = bottomLeftInit;
				ytInit = ytBottomLeftInit;
				break;
		}

		videoScroll.css(init);
		videoScroll.css('display', 'block');
		videoScroll.find('.video-thumbnail').css({'height': '480px'});
		if (scrollPosition !== 'TOP_RIGHT') {
			videoScroll.find('.video-details').css({'opacity': '1'});
		}



		videoElement.one('click', function (){
			videoElement.append(ytIframe);
			ytIframe.css(ytInit);
			videoPlays = true;
		});

		videoScroll.one('click', function (){
			if(scrollPosition !== 'BOTTOM_RIGHT') {
				$(this).hide();
			} else {
				$(this).find('.video-thumbnail').hide();
			}
			videoElement.append(ytIframe);
			ytIframe.css(getYTContainerStyles());
			ytIframe.addClass('ytcollapse-'+className);
			videoPlays = true;
		});

		$(window).scroll(function () {
			if($(window).scrollTop() > collapseOffset && !videoCollapsed) {
				videoCollapsed = true;

				if(videoPlays) {
					ytIframe.css(getYTContainerStyles());
					window.requestAnimationFrame(function () {
						ytIframe.addClass('ytcollapse-'+className+' animate');
					});
					videoScroll.show();

					if(scrollPosition === 'BOTTOM_RIGHT') {
						videoScroll.show();
						videoScroll.find('.video-thumbnail').hide();
					}
				} else {
					videoScroll.addClass(className);
				}
			} else if($(window).scrollTop() <= collapseOffset && videoCollapsed) {
				videoCollapsed = false;

				if(videoPlays) {
					ytIframe.css(ytInit);
					window.requestAnimationFrame(function () {
						ytIframe.removeClass('ytcollapse-'+className+' animate');
					});
					if(scrollPosition === 'BOTTOM_RIGHT') {
						videoScroll.hide();
					}
				} else {
					videoScroll.removeClass(className);
				}
			}
		});

		function getYTContainerStyles() {
			videoOffset = videoElement.offset();
			videoWidth = videoElement.outerWidth();
			videoHeight = videoElement.outerHeight();
			leftInitialPosition = videoOffset.left;
			rightInitialPosition = viewportWidth - leftInitialPosition - videoWidth;
			switch(scrollPosition) {
				case 'TOP_RIGHT':
					return {
						'position': 'fixed',
						'top': videoOffset.top - $(window).scrollTop(), //viewportHeight + videoHeight + videoOffset.top - $(window).scrollTop(),
						'right': rightInitialPosition
					};
				case 'BOTTOM_RIGHT':
					return {
						'position': 'fixed',
						'bottom': viewportHeight - videoHeight - videoOffset.top + $(window).scrollTop(),
						'right': rightInitialPosition
					};
				case 'BOTTOM_LEFT':
					return {
						'position': 'fixed',
						'bottom': viewportHeight - videoHeight - videoOffset.top + $(window).scrollTop(),
						'left': leftInitialPosition
					};
			}
		}


		function getUrlVars()
		{
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for(var i = 0; i < hashes.length; i++)
			{
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}

//		var scrollPosition = getUrlVars().scroll; // TOP_RIGHT, BOTTOM_RIGHT, BOTTOM_LEFT
//
//		var videoScroll = $('.video-scroll').appendTo('body');
//
//		var videoCollapsed = false;
//
//		var viewportWidth = $(window).width();
//		var viewportHeight = $(window).height();
//
//		var videoElement = $('#premium-design-ab-test-A-pageheader .video');
//		var videoOffset = videoElement.offset();
//		var videoWidth = videoElement.outerWidth();
//		var videoHeight = videoElement.outerHeight();
//		var leftInitialPosition = videoOffset.left;
//		var rightInitialPosition = viewportWidth - leftInitialPosition - videoWidth;
//
//		var ytIframe = $('<iframe width="640" height="360" src="https://www.youtube.com/embed/xFulu1I3yEw?showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
//
//		var videoPlays = false;
//
//		videoElement.click(function (){
//			videoElement.append(ytIframe);
//
//
//			ytIframe.css({
//				'position': 'absolute',
//				'width': videoWidth + 'px',
//				'height': videoHeight + 'px',
//				'top': '0',
//				'right': '0'
//			});
//
//			videoPlays = true;
//		});
//
//		var scrollOffset = 100;
//		var collapseOffset = videoOffset.top + videoHeight - scrollOffset;
//
//		var topRightInit = {
//			'top': (-videoHeight-100) + 'px',
//			'right': rightInitialPosition + 'px',
//			'width': videoWidth + 'px'
//		};
//
//		var topRightFinal = {
//			'top': '70px',
//			'right': '20px',
//			'width': '250px'
//		};
//
//		var bottomRightInit = {
//			'bottom': (viewportHeight) + 'px',
//			'right': rightInitialPosition + 'px',
//			'width': videoWidth + 'px'
//		};
//
//		var bottomRightFinal = {
//			'bottom': '40px',
//			'right': '20px',
//			'width': '250px'
//		};
//
//		var bottomLeftInit = {
//			'bottom': (viewportHeight) + 'px',
//			'left': leftInitialPosition + 'px',
//			'width': '859px'
//		};
//
//		var bottomLeftFinal = {
//			'bottom': '40px',
//			'left': '20px',
//			'width': '250px'
//		};
//
//		var init = bottomLeftInit;
//		var final = bottomLeftFinal;
//		var className = 'bottom-right';
//
//		switch(scrollPosition) {
//			case 'TOP_RIGHT':
//				init = topRightInit;
//				final = topRightFinal;
//				className = 'top-right';
//				break;
//			case 'BOTTOM_RIGHT':
//				init = bottomRightInit;
//				final = bottomRightFinal;
//				className = 'bottom-right';
//				break;
//			case 'BOTTOM_LEFT':
//				init = bottomLeftInit;
//				final = bottomLeftFinal;
//				className = 'bottom-left';
//				break;
//		}
//
//		videoScroll.css(init);
//		videoScroll.css('display', 'block');
//		videoScroll.find('.video-thumbnail').css({'height': '480px'});
//		if (scrollPosition !== 'TOP_RIGHT') {
//			videoScroll.find('.video-details').css({'opacity': '1'});
//		}
//
//
////		top: 303px;
////		right: 691px;
////		width: 858px;
////
////		.video-thumbnail {
////			height: 480px;
////		}
//
//
//		$(window).scroll(function () {
//			collapseOffset = videoElement.offset().top + videoElement.outerHeight() - scrollOffset;
//			if($(window).scrollTop() > collapseOffset && !videoCollapsed) {
////				collapseVideo();
//				videoCollapsed = true;
////				videoScroll.addClass(className);
//				if(videoPlays) {
//					ytIframe.css({
//						'position': 'fixed',
////						'width': videoWidth + 'px',
////						'height': videoHeight + 'px',
//						'top': videoOffset.top - $(window).scrollTop(), //viewportHeight + videoHeight + videoOffset.top - $(window).scrollTop(),
//						'right': rightInitialPosition,
////						'top': 'auto'
//					});
//					window.requestAnimationFrame(function () {
//						ytIframe.addClass('ytcollapse-'+className);
//					});
//				}
//
//
//			} else if($(window).scrollTop() <= collapseOffset && videoCollapsed) {
////				uncollapseVideo();
//				videoCollapsed = false;
//				videoScroll.removeClass(className);
//				ytIframe.removeClass('ytcollapse-'+className);
//
//				setTimeout(function () {
//					ytIframe.css({
//						'top': '0',
//						'right': '0',
//						'position': 'absolute',
//						'width': videoWidth + 'px',
//						'height': videoHeight + 'px',
////					'top': '0'
//					});
//				});
//
//			}
//		});
//
//		function collapseVideo () {
//			videoScroll.animate(final, { duration: 600 });
//			videoScroll.find('.video-thumbnail').animate({'height': '140px'}, { duration: 600 });
//			videoCollapsed = true;
//		}
//
//		function uncollapseVideo () {
//			videoScroll.animate(init, 100);
//			videoScroll.find('.video-thumbnail').animate({'height': '480px'});
//			videoCollapsed = false;
//		}
//

	});

</script>