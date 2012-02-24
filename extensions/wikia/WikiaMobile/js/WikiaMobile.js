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
	tableWrapperHTML = '<div class=bigTable>',
	adSlot,
	shrData,
	pageUrl = wgServer + '/wiki/' + wgPageName,
	shrImgTxt, shrPageTxt, shrMailPageTxt, shrMailImgTxt,
	$1 =/__1__/g, $2 =/__2__/g, $3 =/__3__/g, $4 = /__4__/g,
	fixed = Modernizr.positionfixed;

	function getImages(){
		return allImages;
	}

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	function hideURLBar(){
		if(window.pageYOffset < 20) {
			setTimeout(function(){
					window.scrollTo(0, 1);
					if(!fixed) moveSlot();
			}, 0);
		}
	}

	function processSections(){
		var firstLevelSections = $('#wkMainCnt > h2');

		//avoid running if there are no sections which are direct children of the article section
		if(firstLevelSections.length > 0){
			var articleElement = article[0],
				contents = article.contents(),
				wrapper = articleElement.cloneNode(false),
				root = wrapper,
				x,
				y = contents.length,
				currentSection,
				node,
				nodeName,
				isH2,
				goBck = '<span class=goBck>&uarr; '+$.msg('wikiamobile-hide-section')+'</span>';

			for (x=0; x < y; x++) {
				node = contents[x];
				nodeName = node.nodeName;
				isH2 = (nodeName == 'H2');

				if (nodeName != '#comment' && nodeName != 'SCRIPT') {
					if(node.id == 'WkMainCntFtr' || node.className == 'printfooter' || (node.className && node.className.indexOf('noWrap') > -1)){
						//do not wrap these elements
						currentSection.insertAdjacentHTML('beforeend', goBck);
						root = wrapper;
					}else if (isH2){
						if (currentSection) {
							currentSection.insertAdjacentHTML('beforeend', goBck);
							wrapper.appendChild(currentSection);
						}

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

	function processImages(){
		var number = 0,
		href, name, nameMatch = /[^\/]*\.\w*$/;

		$('.infobox .image, .wkImgStk, figure').not('.wkImgStk > figure').each(function(){
			var self = $(this);

			if(self.hasClass('image')){
				href = self.data('num', number++).attr('href');
				name = href.match(nameMatch)[0].replace('.','-');
				allImages.push([href, name]);
			} else if(self.hasClass('wkImgStk')){
				if(self.hasClass('grp')) {
					var figures = self.find('figure'),
					l = figures.length,
					cap;

					self.data('num', number).find('footer').append(l);

					$.each(figures, function(i, fig){
						href = fig.getElementsByClassName('image')[0].href;
						name = href.match(nameMatch)[0].replace('.','-');
						allImages.push([
							href, name,
							(cap = fig.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:"",
							i, l

						]);
					});
				} else {
					var l = parseInt( self.data('num', number).data('img-count'), 10),
					lis = self.find('li');

					$.each(lis, function(i, li){
						href = li.attributes['data-img'].nodeValue;
						name = href.match(nameMatch)[0].replace('.','-');
						allImages.push([
							href,
							name,
							li.innerHTML,
							//I need these number to show counter in a modal
							i, l
						]);
					});
				}
				number += l;
			} else {
				self.data('num', number++);
				href = self.find('.image').attr('href');
				name = href.match(nameMatch)[0].replace('.','-');
				allImages.push([
					href, name,
					self.find('.thumbcaption').html()
				]);
			}
		});

		//if there is only one image in the article hide the prev/next buttons
		//in the image modal
		//TODO: move to a modal API call
		if(allImages.length <= 1) body.addClass('oneImg');
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
				window.addEventListener(sizeEvent, processTables, false);
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

	function moveSlot(){
		adSlot.style.top = Math.min((window.pageYOffset + window.innerHeight - 50), ftr.offsetTop + 150) + 'px';
	}

	function loadShare(cnt){
		var handle = function(html){
			if(cnt.parentNode.id == 'wkShrPag'){
				cnt.innerHTML = html.replace($1, pageUrl).replace($2, shrPageTxt).replace($3, shrMailPageTxt).replace($4, shrPageTxt);

				$(cnt).delegate('li', clickEvent, function(){
					track('share/page/'+this.className.replace('Shr',''));
				});
			}else{
				var imgUrl = pageUrl + '?image=' + allImages[$.getCurrentImg()][1];
				cnt.innerHTML = html.replace($1,imgUrl).replace($2, shrImgTxt).replace($3, shrMailImgTxt).replace($4, shrImgTxt);
			}
		};

		if(!shrData){
			shrData = Wikia.Cache.get('shareButtons' + wgStyleVersion);
			shrPageTxt = $.msg('wikiamobile-sharing-page-text', wgTitle, wgSitename);
			shrMailPageTxt = encodeURIComponent($.msg('wikiamobile-sharing-email-text', shrPageTxt));
			shrImgTxt = $.msg('wikiamobile-sharing-modal-text', $.msg('wikiamobile-sharing-media-image'), wgTitle, wgSitename);
			shrMailImgTxt = encodeURIComponent($.msg('wikiamobile-sharing-email-text', shrImgTxt));
		}

		if(!shrData){
			$.nirvana.sendRequest({
				controller: 'WikiaMobileController',
				method: 'getShareButtons',
				format: 'html',
				type: 'GET',
				data: {
					'cb': wgStyleVersion
				},
				callback: function(result){
					Wikia.Cache.set('shareButtons' + wgStyleVersion, result, 604800/*7 days*/);
					shrData = result;
					handle(result);
				}
			});
		}else{
			handle(shrData);
		}
	}

	/*
	 * POPOVER
	 * create or/and open callback has to be provided to create pop over
	 *
	 * options.on - (required) element that opens popover - throws an exception if not provided
	 * options.style - allows you to pass cssText for a content wrapper
	 * options.create - content of popover, either string or function that gets content wrapper as an attribute
	 * options.position - position of popover relative to the button 'bottom', 'top', 'left' , 'right'
	 * options.open - callback on open
	 * options.close - callback on close
	*/
	function popOver(options){
		options = options || {};

		var elm = options.on,
		initialized = false,
		isOpen = false,
		cnt;

		if(elm){
			elm.addEventListener(clickEvent, function(event){
				if(this.className.indexOf("on") > -1){
					close();
				}else{
					if(!initialized){
						var position = options.position || 'bottom',
							horizontal = (position == 'bottom' || position == 'top'),
							offset = (horizontal)?this.offsetHeight:this.offsetWidth,
							onCreate = options.create,
							style = options.style || '';


						this.insertAdjacentHTML('afterbegin', '<div class=ppOvr></div>');
						cnt = this.getElementsByClassName('ppOvr')[0];

						if(onCreate){
							changeContent(onCreate);
						}else if(!open){
							throw 'No content or on open callback provided';
						}

						this.className += ' ' + position;
						var pos = (horizontal)?(position == 'top'?'bottom':'top'):(position == 'left'?'right':'left');
						cnt.style[pos] = (offset + 15) + 'px';

						cnt.style.cssText += style;

						initialized = true;
					}

					open();
				}
			});
		}else{
			throw 'Non existing element';
		}

		function changeContent(onCreate){
			cnt.innerHTML = '';
			if(typeof onCreate == 'function'){
				$.showLoader($(cnt), {center: true, size: '20px'});
				onCreate(cnt);
			}else{
				cnt.insertAdjacentHTML('afterbegin', onCreate);
			}
		}

		function close(){
			if(isOpen){
				elm.className = elm.className.replace(" on", "");
				if(typeof options.close == 'function') {
					 options.close(event, elm);
				}
				isOpen = false;
			}
		}

		function open(){
			if(!isOpen){
				elm.className += " on";
				if(typeof options.open == 'function') {
					options.open(event, elm);
				}
				isOpen = true;
			}

		}

		return {
			changeContent: changeContent,
			close: close
		}
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
		ad = $('#wkAdPlc'),
		thePage = page.add('#wkFtr').add(ad),
		lvl1 = $('.lvl1'),
		//to cache link in wiki nav
		lvl2Link;

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

		//handle ads
		adSlot = ad[0];

		var close = document.getElementById('wkAdCls'),
			i = 0;
			adExist = function(){
				if(adSlot.childElementCount > 3){
					close.className = "show";
					adSlot.style.height = '50px';
					close.addEventListener(clickEvent, function() {
						track('ad/close');
						document.body.removeChild(adSlot);
						window.removeEventListener('scroll', moveSlot);
					}, false);
					if(fixed){
						adSlot.style.position = 'fixed';
					}else{
						window.addEventListener('scroll', moveSlot, false);
					}
					return true;
				}
			},
			ftr = document.getElementById('wkFtr');

		if(!adExist()) {
			var inter = setInterval(function() {
				if(!adExist() && i < 5) {
					i += 1;
				}else{
					document.body.removeChild(adSlot);
					clearInterval(inter);
				}
			}, 1000);
		}
		//end of handling ads

		hideURLBar();

		//get search input
		navigationSearch.remove().appendTo('#wkTopBar');

		//TODO: optimize selectors caching for this file
		body.delegate('.collSec', clickEvent, function(){
			var self = $(this);

			track(['section', self.hasClass('open')?'close':'open']);
			self.toggleClass('open').next().toggleClass('open');
		})
		.delegate('.goBck', clickEvent, function(){
			var top = $(this).parent().removeClass('open').prev().removeClass('open').offset().top;
			window.scrollTo(0, top);
		})
		.delegate('#wkMainCnt a', clickEvent, function(){
			track('link/content');
		})
		.delegate('.infobox .image, figure, .wkImgStk', clickEvent, function(event){
			event.preventDefault();
			event.stopPropagation();

			if(allImages.length == 0) processImages();

			var img = $(this),
				num = img.data('num') || img.parent().data('num');
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
			track('search/submit');
		});

		searchToggle.bind(clickEvent, function(event){
			event.preventDefault();
			if(navigationBar.hasClass('srhOpn')){
				track('search/toggle/close');
				if(searchInput.val()){
					searchForm.submit();
				}else{
					navigationBar.removeClass();
					searchInput.val('');
				}
			}else{
				track('search/toggle/open');
				closeNav().addClass('srhOpn');
				searchInput.focus();
			}
		});

		//preparing the navigation
		wkNavMenu.delegate('.lvl1 a', clickEvent, function(){
			track('link/nav/list');
		})
		.delegate('header > a', clickEvent, function(){
			track('link/nav/header');
		})
		.find('ul ul').parent().addClass('cld');

		navToggle.bind(clickEvent, function(event){
			event.preventDefault();
			if(navigationBar.hasClass('fllNav')){
				closeNav();
			}else{
				track('nav/open');
				thePage.hide();
				//80px is for lvl1 without header
				navigationBar.addClass('fllNav').height(lvl1.height() + 80);
				window.location.hash = 'WikiNav';
			}
		});

		function closeNav() {
			if(window.location.hash == '#WikiNav') window.history.back();
			track('nav/close');
			thePage.show();
			if(!fixed) moveSlot();
			return navigationBar.removeClass().css('height', '40px');
		}

		//close WikiNav on back button
		if ("onhashchange" in window) {
			window.addEventListener("hashchange", function() {
				if(window.location.hash == "" && navigationBar.hasClass('fullNav')) {
					closeNav();
				}
			}, false);
		}

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
					track('nav/level-2');
				} else {
					wkNavMenu.removeClass().addClass('cur3');
					track('nav/level-3');
				}
			}
		});

		$('#wkNavBack').bind(clickEvent, function() {
			var self = $(this),
			current;

			if(wkNavMenu.hasClass('cur2')) {
				wkNavMenu.removeClass().addClass('cur1').find('.lvl2').removeClass('cur');
				navigationBar.height(lvl1.height() + 80);
				track('nav/level-1');
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
				track('nav/level-2');
			}
		});
		//end of preparing the nav

		page.bind(clickEvent, function(event){
			navigationBar.removeClass();
			searchInput.val('');
		});

		$('#wkRelPag').delegate('a', clickEvent, function(){
			track('link/related-page');
		});

		$('#wkArtCat').delegate('a', clickEvent, function(){
			track('link/category');
		});

		$('#wkFllSite').bind(clickEvent, function(event){
			event.preventDefault();
			track('link/fullsite');
			Wikia.CookieCutter.set('mobilefullsite', 'true');
			location.reload();
		});

		//category pages
		$('.pagMore, .pagLess').bind(clickEvent, function(event) {
			event.preventDefault();
			var self = $(this),
				forward = self.hasClass('pagMore'),
				parent = self.parent(),
				prev = (forward) ? parent.children('.pagLess') : self,
				prevBatch = ~~(prev.attr('data-batch')),
				next = (forward) ? self : parent.children('.pagMore'),
				nextBatch = prevBatch + 2,
				batch = (forward) ? nextBatch : prevBatch,
				add = (forward ? 1 : -1),
				id = parent.attr('id'),
				container = parent.find('ul');

			prev.attr('data-batch', prevBatch + add);
			next.attr('data-batch', nextBatch + add);

			self.toggleClass('active');
			$.showLoader(self);

			$.nirvana.sendRequest({
				controller: 'WikiaMobileController',
				method: 'getCategoryBatch',
				format: 'html',
				data:{
					category: wgTitle,
					batch: batch,
					index: encodeURIComponent(id.substr(-1, 1))
				},
				callback: function(result){
					container.remove();
					next.before(result);

					if(forward) {
						window.scrollTo(0, parent.prev().offset().top);
						track('category/next');
					} else {
						track('category/prev');
					}

					self.toggleClass('active');
					$.hideLoader(self);

					(batch > 1) ? prev.addClass('visible') : prev.removeClass('visible');

					(batch < ~~(parent.attr('data-batches'))) ? next.addClass('visible') : next.removeClass('visible');
				}
			});
		});

		$('#expAll').bind(clickEvent, function(event) {
			var elements = $('.alphaSec .artSec').add('.alphaSec .collSec');
			if($(this).toggleClass('exp').hasClass('exp')){
				elements.addClass('open');
				track('category/expandAll');
			}else{
				elements.removeClass('open');
				track('category/collapseAll');
			}
		});

		$('#wkCatExh').bind(clickEvent, function(event) {
			track('category/exhibition/click');
		});
		//end category pages

		popOver({
			on: document.getElementById('wkShrPag'),
			create: function(cnt){
				loadShare(cnt);
			},
			open: function(){
				track('share/page/open');
			},
			close: function(){
				track('share/page/close');
			},
			style: 'right:0;'
		});

		//if url contains image=imageName - open modal with this image
		var locationSearch = window.location.search;
		if(locationSearch.indexOf('image=') > -1){
			var img = locationSearch.substr(1).split('&'),
				imgName;
			for(var i=0;i<img.length; i++){
				var s = img[i].split('=');
				if(s[0] == 'image'){
					imgName = s[1];
					break;
				}
			}

			if(allImages.length == 0) processImages();
			var imgL = allImages.length;
			for(var i=0;i<imgL;i++){
				if(allImages[i][1] == imgName){
					setTimeout(function(){imgModal(i)}, 1000)
					break;
				}
			}
		}
	});

	return {
		getImages: getImages,
		getDeviceResolution: getDeviceResolution,
		getClickEvent: getClickEvent,
		getTouchEvent: getTouchEvent,
		track: track,
		moveSlot: moveSlot,
		popOver: popOver,
		loadShare: loadShare
	};
})();