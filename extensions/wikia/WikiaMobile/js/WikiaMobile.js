var WikiaMobile = WikiaMobile || (function() {
	/** @private **/

	var allImages = [],
	deviceWidth = ($.os.ios) ? 268 : 300,
	deviceHeight = ($.os.ios) ? 416 : 513,
	realWidth = ($.os.ios)?((window.orientation == 0) ? screen.width : screen.height) : screen.width,
	//TODO: finalize the following line and update all references to it (also in extensions)
	clickEvent = ('ontap' in window) ? 'tap' : 'click',
	touchEvent = ('ontouchstart' in window) ? 'touchstart' : 'click';

	function getImages(){
		return allImages;
	}

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	function hideURLBar(){
		setTimeout(function(){
		  	if(!window.pageYOffset)
				window.scrollTo(0, 1);
		}, 1);
	}

	function handleTables(){
		$('table').not('table table').each(function() {
			var table = $(this),
			rows = table.find('tbody tr'),
			rowsLength = rows.length;
console.time('tables');
			// if table has less rows we don't want to deal with it
			//as it is probably a layout table
			//if infobox we already style it
			if(!table.hasClass('infobox')) {
				//find infobox like tables
				if(rowsLength > 2) {
					var correctRows = 0;
					$.each(rows, function(index, row) {
						var cellLength = row.cells.length;
						if(cellLength > 2) {
							return false;
						} else if(cellLength === 2) {
							correctRows++
						}
						return true;
					});

					if(correctRows > Math.floor(rowsLength/2)) {
						table.addClass('infobox');
						return false;
					}
				}
			}
				//find tables that are too big
				if(this.offsetWidth > realWidth || this.offsetHeight > deviceWidth) {
					$(this).wrapAll('<div class=bigTable>');
				}
console.timeEnd('tables');
return true;
		});
	}

	function processImages(){
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

	function imgModal(number, caption){
		$.openModal({
			imageNumber: number,
			toHide: '.changeImageButton',
			caption: caption,
			addClass: 'imageModal'
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
		//add class to collapse section as quick as possible
		//and return body object as well
		var body = $(document.body).addClass('js'),
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
		body.delegate('.collapsible-section', clickEvent, function(){
			var self = $(this);

			track(['section', self.hasClass('open') ? 'close' : 'open']);
			self.toggleClass('open').next().toggleClass('open');
		})
		.delegate('#WikiaMainContent a', clickEvent, function(){
			track(['link', 'content']);
		})
		.delegate('#WikiaArticleCategories a', clickEvent, function(){
			track(['link', 'category']);
		})
		.delegate('.infobox img', clickEvent, function(event){
			event.preventDefault();
			imgModal($(this).parents('.image').data('number'));
		})
		.delegate('figure', clickEvent, function(event){
			event.preventDefault();

			var thumb = $(this),
			image = thumb.children('.image').first();
			imgModal(image.data('number'), thumb.children('.thumbcaption').html());
		})
		.delegate('.wikia-slideshow', clickEvent, function(event){
			event.preventDefault();
			imgModal($(this).data('number'));
		})
		.delegate('.bigTable', clickEvent, function(event){
			event.preventDefault();

			$.openModal({
				addClass: 'wideTable',
				html: this.innerHTML,
				onOpen: WMWideTables.handleTableScrolling
			});
		});

		$('#searchForm').bind('submit', function(){
			track(['search', 'submit']);
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

		$('#WikiaPage').bind(clickEvent, function(event){
			navigationWordMark.show();
			navigationSearch.hide().removeClass('open');
			searchToggle.removeClass('open');
			searchInput.val('');
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