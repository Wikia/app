var WikiaMobile = (function() {

	//as fast as possible to avoid screen flickering
	//document.documentElement.className += ' js';

	/** @private **/

	var body,
		page,
		article,
		handledTables,
		w = window,
		realWidth = w.innerWidth || w.clientWidth,
		realHeight = w.innerHeight || w.clientHeight,
		clickEvent = ('ontap' in w) ? 'tap' : 'click',
		touchEvent = ('ontouchstart' in w) ? 'touchstart' : 'mousedown',
		sizeEvent = ('onorientationchange' in w) ? 'orientationchange' : 'resize',
		tableWrapperHTML = '<div class="bigTable left">',
		adSlot,
		shrData,
		pageUrl = wgServer + wgArticlePath.replace('$1', wgPageName),
		shrImgTxt, shrPageTxt, shrMailPageTxt, shrMailImgTxt,
		$1 =/__1__/g, $2 =/__2__/g, $3 =/__3__/g, $4 = /__4__/g,
		fixed = Modernizr.positionfixed,
		d = document,
		ftr, navBar, wkPrf, wkLgn,

		querystring = function(url){
			var srh = '',
				location = w.location,
				cache = {},
				link = '',
				tmp,
				path = '',
				hash;

			if(url) {
				tmp = url.split('#');
				hash = tmp[1] || '';
				tmp = tmp[0].split('?');

				link = tmp[0];
				srh = tmp[1];
			}else{
				link = location.origin;
				path = location.pathname;
				srh = location.search.substr(1);
				hash = location.hash.substr(1)
			}

			if(srh){
				var tmpQuery = srh.split('&');

				for(var i = 0; i < tmpQuery.length; i++){
					tmp = tmpQuery[i].split('=');
					cache[tmp[0]] = tmp[1];
				}
			}

			return {
				toString: function(){
					var ret = link + path + '?',
						attr;
					for(attr in cache){
						ret += attr + '=' + cache[attr] + '&';
					}
					return ret.slice(0, -1) + (hash ? '#' + hash : '');
				},

				getVal: function(name, defVal){
					return cache[name] || defVal;
				},

				setVal: function(name, val){
					if(val != ''){
						cache[name] = val;
					}else{
						delete cache[name];
					}
				},

				getHash: function(){
					return hash;
				},

				setHash: function(h){
					hash = h;
				},

				getPath: function(){
					return path;
				},

				setPath: function(p){
					path = p;
				},

				goTo: function(){
					//We don't want these to be in url on load
					if(hash == 'pop' || hash == 'Modal'){
						hash = '';
					}
					w.location.href = this.toString();
				}
			};
		},

		loader = {
			show: function(elm, options) {
				options = options || {};
				var ldr = elm.getElementsByClassName('wkMblLdr')[0];
				if(ldr) {
					ldr.style.display = 'block';
				} else {
					elm.insertAdjacentHTML('beforeend', '<div class="wkMblLdr' + (options.center?' center':'') +'"><span ' +
								   (options.size?'style="width:' + options.size + ';height:'+options.size+'"':'') + '></span></div>');
				}
			},

			hide: function(elm) {
				elm = elm.getElementsByClassName('wkMblLdr')[0];
				if(elm){
					elm.style.display = 'none';
				}
			},

			remove: function(elm) {
				var ldr = elm.getElementsByClassName('wkMblLdr')[0];
				if(ldr){
					elm.removeChild(ldr);
				}
			}
		},

		toast = {
			wkTst: null,

			show: function(msg, opt){
				if(msg){
					opt = opt || {};

					var oTime = opt.timeout,
					time = (typeof oTime == 'undefined') ? 5000 : (typeof oTime == 'number' ? oTime : false);

					if(d.body.className.indexOf('hasToast') > -1){
						toast.wkTst.innerHTML = msg;
					}else{
						d.body.insertAdjacentHTML('beforeend', '<div id=wkTst class="hide clsIco">' + msg + '</div>' );
						toast.wkTst = d.getElementById('wkTst');
						toast.wkTst.addEventListener(clickEvent, function(){
							toast.hide();
						});
						d.body.className += ' hasToast';
					}
					toast.wkTst.className = 'show clsIco';

					if(opt.error){
						toast.wkTst.className += ' err';
					}

					if(time){
						setTimeout(function(){
							toast.hide();
						}, time);
					}
				}else{
					throw 'Empty message';
				}
			},

			hide: function(){
				toast.wkTst.className = 'hide clsIco';
			}
		};

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	function hideURLBar(){
		if(w.pageYOffset < 20) {
			setTimeout(function(){
					w.scrollTo(0, 1);
					if(!fixed) moveSlot();
			}, 0);
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
				w.addEventListener(sizeEvent, processTables, false);
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

	function getClickEvent(){
		return clickEvent;
	}

	function getTouchEvent(){
		return touchEvent;
	}

	function track(ev){
		WikiaTracker.track('/1_mobile/' + ((ev instanceof Array) ? ev.join('/') : ev), 'main.sampled');
	}

	function moveSlot(plus){
		adSlot.style.top = Math.min((w.pageYOffset + w.innerHeight - 50 + ~~plus), ftr.offsetTop + 150) + 'px';
	}

	function loadShare(cnt){
		require(['cache', 'media'], function(cache, media){
			var cacheKey = 'shareButtons' + wgStyleVersion;

			function handle(html){
				if(cnt.parentNode.id == 'wkShrPag'){
					cnt.innerHTML = html.replace($1, pageUrl).replace($2, shrPageTxt).replace($3, shrMailPageTxt).replace($4, shrPageTxt);

					$(cnt).delegate('li', clickEvent, function(){
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

	function openLogin(){
		if(wkPrf.className.indexOf('loaded') > -1){
			navBar.style.minHeight = (wkLgn.offsetHeight + 70) + 'px';
		}else{
			loader.show(wkPrf, {center: true});

			Wikia.getMultiTypePackage({
				templates: [{
					controllerName: 'UserLoginSpecialController',
					methodName: 'index'
				}],
				messages: 'fblogin',
				styles: '/extensions/wikia/UserLogin/css/UserLogin.wikiamobile.scss',
				scripts: 'userlogin_facebook_js_wikiamobile',
				params: {
					useskin: w.skin
				},
				callback: function(res){
					loader.remove(wkPrf);

					Wikia.processStyle(res.styles);
					wkPrf.insertAdjacentHTML('beforeend', res.templates['UserLoginSpecialController_index']);
					Wikia.processScript(res.scripts);

					wkLgn = document.getElementById('wkLgn');
					navBar.style.minHeight = (wkLgn.offsetHeight + 70) + 'px';
					wkLgn.style.opacity = 1;
					wkPrf.className += 'loaded';

					var form = wkLgn.getElementsByTagName('form')[0],
						query = querystring( form.getAttribute('action') );

					query.setVal('returnto', (wgCanonicalSpecialPageName && (wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/)) ? wgMainPageTitle : wgPageName));
					form.setAttribute('action', query.toString());
				}
			});
		}
		track('login/open');
	}

	function openProfile(){
		require('modal', function(modal){
			modal.close();
		});
		closeNav();
		hidePage();
		navBar.className = 'prf';
		window.location.hash = 'pop';
		navBar.style.height = '100%';

		if(wgUserName){
			track('profile/open');
		}else{
			openLogin();
		}
	}

	function hidePage() {
		page.style.height = 0;
		if(adSlot){
			adSlot.style.display = 'none';
		}
		ftr.style.display = 'none';
	}

	function closePullDown() {
		page.style.height = 'auto';
		if(adSlot){
			adSlot.style.display = 'block';
		}
		ftr.style.display = 'block';
		if(!fixed) moveSlot();
		navBar.style.height = '40px';
		navBar.style.minHeight = 0;
		closeNav();
		closeProfile();
		if(window.location.hash == "#pop") window.history.back();
	}

	function closeNav(){
		if(navBar.className.indexOf('fllNav') > -1){
			track('nav/close');
			wkNavMenu.className = 'cur1';
			navBar.className = '';
		}
	}

	function closeProfile(){
		if(navBar.className.indexOf('prf') > -1){
			if(wgUserName){
				track('profile/close');
			}else{
				track('login/close');
			}
			navBar.className = '';
		}
	}

	/*
	 * POPOVER
	 * create or/and open callback has to be provided to create pop over
	 *
	 * options.on - (required) element that opens popover - throws an exception if not provided
	 * options.style - allows you to pass cssText for a content wrapper
	 * options.create - content of popover, either string or function that gets content wrapper as an attribute
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
				if(this.className.indexOf('on') > -1){
					close(event);
				}else{
					if(!initialized){
						var position = options.position || 'bottom',
							horizontal = (position == 'bottom' || position == 'top'),
							offset = (horizontal)?this.offsetHeight:this.offsetWidth,
							onCreate = options.create,
							style = options.style || '';

						this.insertAdjacentHTML('afterbegin', '<div class=ppOvr></div>');
						cnt = this.getElementsByClassName('ppOvr')[0];

						if(typeof onCreate == 'function'){
							changeContent(onCreate);
						}else if(typeof onCreate == 'string'){
							cnt.insertAdjacentHTML('afterbegin', onCreate);
						}else if(!open){
							throw 'No content or on open callback provided';
						}

						this.className += ' ' + position;
						var pos = (horizontal)?(position == 'top'?'bottom':'top'):(position == 'left'?'right':'left');
						cnt.style[pos] = (offset + 15) + 'px';

						cnt.style.cssText += style;

						initialized = true;
					}

					open(event);
				}
			}, true);
		}else{
			throw 'Non existing element';
		}

		function changeContent(onCreate){
			cnt.innerHTML = '';
			loader.show(cnt, {center: true, size: '20px'});
			onCreate(cnt);
		}

		function close(ev){
			if(isOpen){
				elm.className = elm.className.replace(" on", "");
				if(typeof options.close == 'function') {
					 options.close(ev, elm);
				}
				isOpen = false;
			}
		}

		function open(ev){
			if(!isOpen){
				elm.className += " on";
				if(typeof options.open == 'function') {
					options.open(ev, elm);
				}
				isOpen = true;
			}
		}

		return {
			changeContent: changeContent,
			close: close
		}
	}

	function reloadPage(){
		var location = window.location.href,
			delim = '?';

		if(location.indexOf(delim) > 0){
			delim = '&';
		}

		window.location.href = location.split("#")[0] + delim + "cb=" + Math.floor(Math.random()*10000);
	}

	function onstop(el, x, max){
		var dir = 'bigTable active',
			middle = true;
		el.style.border = 'none';

		if(x < max - 5) {
			el.style.borderRight = '5px solid rgb(215,232,242)';
			middle = !middle;
		}

		if(x > 5) {
			el.style.borderLeft = '5px solid rgb(215,232,242)';
			middle = !middle;
		}


	}

	//init
	$(function(){
		require(['modal', 'media', 'cache'], function(modal, media, cache){
			body = $(d.body);
			page = d.getElementById('wkPage');
			article = d.getElementById('wkMainCnt');
			ftr = d.getElementById('wkFtr');
			adSlot = d.getElementById('wkAdPlc');
			navBar = d.getElementById('wkTopNav');
			wkPrf = d.getElementById('wkPrf');

			var navigationSearch = $(d.getElementById('wkNavSrh')),
			searchToggle = $(d.getElementById('wkSrhTgl')),
			searchInput = $(d.getElementById('wkSrhInp')),
			searchForm = $(d.getElementById('wkSrhFrm')),
			wkNav = d.getElementById('wkNav'),
			wkNavMenu = d.getElementById('wkNavMenu'),
			wikiNavHeader = wkNavMenu.getElementsByTagName('h1')[0],
			wikiNavLink = d.getElementById('wkNavLink'),
			wkPrfTgl = d.getElementById('wkPrfTgl'),
			lvl1 = d.getElementById('lvl1'),
			wkShrPag = d.getElementById('wkShrPag'),
			toc,
			//to cache link in wiki nav
			lvl2Link;

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
							window.removeEventListener('scroll', moveSlot);
						}, false);
						if(fixed){
							adSlot.style.position = 'fixed';
						}else{
							window.addEventListener('scroll', moveSlot, false);
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
			navigationSearch.remove().appendTo('#wkTopBar');

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

							wrapper.addEventListener(sizeEvent, function(){
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

			searchForm.bind('submit', function(){
				track('search/submit');
			});

			searchToggle.bind(clickEvent, function(event){
				event.preventDefault();
				if(navBar.className.indexOf('srhOpn') > -1){
					track('search/toggle/close');
					if(searchInput.val()){
						searchForm.submit();
					}else{
						navBar.className = '';
						searchInput.val('');
					}
				}else{
					track('search/toggle/open');
					closePullDown();
					navBar.className = 'srhOpn';
					navBar.style.height = '40px';
					searchInput.focus();
				}
			});

			//preparing the navigation
			wikiNavHeader.className = '';
			$(wkNavMenu).delegate('#lvl1 a', clickEvent, function(){
				track('link/nav/list');
			})
			.delegate('header > a', clickEvent, function(){
				track('link/nav/header');
			})
			.find('ul ul').parent().addClass('cld');

			d.getElementById('wkNavTgl').addEventListener(clickEvent, function(event){
				event.preventDefault();
				event.stopPropagation();
				if(navBar.className.indexOf('fllNav') > -1){
					closePullDown();
				}else{
					closeProfile();
					hidePage();
					track('nav/open');
					navBar.className = 'fllNav';
					navBar.style.minHeight = '100%';
					//80px is for lvl1 without header
					navBar.style.height = (lvl1.offsetHeight + 80) + 'px';
					window.location.hash = 'pop';
				}
			});

			//close WikiNav on back button
			if('onhashchange' in window) {
				window.addEventListener("hashchange", function() {
					if(window.location.hash == "" && navBar.className.length > 0){
						closePullDown();
					}
				}, false);
			}

			if(wkPrfTgl){
				wkPrfTgl.addEventListener(clickEvent, function(event){
					event.preventDefault();
					if(navBar.className.indexOf('prf') > -1){
						closePullDown();
					}else{
						openProfile();
					}
				});
			}

			$(lvl1).delegate('.cld', clickEvent, function(event) {
				if(event.target.parentNode.className.indexOf('cld') > -1) {
					event.stopPropagation();
					event.preventDefault();

					var self = $(this),
					element = self.children().first(),
					href = element.attr('href'),
					ul = self.find('ul').first().addClass('cur');

					wikiNavHeader.innerText = element.text();

					if(href) {
						wikiNavLink.href = href;
						wikiNavLink.style.display = 'block';
					}else{
						wikiNavLink.style.display = 'none';
					}

					//130px is for lvl2/3 with a header
					navBar.style.height = (ul.height() + 130) + 'px';

					if(wkNavMenu.className == 'cur1'){
						lvl2Link = href;
						track('nav/level-2');
						wkNavMenu.className = 'cur2';
					}else{
						track('nav/level-3');
						wkNavMenu.className = 'cur3';
					}
				}
			});

			d.getElementById('wkNavBack').addEventListener(clickEvent, function() {
				var current;

				if(wkNavMenu.className == 'cur2') {
					setTimeout(function(){wkNavMenu.querySelector('.lvl2.cur').className = 'lvl2'}, 800);
					navBar.style.height = (lvl1.offsetHeight + 80) + 'px';
					track('nav/level-1');
					wkNavMenu.className = 'cur1';
				} else {
					setTimeout(function(){wkNavMenu.querySelector('.lvl3.cur').className = 'lvl3'}, 800);
					current = wkNavMenu.querySelector('.lvl2.cur');
					wikiNavHeader.innerText = current.previousSibling.text;
					navBar.style.height = (current.offsetHeight + 130) + 'px';
					if(lvl2Link) {
						wikiNavLink.href = lvl2Link;
						wikiNavLink.style.display = 'block';
					} else {
						wikiNavLink.style.display = 'none';
					}
					track('nav/level-2');
					wkNavMenu.className = 'cur2';
				}
			});
			//end of preparing the nav

			page.addEventListener(clickEvent, function(event){
				navBar.className = '';
				searchInput.val('');
			});

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
				var url = querystring();
				url.setVal('cb', wgStyleVersion);
				url.goTo();
			});

			//category pages
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
				popOver({
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

			function scrollToElement(elm){
				var startY = w.scrollY,
					top = elm.offsetTop,
					by = ~~((startY / top) / 100),
					counter = 10,
					i = setInterval(function(){
						if(w.scrollY < top){
							scrollBy(0, by);
//							if(startY > (top - 300) && by >= 2){
//								if(!counter) {
//									by--;
//									counter = 5;
//								}
//								counter--;
//							}
						}else{
							elm.className += ' open';
							elm.nextElementSibling.className += ' open';
							clearInterval(i);
						}

					},5);
			}

			if(toc = d.getElementById('toc')){
				d.getElementById('toctitle').className += ' chev';
				toc.addEventListener(clickEvent, function(ev){
					var node = ev.target.parentNode;

					if(this.className.indexOf('open') > -1){
						this.className = this.className.replace(' open', '');
					}else{
						this.className += ' open';
					}

					if(node.nodeName == 'A'){
						ev.preventDefault();
						var id = node.getAttribute('href').substr(1),
							elm = d.getElementById(id);
						scrollToElement(elm);
					}
				})
			}
		});
	});

	return {
		openProfile: openProfile,
		getClickEvent: getClickEvent,
		getTouchEvent: getTouchEvent,
		track: track,
		moveSlot: moveSlot,
		popOver: popOver,
		loadShare: loadShare,
		reloadPage: reloadPage,
		querystring: querystring,
		loader: loader,
		toast: toast
	};
})();