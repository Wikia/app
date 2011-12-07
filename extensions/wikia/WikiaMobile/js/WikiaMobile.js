var WikiaMobile = WikiaMobile || (function() {
	/** @private **/

	var allImages = [],
	deviceWidth = ($.os.ios) ? 268 : 320,
	deviceHeight = ($.os.ios) ? 416 : 533,
	realWidth = (window.orientation == 0 || window.orientation == 180) ? 320 : 480,
	//TODO: finalize the following line and update all references to it (also in extensions)
	clickEvent = ('ontouchstart' in window) ? 'tap' : 'click',
	touchEvent = ('ontouchstart' in window) ? 'touchstart' : 'click';

	function getImages(){
		return allImages;
	}

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	function hideURLBar(){
		setTimeout(function(){
		  	if(!pageYOffset)
				window.scrollTo(0, 1);
		}, 1);
	}

	function handleTables(){
		$('table').not('table table').each(function() {
			if(this.offsetWidth > realWidth)
				$(this).addClass('tooBigTable');
		});
	}

	function processImages() {
		var number = 0,
		image;

		$('.infobox .image').each(function(){
			allImages.push([$(this).data('number', number++).attr('href')]);
		});

		$('figure').each(function(){
			var self = $(this);
			allImages.push([
				self.find('.image').data('number', number++).attr('href'),
				self.find('.thumbcaption').html()
			]);
		});

		$('.wikia-slideshow').each(function(){
			var slideshow = $(this),
			length = slideshow.data('number', number++).data('image-count');

			for(var i = 0; i < length; i++) {
				allImages.push([slideshow.data('slideshow-image-id-' + i)]);
			}
		});

		if(allImages.length <= 1) $('body').addClass('justOneImage');
	}

	function getDeviceResolution(){
		return [deviceWidth, deviceHeight];
	}

	function imgModal(number, href, caption){
		$.openModal({
			html: '<div class="changeImageButton" id="previousImage"><div class="changeImageChevron"></div></div><div class="fullScreenImage" data-number='+
				number +
				' style=background-image:url("'+
				href +
				'")></div><div class="changeImageButton" id="nextImage"><div class="changeImageChevron"></div></div>',
			toHide: '.changeImageButton',
			caption: caption
		});
	}

	function getClickEvent(){
		return clickEvent;
	}

	function getTouchEvent(){
		return touchEvent;
	}

	function track(ev){
		WikiaTracker.track('/1_mobile/' + ((ev instanceof Array) ? ev.join('/') : ev), 'main.sampled');
	}

	//init
	$(function(){
		var body = $(document.body),
		navigationWordMark = $('#navigationWordMark'),
		navigationSearch = $('#navigationSearch'),
		searchToggle = $('#searchToggle'),
		searchInput = $('#searchInput'),
		wikiaAdPlace = $('#WikiaAdPlace');

		//analytics
		track('view');

		hideURLBar();
		handleTables();
		processImages();

		//TODO: optimize selectors caching for this file
		body.delegate( '#WikiaMainContent > h2, #WikiaPage .collapsible-section', clickEvent, function(){
			var self = $(this);

			track(['section', self.hasClass('open') ? 'close' : 'open']);
			self.toggleClass('open').next().toggleClass('open');
		});

		$('#WikiaMainContent a').bind(clickEvent, function(){
			track(['link', 'content']);
		});

		$('#WikiaArticleCategories a').bind(clickEvent, function(){
			track(['link', 'category']);
		});

		$('#searchForm').bind('submit', function(){
			track(['search', 'submit']);
		});

		$('.infobox img').bind(clickEvent, function(event) {
			event.preventDefault();

			var thumb = $(this),
				image = thumb.parents('.image');
			imgModal(image.data('number'), image.attr('href'));
		});

		$('figure').bind(clickEvent, function(event) {
			event.preventDefault();

			var thumb = $(this),
				image = thumb.children('.image').first();
			imgModal(image.data('number'), image.attr('href'), thumb.children('.thumbcaption').html());
		});

		$('.wikia-slideshow').bind(clickEvent, function(event){
			event.preventDefault();

			var slideshow = $(this);
			imgModal(slideshow.data('number'), slideshow.find('img').attr('src'));
		});

		$('#searchToggle').bind(clickEvent, function(event){
			var self = $(this);

			if(self.hasClass('open')){
				track(['search', 'toggle', 'close']);
				navigationWordMark.show();
				navigationSearch.hide().removeClass('open');
				self.removeClass('open');
				searchInput.val('');
			}else{
				track(['search', 'toggle', 'open']);
				navigationWordMark.hide();
				navigationSearch.show().addClass('open');
				self.addClass('open');
			}
		});

		$('#WikiaPage').bind(clickEvent, function(event) {
			navigationWordMark.show();
			navigationSearch.hide().removeClass('open');
			searchToggle.removeClass('open');
			searchInput.val('');
		});

		$('.tooBigTable').bind(clickEvent, function(event) {
			event.preventDefault();

			$.openModal({
				addClass: 'wideTable',
				html: this.outerHTML
			});
		});

		$('#fullSiteSwitch').bind(clickEvent, function(event){
			event.preventDefault();

			track(['link', 'fullsite']);
			Wikia.CookieCutter.set('mobilefullsite', 'true');
			location.reload();
		});
	});

	return {
		getImages: getImages,
		getDeviceResolution: getDeviceResolution,
		getClickEvent: getClickEvent,
		getTouchEvent: getTouchEvent,
		track: track
	}
})();