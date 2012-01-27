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
	tableWrapperHTML = '<div class=bigTable>';

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
		var firstLevelSections = $('#wkMainCnt > h2');

		//avoid running if there are no sections which are direct children of the article section
		if(firstLevelSections.length > 0){
			var articleElement = article[0],
				contents = article.contents(),
				wrapper = articleElement.cloneNode(false),
				root = wrapper,
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
					if(node.id == 'WkMainCntFtr' || node.className == 'printfooter'){
							//do not wrap these elements
							root = wrapper;
					}else if (isH2){
						if (currentSection) wrapper.appendChild(currentSection);

						currentSection = document.createElement('section');
						currentSection.className = 'artSec';
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

	function getDeviceResolution(){
		return [deviceWidth, deviceHeight];
	}

	function imgModal(number){
		$.openModal({
			imageNumber: number,
			toHide: '.chnImgBtn',
			addClass: 'imgMdl'
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
		page = $('#wkPage');
		article = $('#wkMainCnt');

		var navigationSearch = $('#wkNavSrh'),
		searchToggle = $('#wkSrhTgl'),
		searchInput = $('#wkSrhInp'),
		searchForm = $('#wkSrhFrm'),
		wkNavMenu = $('#wkNavMenu'),
		wkNav = $('#wkNav'),
		//while getting the h1 element erase classes needed for phones with no js
		wikiNavHeader = wkNavMenu.find('h1').removeClass(),
		wikiNavLink = $('#wkNavLink'),
		navigationBar = $('#wkTopNav'),
		navToggle = $('#wkNavTgl'),
		thePage = page.add('#wkFtr'),
		lvl1 = $('.lvl1'),
		//to cache link in wiki nav
		lvl2Link,
		number = 0;
		
		//replace menu from bottom to topBar - the faster the better
		wkNav[0].replaceChild(wkNavMenu[0], document.getElementById('wkWikiNav'));
		
		//analytics
		track('view');

		processSections();//NEEDS to run before table wrapping!!!
		processTables();

		//add class for styling to be applied only if JS is enabled
		//(e.g. collapse sections)
		//must be done AFTER detecting size of elements on the page
		body.addClass('js');

		hideURLBar();
		
		//processImages
		$('.infobox .image, .wkImgStk, figure').not('.wkImgStk > figure').each(function() {
			var self = $(this);

			if(self.hasClass('image')) {
				allImages.push([self.data('num', number++).attr('href')]);
			} else if(self.hasClass('wkImgStk')) {
				if(self.hasClass('grp')) {
					var figures = self.find('figure'),
					l = figures.length,
					cap;

					self.data('num', number).find('footer').append(l);

					$.each(figures, function(i, fig){
						allImages.push([
							fig.getElementsByClassName('image')[0].href,
							(cap = fig.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:"",
							i, l
						]);
					});
				} else {
					var l = parseInt( self.data('num', number).data('img-count'), 10),
					lis = self.find('li');

					$.each(lis, function(i, li){
						allImages.push([
							li.attributes['data-img'].nodeValue,
							li.innerHTML,
							//I need these number to show counter in a modal
							i, l
						]);
					});
				}
				number += l;
			} else {
				self.data('num', number++);
				allImages.push([
					self.find('.image').attr('href'),
					self.find('.thumbcaption').html()
				]);
			}
		});
		
		//if there is only one image in the article hide the prev/next buttons
		//in the image modal
		//TODO: move to a modal API call
		if(allImages.length <= 1) body.addClass('oneImg');
		//end processImages

		//TODO: optimize selectors caching for this file
		//TODO: css alias
		body.delegate('.collSec', clickEvent, function(){
			var self = $(this);

			track(['section', self.hasClass('open') ? 'close' : 'open']);
			self.toggleClass('open').next().toggleClass('open');
		})
		.delegate('#wkMainCnt a', clickEvent, function(){
			track(['link', 'content']);
		})
		.delegate('.infobox .image, figure, .wkImgStk', clickEvent, function(event){
			var img = $(this),
			num = img.data('num') || img.parent().data('num');
			event.preventDefault();
			event.stopPropagation();
			if(num) imgModal(num);
		})
		.delegate('.bigTable', clickEvent, function(event){
			event.preventDefault();

			$.openModal({
				addClass: 'wideTable',
				html: this.innerHTML
			});
		});

		searchForm.bind('submit', function(){
			track(['search', 'submit']);
		});

		searchToggle.bind(clickEvent, function(event){
			if(navigationBar.hasClass('srhOpn')){
				track(['search', 'toggle', 'close']);
				if(searchInput.val()){
					searchForm.submit();
				}else{
					navigationBar.removeClass();
					searchInput.val('');
				}
			}else{
				track(['search', 'toggle', 'open']);
				closeNav().addClass('srhOpn');
				searchInput.focus();
			}
		});

		//preparing the navigation
		wkNavMenu.delegate('.lvl1 a', clickEvent, function(){
			track(['link', 'nav', 'list']);
		})
		.delegate('header > a', clickEvent, function(){
			track(['link', 'nav', 'header']);
		})
		.find('ul ul').parent().addClass('cld');

		navToggle.bind(clickEvent, function(event){
			if(navigationBar.hasClass('fllNav')){
				closeNav();
			}else{
				track(['nav', 'open']);
				thePage.hide();
				//80px is for lvl1 without header
				navigationBar.addClass('fllNav').height(lvl1.height() + 80);
				window.location.hash = 'WikiNav';
			}
		});

		function closeNav() {
			if(window.location.hash == '#WikiNav') window.history.back();
			track(['nav', 'close']);
			thePage.show();
			return navigationBar.removeClass();
		}

		//close WikiNav on back button
		if ("onhashchange" in window) {
			window.addEventListener("hashchange", function() {
				if(window.location.hash == "" && navigationBar.hasClass('fullNav')) {
					closeNav();
				}
			}, false);
		}

		//add 'active' state to devices that does't support it
		$("#wkNavMenu li, #wkNavBack, #wkRelPag li, .rpl")
		.bind("touchstart", function () {
			$(this).addClass("wkAct");
		}).bind("touchend touchcancel", function() {
			$(this).removeClass("wkAct");
		});

		lvl1.delegate('.cld', clickEvent, function(event) {
			if($(event.target).parent().is('.cld')) {
				event.stopPropagation();
				event.preventDefault();

				var self = $(this),
				element = self.children().first(),
				href = element.attr('href'),
				ul = self.find('ul').first().addClass('cur');

				wikiNavHeader.text(element.text());

				if(href) {
					wikiNavLink.attr('href', href).show();
				}else{
					wikiNavLink.hide();
				}

				//130px is for lvl2/3 with a header
				navigationBar.height(ul.height() + 130);

				if(wkNavMenu.hasClass('cur1')) {
					wkNavMenu.removeClass().addClass('cur2');
					lvl2Link = href;
					track(['nav', 'level-2']);
				} else {
					wkNavMenu.removeClass().addClass('cur3');
					track(['nav', 'level-3']);
				}
			}
		});

		$('#wkNavBack').bind(clickEvent, function() {
			var self = $(this),
			current;

			if(wkNavMenu.hasClass('cur2')) {
				wkNavMenu.removeClass().addClass('cur1').find('.lvl2').removeClass('cur');
				navigationBar.height(lvl1.height() + 80);
				track(['nav', 'level-1']);
			} else {
				wkNavMenu.removeClass().addClass('cur2').find('.lvl3').removeClass('cur');
				current = $('.lvl2.cur');
				wikiNavHeader.text(current.prev().text());
				navigationBar.height(current.height() + 130);
				if(lvl2Link) {
					wikiNavLink.attr('href', lvl2Link).show();
				} else {
					wikiNavLink.hide();
				}
				wikiNavLink.attr('href', lvl2Link);
				track(['nav', 'level-2']);
			}
		});
		//end of preparing the nav

		page.bind(clickEvent, function(event){
			navigationBar.removeClass();
			searchInput.val('');
		});

		$('#wkRelPag').delegate('a', clickEvent, function(){
			track(['link', 'related-page']);
		});

		$('#wkArtCat').delegate('a', clickEvent, function(){
			track(['link', 'category']);
		});

		$('#wkFllSite').bind(clickEvent, function(event){
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