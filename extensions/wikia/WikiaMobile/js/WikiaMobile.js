var WikiaMobile = (function() {

	//as fast as possible to avoid screen flickering
	//document.documentElement.className += ' js';

	/** @private **/
	var w = window,
		d = document,
		body,
		page,
		article,
		handledTables,
		realWidth = w.innerWidth || w.clientWidth,
		realHeight = w.innerHeight || w.clientHeight,
		tableWrapperHTML = '<div class="bigTable left">',
		adSlot,
		shrData,
		pageUrl = wgServer + wgArticlePath.replace('$1', wgPageName),
		shrImgTxt, shrPageTxt, shrMailPageTxt, shrMailImgTxt,
		$1 =/__1__/g, $2 =/__2__/g, $3 =/__3__/g, $4 = /__4__/g,
		fixed = Modernizr.positionfixed,
		ftr, navBar, wkPrf, wkLgn;

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	function hideURLBar(){
		if(w.pageYOffset < 20) {
			setTimeout(function(){
					w.scrollTo(0, 1);
					if(!fixed) moveSlot();
			}, 1);
		}
	}

	function processSections(){
		//avoid running if there are no sections which are direct children of the article section
		if(d.querySelector('#wkMainCnt > h2')){
			var contents = article.childNodes,
				wrapper = article.cloneNode(false),
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

						currentSection = d.createElement('section');
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

			page.removeChild(article);
			//insertAdjacentHTML does not parse scripts that may be inside sections
			page.insertAdjacentHTML('beforeend', wrapper.outerHTML);
		}
	}

	function processTables(){
		if(typeof handledTables == 'undefined'){
			handledTables = [];

			$('table').not('table table, .infobox, .toc').each(function(){
				var table = $(this),
				rows = table.find('tr'),
				rowsLength = rows.length;

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
				var firstRowWidth = rows.first().width();

				table.computedWidth = firstRowWidth;
				if(firstRowWidth > realWidth){
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
				w.addEventListener('resize', processTables, false);
		}else if(handledTables.length > 0){
			var table, row, isWrapped, isBig, wasWrapped,
				maxWidth = w.innerWidth || w.clientWidth;

			for(var x = 0, y = handledTables.length; x < y; x++){
				table = handledTables[x];
				row = table.find('tr').first();
				isWrapped = table.isWrapped;
				wasWrapped = table.wasWrapped;
				isBig = (table.computedWidth > maxWidth);

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

	function moveSlot(plus){
		adSlot.style.top = Math.min((w.pageYOffset + w.innerHeight - 50 + ~~plus), ftr.offsetTop + 150) + 'px';
	}

	function loadShare(cnt){
		require(['cache', 'media', 'track', 'events'], function(cache, media, track, events){
			var cacheKey = 'shareButtons' + wgStyleVersion;

			function handle(html){
				if(cnt.parentNode.id == 'wkShrPag'){
					cnt.innerHTML = html.replace($1, pageUrl).replace($2, shrPageTxt).replace($3, shrMailPageTxt).replace($4, shrPageTxt);

					$(cnt).delegate('li', events.click, function(){
						track('share/page/'+this.className.replace('Shr',''));
					});
				}else{
					var imgUrl = pageUrl + '?image=' + media.getCurrentImg()[1];
					cnt.innerHTML = html.replace($1,imgUrl).replace($2, shrImgTxt).replace($3, shrMailImgTxt).replace($4, shrImgTxt);
				}
			};

			if(!shrData){
				shrData = cache.get(cacheKey);
				Wikia.processStyle(cache.get(cacheKey+'style'));
				shrPageTxt = $.msg('wikiamobile-sharing-page-text', wgTitle, wgSitename);
				shrMailPageTxt = encodeURIComponent($.msg('wikiamobile-sharing-email-text', shrPageTxt));
				shrImgTxt = $.msg('wikiamobile-sharing-modal-text', $.msg('wikiamobile-sharing-media-image'), wgTitle, wgSitename);
				shrMailImgTxt = encodeURIComponent($.msg('wikiamobile-sharing-email-text', shrImgTxt));
			}

			if(shrData){
				handle(shrData);
			}else{
				Wikia.getMultiTypePackage({
					templates: [{
						controllerName: 'WikiaMobileSharingService',
						methodName: 'index'
					}],
					styles: '/extensions/wikia/WikiaMobile/css/sharing.scss',
					ttl: 86400,
					callback: function(res){
						var html = res.templates['WikiaMobileSharingService_index'],
							style = res.styles;

						Wikia.processStyle(style);
						cache.set(cacheKey, html, 604800/*7 days*/);
						cache.set(cacheKey+'style', style, 604800);
						shrData = html;
						handle(html);
					}
				});
			}
		});
	}

	function onstop(el, x, max){
		var dir = 'bigTable active';

		el.style.border = 'none';

		if(x < max - 5) {
			el.style.borderRight = '5px solid rgb(215,232,242)';
		}

		if(x > 5) {
			el.style.borderLeft = '5px solid rgb(215,232,242)';
		}
	}

	//init
	$(function(){
		require(['modal', 'media', 'cache', 'querystring', 'popover', 'topbar', 'toc', 'track', 'events'], function(modal, media, cache, qs, popover, topbar, toc, track, events){
			body = $(d.body);
			page = d.getElementById('wkPage');
			article = d.getElementById('wkMainCnt');
			ftr = d.getElementById('wkFtr');
			adSlot = d.getElementById('wkAdPlc');

			var wkShrPag = d.getElementById('wkShrPag'),
				//to cache link in wiki nav
				lvl2Link,
				clickEvent = events.click,
				touchEvent = events.touch;

			//replace menu from bottom to topBar - the faster the better
			wkNav.replaceChild(wkNavMenu, d.getElementById('wkWikiNav'));

			//analytics
			track('view');

			processSections();//NEEDS to run before table wrapping!!!
			processTables();

			media.processImages();

			//add class for styling to be applied only if JS is enabled
			//(e.g. collapse sections)
			//must be done AFTER detecting size of elements on the page
			d.body.className += ' js';

			toc.init();

			//handle ads
			if(adSlot){
				var close = d.getElementById('wkAdCls'),
				i = 0;
				adExist = function(){
					if(adSlot.childElementCount > 3){
						close.className = "show";
						adSlot.style.height = '50px';
						close.addEventListener(clickEvent, function() {
							track('ad/close');
							adSlot.className += ' anim';
							setTimeout(function(){d.body.removeChild(adSlot);},800);
							w.removeEventListener('scroll', moveSlot);
						}, false);
						if(fixed){
							adSlot.style.position = 'fixed';
						}else{
							w.addEventListener('scroll', moveSlot, false);
						}
						return true;
					}
				};

				if(!adExist()) {
					var inter = setInterval(function() {
						if(!adExist() && i < 5) {
							i += 1;
						}else{
							d.body.removeChild(adSlot);
							clearInterval(inter);
						}
					}, 1000);
				}
			}
			//end of handling ads

			hideURLBar();

			//get search input

			//TODO: optimize selectors caching for this file
			body.delegate('.collSec', clickEvent, function(){
				var self = $(this);

				track(['section', self.hasClass('open')?'close':'open']);
				self.toggleClass('open').next().toggleClass('open');
			})
			.delegate('.goBck', clickEvent, function(){
				var parent = this.parentElement,
					prev = parent.previousElementSibling;

				parent.className = parent.className.replace(' open', '');
				prev.className = prev.className.replace(' open' , '');
				prev.scrollIntoView();
			})
			.delegate('#wkMainCnt a', clickEvent, function(){
				track('link/content');
			})
			//TODO: move to media.js
			.delegate('.infobox .image, figure, .wkImgStk', clickEvent, function(event){
				event.preventDefault();
				event.stopPropagation();
				var num = (this.attributes['data-num'] || this.parentElement.attributes['data-num']).value;

				if(num) media.openModal(num);
			});

			if(handledTables.length){
				if(!Modernizr.overflow){
					var key = 'wideTable' + wgStyleVersion,
						script = cache.get(key),
						ttl = 604800,//7days
						process = function(s){
							Wikia.processScript(s);
							body.delegate('.bigTable', touchEvent, function(event){
								if(!this.wkScroll) {
									this.wkScroll = new iScroll(this, onstop);
									this.className += ' active';
								}
							});
						};

					if(script){
						process(script);
					}else{
						Wikia.getMultiTypePackage({
							scripts: 'wikiamobile_scroll_js',
							ttl: ttl,
							callback: function(res){
								script = res.scripts[0];
								cache.set(key, script, ttl);
								process(script);
							}
						});
					}
				}else{
					body.delegate('.bigTable', touchEvent, function(){
						var wrapper = this;
						if(!wrapper.bigTable){
							var outerWidth = wrapper.clientWidth,
								width = wrapper.children[0].offsetWidth;

							wrapper.addEventListener('resize', function(){
								outerWidth = this.clientWidth;
								width = this.children[0].offsetWidth;
							});

							wrapper.addEventListener('scroll', function(ev){
								onstop(wrapper, ev.target.scrollLeft, (width - outerWidth));
							});

							wrapper.bigTable = true;
						}
					});
				}
			}

			$(d.getElementById('wkRelPag')).delegate('a', clickEvent, function(){
				track('link/related-page');
			});

			$(d.getElementById('wkArtCat')).delegate('a', clickEvent, function(){
				track('link/category');
			});

			d.getElementById('wkFllSite').addEventListener(clickEvent, function(event){
				event.preventDefault();
				track('link/fullsite');
				Wikia.CookieCutter.set('mobilefullsite', 'true');
				var url = qs();
				url.setVal('cb', wgStyleVersion);
				url.setVal('useskin', 'oasis');
				url.goTo();
			});

			//category pages
			//TODO: move to be loaded only on Category Pages
			if(wgCanonicalNamespace == 'Category'){
				$('.pagMore, .pagLess').bind(clickEvent, function(event) {
					event.preventDefault();
					var self = this,
						forward = (self.className.indexOf('pagMore') > -1),
						parent = self.parentElement,
						prev = (forward) ? parent.getElementsByClassName('pagLess')[0] : self,
						prevBatch = ~~(prev.getAttribute('data-batch')),
						next = (forward) ? self : parent.getElementsByClassName('pagMore')[0],
						nextBatch = prevBatch + 2,
						batch = (forward) ? nextBatch : prevBatch,
						add = (forward ? 1 : -1),
						id = parent.id,
						container = parent.getElementsByTagName('ul')[0];

					prev.setAttribute('data-batch', prevBatch + add);
					next.setAttribute('data-batch', nextBatch + add);

					loader.show(self, {size: '40px'});

					self.className += ' active';

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
							container.parentElement.removeChild(container);
							next.insertAdjacentHTML('beforebegin', result);

							if(forward) {
								parent.previousElementSibling.scrollIntoView();
								track('category/next');
							}else{
								track('category/prev');
							}

							loader.hide(self);

							prev.className = 'pagLess' + (batch > 1 ? ' visible' : '');
							next.className = 'pagMore' + (batch < ~~(parent.getAttribute('data-batches')) ? ' visible' : '');
						}
					});
				});

				var expAll = d.getElementById('expAll'),
					wkCatExh = d.getElementById('wkCatExh');

				if(expAll){
					var elements = $('.alphaSec .artSec, .alphaSec .collSec');
					expAll.addEventListener(clickEvent, function(event) {
						if($(this).toggleClass('exp').hasClass('exp')){
							elements.addClass('open');
							track('category/expandAll');
						}else{
							elements.removeClass('open');
							track('category/collapseAll');
						}
					});
				}

				if(wkCatExh){
					wkCatExh.addEventListener(clickEvent, function(event) {
						track('category/exhibition/click');
					});
				}
			}
			//end category pages

			if(wkShrPag){
				popover({
					on: wkShrPag,
					create: loadShare,
					open: function(){
						track('share/page/open');
					},
					close: function(){
						track('share/page/close');
					},
					style: 'right:0;'
				});
			}
		});
	});

	return {
		moveSlot: moveSlot,
		loadShare: loadShare,
	};
})();