var WikiaMobile = WikiaMobile || (function() {
	/** @private **/

	var body,
	page,
	article,
	allImages = [],
	handledTables,
	deviceWidth = ($.os.ios) ? 268 : 300,
	deviceHeight = ($.os.ios) ? 416 : 513,
	realWidth = window.innerWidth || window.clientWidth,
	realHeight = window.innerHeight || window.clientHeight,
	//TODO: finalize the following line and update all references to it (also in extensions)
	clickEvent = ('ontap' in window) ? 'tap' : 'click',
	touchEvent = ('ontouchstart' in window) ? 'touchstart' : 'mousedown',
	sizeEvent = ('onorientationchange' in window) ? 'orientationchange' : 'resize',
	tableWrapperHTML = '<div class="bigTable">';

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

	function processSections(){
		var firstLevelSections = $('#WikiaMainContent > h2');

		//avoid running if there are no sections which are direct children of the article section
		if(firstLevelSections.length > 0){
			var articleElement = article[0],
				contents = article.contents(),
				root = wrapper = articleElement.cloneNode(false),
				x = 0,
				y = contents.length,
				currentSection,
				node,
				nodeName,
				isH2;

			for (; x < y; x++) {
				node = contents[x];
				nodeName = node.nodeName;
				isH2 = (nodeName == 'H2');

				if (nodeName != '#comment' && nodeName != 'SCRIPT') {
					if(node.id == 'WikiaMainContentFooter' || node.className == 'printfooter'){
							//do not wrap these elements
							root = wrapper;
					}else if (isH2){
						if (currentSection) wrapper.appendChild(currentSection);

						currentSection = document.createElement('section');
						currentSection.className = 'articleSection';
						node = node.cloneNode(true);

						node.className += ' collSec';

						wrapper.appendChild(node);
						wrapper.appendChild(currentSection);
						root = currentSection;
						continue;
					}

					root.appendChild(node.cloneNode(true));
				}
			}

			page[0].replaceChild(wrapper, articleElement);
		}
	}

	function processTables(){
		if(typeof handledTables == 'undefined'){
			handledTables = [];

			$('table').not('table table').each(function(){
				var table = $(this),
				rows = table.find('tr'),
				rowsLength = rows.length;

				//handle custom and standard infoboxes
				if(table.hasClass('infobox'))
					return true;

				//find infobox like tables
				if(rowsLength > 2){
					var correctRows = 0,
					cellLength;

					$.each(rows, function(index, row) {
						cellLength = row.cells.length;

						if(cellLength > 2)
							return false;

						if(cellLength == 2)
							correctRows++;

						//sample only the first X rows
						if(index == 9)
							return false;
					});

					if(correctRows > Math.floor(rowsLength/2)) {
						table.addClass('infobox');
						return true;
					}
				}

				//if the table width is bigger than any screen dimension (device can rotate)
				//or taller than the allowed vertical size, then wrap it and/or add it to
				//the list of handled tables for speeding up successive calls
				//NOTE: tables with 100% width have the same width of the screen, check the size of the first row instead
				var firstRowWidth = rows.first().width(),
					tableHeight = table.height();

				table.computedWidth = firstRowWidth;
				table.computedHeight = tableHeight;

				if(firstRowWidth > realWidth || table.height() > deviceWidth){
					//remove scripts to avoid re-parsing
					table.find('script').remove();
					table.wrap(tableWrapperHTML);
					table.wasWrapped = true;
					table.isWrapped = true;
					handledTables.push(table);
				} else if(firstRowWidth > realHeight){
					table.wasWrapped = false;
					table.isWrapped = false;
					handledTables.push(table);
				}
			});

			if(handledTables.length > 0)
				window.addEventListener(sizeEvent, processTables);
		}else if(handledTables.length > 0){
			var table, row, isWrapped, isBig, wasWrapped,
				maxWidth = window.innerWidth || window.clientWidth;

			for(var x = 0, y = handledTables.length; x < y; x++){
				table = handledTables[x];
				row = table.find('tr').first();
				isWrapped = table.isWrapped;
				wasWrapped = table.wasWrapped;
				isBig = (table.computedWidth > maxWidth || table.computedHeight > deviceWidth);

				if(!isWrapped && isBig){
					if(!wasWrapped){
						table.wasWrapped = true;
						//remove scripts to avoid re-parsing
						table.find('script').remove();
					}

					table.wrap(tableWrapperHTML);
					table.isWrapped = true;
				}else if(isWrapped && !isBig){
					table.unwrap();
					table.isWrapped = false;
				}
			}
		}
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

		//if there is only one image in the article hide the prev/next buttons
		//in the image modal
		//TODO: move to a modal API call
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
		body = $(document.body);
		page = $('#WikiaPage');
		article = $('#WikiaMainContent');

		var navigationWordMark = $('#navigationWordMark'),
		navigationSearch = $('#navigationSearch'),
		searchToggle = $('#searchToggle'),
		searchInput = $('#searchInput');

		//analytics
		track('view');

		processSections();//NEEDS to run before table wrapping!!!
		processTables();


		//add class for styling to be applied only if JS is enabled
		//(e.g. collapse sections)
		//must be done AFTER detecting size of elements on the page
		body.addClass('js');

		hideURLBar();
		processImages();

		//TODO: optimize selectors caching for this file
		//TODO: css alias
		body.delegate('.collapsible-section, .collSec', clickEvent, function(){
			var self = $(this);

			track(['section', self.hasClass('open') ? 'close' : 'open']);
			self.toggleClass('open').next().toggleClass('open');
		})
		.delegate('#WikiaMainContent a', clickEvent, function(){
			track(['link', 'content']);
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
				html: this.innerHTML
			});
		});

		$('#searchForm').bind('submit', function(){
			track(['search', 'submit']);
		});

		$('#searchToggle').bind(touchEvent, function(event){
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

		//preparing the navigation
		var wkWikiNav = $('#wkWikiNav');

		//find menu on a page and append it to topBarMenu and check if element has child and append .child class
		wkWikiNav.append( $('#wkNavMenu').remove().children('ul') ).find('ul ul').parents('li').addClass('child');

		$('#navToggle').bind(clickEvent, function(event) {
			var self = $(this),
				nav = $('#wkNav'),
				topBar = $('#navigation');

			if(self.hasClass('open')){
				//track(['navigation', 'toggle', 'close']);
				self.removeClass('open');
				nav.removeClass('open');
				topBar.removeClass('noShadow');
				$(document.body).children().not('#navigation, #wkNav').show();
			}else{
				//track(['navigation', 'toggle', 'open']);
				$(document.body).children().not('#navigation, #wkNav').hide();
				self.addClass('open');
				nav.addClass('open');
				topBar.addClass('noShadow');
			}
		});

		//will be needed when more tabs will be introduced
		 /* $('#wkTabs').delegate('li', clickEvent, function() {
			var self = $(this);

			if(self.hasClass('active')){
				//track(['navigation', 'toggle', 'close']);
				self.removeClass('active');
			}else{
				//track(['navigation', 'toggle', 'open']);
				self.addClass('active');
			}
		}); */

		$('.lvl1').delegate('.child', clickEvent, function(event) {
			var self = $(this),
			element = self.children(':first-child');

			if($(event.target).parent().is('.child')) {

				event.stopPropagation();
				event.preventDefault();

				$('#topBarText').text(element.text());

				if(element.is('a')) {
					$('#wkWikiNav header a').attr('href', element.attr('href')).show();
				} else {
					$('#wkWikiNav header a').hide();
				}

				self.children('ul').addClass('current');

				if($('#wkWikiNav').is('.current1')) {
					$('#wkWikiNav').addClass('current2').removeClass('current1');
				} else {
					$('#wkWikiNav').addClass('current3').removeClass('current2');
				}
			}
		});

		$('#wkNavBack').bind(clickEvent, function() {
			var self = $(this),
			wkNav = $('#wkWikiNav');

			if(wkNav.is('.current2')) {
				wkNav.addClass('current1').removeClass('current2').find('.lvl2').removeClass('current');
			} else {
				wkNav.addClass('current2').removeClass('current3').find('.lvl3').removeClass('current');
				$('#topBarText').text( $('.current').prev().text() );
			}
		});

		//end of preparing the nav

		page.bind(clickEvent, function(event){
			navigationWordMark.show();
			navigationSearch.hide().removeClass('open');
			searchToggle.removeClass('open');
			searchInput.val('');
		});

		$('#wkRelPag').delegate('a', clickEvent, function(){
			track(['link', 'related-page']);
		});

		$('#WikiaArticleCategories').delegate('a', clickEvent, function(){
			track(['link', 'category']);
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
	};
})();