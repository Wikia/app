window.trackClick = function(categoryVal, labelVal) {
	console.log('tracking');
	console.log(Wikia.Tracker);
	Wikia.Tracker.track( {
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: categoryVal,
		trackingMethod: 'ga',
		label: labelVal
	} );
}

////////////////////////////////////
/////////////////// LOCAL NAVIGATION
////////////////////////////////////
jQuery(function () {
	'use strict';
	var $navigation = jQuery('#WikiHeader'),
		svgChevron = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"' +
			' x="0px" y="0px" width="5px" height="9px" viewBox="0 0 5 9" ' +
			' enable-background="new 0 0 5 9" xml:space="preserve">' +
			' <polygon points="0.725,0 0,0.763 3.553,4.501 0,8.237 0.725,9 5,4.505 4.994,4.501 5,4.495"/> ' +
			' </svg>',
		isTouchDevice = function() {
			return 'ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch;
		};

// COLORS
	(function(){
		/*jshint multistr: true */
		var headerLinkColor = jQuery('.WikiHeader .nav-item:not(.marked) > a').css('color') || '#fff',
			headerBackgroundColor = jQuery('.WikiaPage .WikiaPageBackground').css('background-color') || '#000',
			linkColor = jQuery('.WikiHeader > nav li.marked > a').css('color') || '#fff',
			backgroundColor = jQuery('.WikiHeader > nav li.marked').css('background-color') || '#000',
			replaceAlpha = function(color, alpha) {
				if (color.indexOf('rgba') === 0){
					return color.replace(/[^,]+(?=\))/, alpha);
				} else {
					return color.replace('rgb','rgba').replace(')', ',' + alpha + ')');
				}
			},
			css = '.WikiHeaderV2 { \
background: $header-color-global; \
padding-top: 66px; \
} \
.WikiHeaderV2 .wordmark.text a { \
color: $header-color-link-primary; \
} \
\
.WikiNavV2 .nav-item > a { \
background: transparent; \
color: $header-color-link-primary; \
} \
.WikiNavV2 .nav-item > a:hover, .WikiNavV2 .nav-item > a:active { \
background: $header-color-background; \
color: $header-color-link; \
} \
.WikiNavV2 .nav-item:hover > a, .WikiNavV2 .nav-item:active > a, .WikiNavV2 .nav-item.active > a { \
background: $header-color-background; \
color: $header-color-link; \
} \
.WikiNavV2 .nav-item .submenu { \
background: $header-color-background; \
color: $header-color-link; \
} \
.WikiNavV2 .nav-item .submenu .subnav-2a svg polygon { \
fill: $header-color-link; \
opacity: .5; \
} \
.WikiNavV2 .nav-item .submenu .see-all { \
border-top: 1px solid $header-color-link-with-alpha; \
} \
.WikiNavV2 .nav-item .submenu .see-all svg polygon { \
fill: $header-color-link; \
opacity: .5; \
} \
'.replace(/\$header-color-global/g, headerBackgroundColor)
				.replace(/\$header-color-link-primary/g, headerLinkColor)
				.replace(/\$header-color-link-with-alpha/g, replaceAlpha( linkColor, '.2' ) )
				.replace(/\$header-color-link/g, linkColor)
				.replace(/\$header-color-background/g, backgroundColor),
			head = document.head || document.getElementsByTagName('head')[0],
			style = document.createElement('style');

		style.type = 'text/css';
		if (style.styleSheet){
			style.styleSheet.cssText = css;
		} else {
			style.appendChild(document.createTextNode(css));
		}

		head.appendChild(style);
	})();

// NAVIGATION

	jQuery('.WikiaPageHeader').addClass('WikiaPageHeaderV2');
	$navigation.detach();
	$navigation.find('.buttons').hide();
	$navigation.find('.WikiHeaderSearch').hide();
	$navigation.removeClass('WikiHeader').addClass('WikiHeaderV2');
	$navigation.find('.WikiNav').removeClass('WikiNav').addClass('WikiNavV2');
	$navigation.find('.accent').removeClass('accent');
	$navigation.find('.marked').removeClass('marked');
	$navigation.find('.chevron').remove();
	$navigation.find('> nav').unbind();

	$navigation.find('.nav-item').each(function () {
		var $this = jQuery(this),
			$seeAll = $this.find('> a').clone(),
			$subNav = $this.find('.subnav-2'),
			$items = $subNav.children(),
			noOfItems = $items.length,
			submenuClasses = 'submenu',
			seeAllText = (noOfItems > 1) ? ('See all in ' + $seeAll.text()) : 'See all',
			$columns = jQuery(),
			$columnUl,
			columnsCount = 0,
			i = 0;

		$items.find('.subnav-2a').append(svgChevron);
		if (noOfItems === 3) {
			submenuClasses += ' submenu-wide';
		} else if (noOfItems > 3) {
			submenuClasses += ' submenu-full';
		} else {
			submenuClasses += ' submenu-width-' + noOfItems;
			$this.addClass('nav-item-narrow');
		}

		$subNav.wrap('<section class="' + submenuClasses + '"></section>')
			.parent().append($('<div class="clearfix"></div>'));

		if ($seeAll.attr('href') !== '#') {
			$subNav.parent().append($seeAll.html(seeAllText + svgChevron)
				.wrap('<section class="see-all"></section>').parent());
		} else {
			$this.addClass('no-see-all');
		}

		columnsCount = Math.min(4, $items.length);
		for (i = 0; i < columnsCount; i++) {
			$columnUl = $('<ul class="subnav-2-column">');
			$columnUl.append($items.get(i));
			$columnUl.append($items.get(i + 4));

			$columns = $columns.add(jQuery('<li class="subnav-2-column-wrapper">').append($columnUl));
		}
		$subNav.append($columns);
	});

	$navigation.children().wrapAll('<section class="local-navigation-container"></section>');
	$navigation.insertAfter('#WikiaHeader');

// touch devices
	if (isTouchDevice()) {
		jQuery('.nav-item > a').on('click', function(e){
			e.preventDefault();
//jQuery('.nav-item').removeClass('active');
//jQuery(this).addClass('active');
		});
	}

// tracking
	window['optimizely'] = window['optimizely'] || [];
	jQuery('.nav-item').on('mouseenter', function (e) {
		window.optimizely.push(['trackEvent', 'nav-item_hover']);
		window.trackClick('wiki-nav', 'nav-item_hover');
	});

	$navigation.on('mousedown', 'a', function(e) {

		var label,
			el = $(e.target);

// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		if (el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if (el.closest('.WikiNavV2').length > 0) {
			var canonical = el.data('canonical');
			if (canonical !== undefined) {
				switch(canonical) {
					case 'wikiactivity':
						label = 'on-the-wiki-activity';
						break;
					case 'random':
						label = 'on-the-wiki-random';
						break;
					case 'newfiles':
						label = 'on-the-wiki-new-photos';
						break;
					case 'chat':
						label = 'on-the-wiki-chat';
						break;
					case 'forum':
						label = 'on-the-wiki-forum';
						break;
					case 'videos':
						label = 'on-the-wiki-videos';
						break;
				}
			} else if (el.parent().hasClass('nav-item')) {
				label = 'custom-level-1';
			} else if (el.parent().hasClass('see-all')) {
				label = 'custom-level-1';
			} else if (el.hasClass('subnav-2a')) {
				label = 'custom-level-2';
			} else if (el.hasClass('subnav-3a')) {
				label = 'custom-level-3';
			}
		}

		if (label !== undefined) {
			window.optimizely.push(['trackEvent', label + '_clicks']);
			window.trackClick('wiki-nav', label);
		}
	});
});

jQuery(function(){
	'use strict';

	require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana' ], function ($, uiFactory, nirvana) {

		var menuPromise = nirvana.sendRequest({
				controller: 'GlobalHeaderController',
				method: 'getGlobalMenuItems',
				format: 'json',
				type: 'GET'
			}),
			hamburgerButton = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 44 66" enable-background="new 0 0 44 66" xml:space="preserve" width="100%" height="100%"><rect x="0" id="rect5" height="3" width="28" y="27" /><rect x="0" id="rect7" height="2.9690001" width="28" y="33" /><polygon id="polygon9" points="28,41.969 0,41.963 0,39.031 28,39.031 " /><polygon id="svg-chevron" points="44,33.011 39,38 34,33.011 " /></svg>',
			hubsIconsHover = {
				books: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3" style="fill:#e76400;" /><path fill="#FFFFFF" d="M14.798,17.538h-3.985v18.669c0,0,5.239-0.732,12.839,2.106c0,0-1.752-2.069-4.464-3.176   c-2.793-1.033-4.335-1.457-4.335-1.457L14.798,17.538z" id="path7" /><path fill="#FFFFFF" d="M24.981,17.919c0,0-3.394-3.037-7.748-2.447v17.523c0,0,5.018,1.293,7.748,4.097V17.919z" id="path9" /><path fill="#FFFFFF" d="M37.577,17.454h3.985v18.669c0,0-5.239-0.732-12.839,2.106c0,0,1.752-2.069,4.464-3.176   c2.793-1.033,4.335-1.457,4.335-1.457L37.577,17.454z" id="path11" /><path fill="#FFFFFF" d="M27.394,17.835c0,0,3.394-3.037,7.748-2.447v17.523c0,0-5.018,1.293-7.748,4.097V17.835z" id="path13" /></svg>',
				comics: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3016" style="fill:#e1390b" /><path fill="#FFFFFF" d="M26,13.504c-7.732,0-14,5.535-14,12.363s6.268,12.363,14,12.363c1.045,0,2.059-0.109,3.039-0.301  l-0.606,3.713l4.05-4.824C36.949,34.753,40,30.628,40,25.867C40,19.039,33.732,13.504,26,13.504z M26.114,32.308  c-0.031,0.092-0.089,0.201-0.176,0.328c-0.087,0.127-0.193,0.244-0.32,0.351c-0.128,0.107-0.28,0.198-0.458,0.275  c-0.178,0.076-0.379,0.114-0.603,0.114c-0.478,0.01-0.885-0.117-1.22-0.381c-0.336-0.264-0.493-0.641-0.473-1.129  c0.011-0.213,0.064-0.414,0.16-0.602c0.097-0.188,0.237-0.346,0.42-0.473c0.183-0.127,0.404-0.208,0.664-0.244  c0.259-0.035,0.551-0.007,0.877,0.084c0.275,0.071,0.498,0.175,0.671,0.313c0.173,0.137,0.3,0.288,0.381,0.45  c0.082,0.163,0.125,0.325,0.13,0.488C26.172,32.044,26.154,32.186,26.114,32.308z M29.057,20.931  c-0.265,0.763-0.526,1.535-0.786,2.318c-0.259,0.783-0.509,1.555-0.747,2.318c-0.239,0.763-0.458,1.497-0.656,2.204  c-0.199,0.707-0.374,1.365-0.527,1.975c-0.051,0.214-0.13,0.346-0.236,0.397c-0.107,0.051-0.277,0.046-0.511-0.015  c-0.285-0.051-0.547-0.114-0.786-0.191c-0.239-0.076-0.47-0.17-0.694-0.282c-0.234-0.122-0.389-0.257-0.465-0.404  c-0.076-0.147-0.089-0.368-0.038-0.663c0.082-0.59,0.196-1.283,0.344-2.082c0.147-0.798,0.313-1.619,0.496-2.463  c0.183-0.844,0.371-1.678,0.564-2.501c0.193-0.824,0.376-1.561,0.549-2.211c0.082-0.315,0.201-0.508,0.359-0.58  c0.158-0.071,0.399-0.051,0.724,0.061c0.305,0.082,0.638,0.198,0.999,0.351c0.361,0.153,0.674,0.32,0.938,0.503  c0.275,0.193,0.445,0.384,0.511,0.572C29.161,20.426,29.149,20.657,29.057,20.931z" id="path3018" /></svg>',
				games: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3038" style="fill:#76bf06" /><path fill="#FFFFFF" d="M41.474,26.988c-0.408-3.1-1.413-5.988-3.323-8.519c-1.296-1.717-2.998-2.756-5.253-2.674   c-1.593,0.058-3.021,0.63-4.316,1.514c-0.653,0.445-1.343,0.697-2.141,0.669c-0.333-0.012-0.667-0.005-1,0.015   c-0.755,0.046-1.428-0.158-2.05-0.573c-0.685-0.457-1.431-0.794-2.218-1.045c-2.78-0.884-5.212-0.174-7.046,2.055   c-0.433,0.526-0.798,1.095-1.126,1.687c-1.989,3.599-2.607,7.458-2.248,11.494c0.087,0.975,0.211,1.953,0.581,2.875   c0.506,1.261,1.515,1.863,2.808,1.695c0.61-0.079,1.091-0.42,1.556-0.772c1.469-1.112,2.699-2.459,3.88-3.85   c0.515-0.606,1.144-0.898,1.942-0.904c1.549-0.012,3.098-0.044,4.647-0.068c1.098-0.017,2.196-0.029,3.294-0.051   c2.702-0.055,2.422-0.113,4.155,1.713c1.148,1.21,2.324,2.407,3.81,3.233c1.344,0.747,2.837,0.269,3.525-1.088   c0.193-0.382,0.311-0.787,0.389-1.205C41.723,31.13,41.746,29.06,41.474,26.988z M21.878,25.09h-2.389v2.389h-2.314V25.09h-2.389   v-2.314h2.389v-2.389h2.314v2.389h2.389V25.09z M32.304,23.052c-0.896-0.003-1.652-0.729-1.671-1.603   c-0.019-0.904,0.73-1.657,1.659-1.669c0.927-0.012,1.7,0.728,1.701,1.626C33.995,22.304,33.225,23.054,32.304,23.052z M36.185,26.6   c-0.927,0.019-1.692-0.707-1.703-1.616c-0.01-0.895,0.694-1.619,1.604-1.65c0.944-0.032,1.704,0.663,1.73,1.581   C37.842,25.826,37.112,26.581,36.185,26.6z" id="path3042" /></svg>',
				lifestyle: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3064" style="fill:#ffad00" /><circle style="fill:#FFFFFF;fill-opacity:1;" cx="25.97" cy="26.786" r="7.784" id="circle3068" /><polygon fill="#FFFFFF" points="16.265,28.724 16.265,24.764 10.853,26.81  " id="polygon3070" /><polygon fill="#FFFFFF" points="35.735,24.764 35.735,28.724 41.147,26.678  " id="polygon3072" /><polygon fill="#FFFFFF" points="27.95,36.479 23.99,36.479 26.036,41.891  " id="polygon3074" /><polygon fill="#FFFFFF" points="23.99,17.009 27.95,17.009 25.904,11.597  " id="polygon3076" /><polygon fill="#FFFFFF" points="20.516,35.028 17.716,32.228 15.336,37.501  " id="polygon3078" /><polygon fill="#FFFFFF" points="31.484,18.461 34.284,21.261 36.664,15.987  " id="polygon3080" /><polygon fill="#FFFFFF" points="34.284,32.228 31.484,35.028 36.757,37.408  " id="polygon3082" /><polygon fill="#FFFFFF" points="17.716,21.261 20.516,18.461 15.243,16.08  " id="polygon3084" /></svg>', movies: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3122" style="fill:#09b3a6" /><rect x="15.474" y="24.419" fill="#FFFFFF" width="22.041" height="14.13" id="rect3126" /><polygon fill="none" points="18.544,16.552 18.672,16.309 18.665,16.31   " id="polygon3130" /><polygon fill="#FFFFFF" points="36.116,12.597 33.18,18.774 37.15,17.929   " id="polygon3132" /><polygon fill="#FFFFFF" points="18.544,16.552 18.665,16.31 18.672,16.309 18.672,16.309 14.516,17.193 15.549,22.525     18.543,16.552 18.543,16.552   " id="polygon3134" /><polygon fill="#FFFFFF" points="21.8,15.643 21.816,15.64 18.879,21.816 22.699,21.004 25.815,14.789 21.8,15.643   " id="polygon3136" /><polygon fill="#FFFFFF" points="26.029,20.295 29.849,19.482 32.965,13.268 28.966,14.119   " id="polygon3138" /><polygon fill="#27AAE1" points="18.543,16.552 18.543,16.552 18.544,16.552   " id="polygon3140" /></svg>',
				music: '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3176" style="fill:#981093" /><path fill="#FFFFFF" d="M37.995,20.518c-2.802-8.22-11.882-8.499-12.016-8.501c-0.092,0.002-9.173,0.281-11.974,8.501   c-2.57,7.541,0.533,11.894,1.108,12.613c-0.037,0.406-0.041,0.847,0.008,1.342c0.443,4.419,4.424,4.544,4.424,4.544l-1.456-9.67   c0,0-1.186,0.253-2.068,1.364c-0.776-1.592-1.688-4.789-0.072-9.53c2.332-6.841,9.759-7.102,10.03-7.109   c0.077,0.002,7.729,0.236,10.072,7.109c1.542,4.526,0.782,7.636,0.035,9.294c-0.851-0.912-1.868-1.128-1.868-1.128l-1.456,9.67   c0,0,3.981-0.125,4.424-4.544c0.065-0.646,0.04-1.203-0.037-1.7C38.061,31.443,40.291,27.257,37.995,20.518z" id="path3180" /><rect x="16.849" y="32.677" transform="matrix(-0.1503 -0.9886 0.9886 -0.1503 -8.2444 60.258)" fill="#FFFFFF" width="9.85" height="1.99" id="rect3182" /><rect x="29.537" y="28.747" transform="matrix(-0.9886 -0.1503 0.1503 -0.9886 55.6589 71.5493)" fill="#FFFFFF" width="1.99" height="9.85" id="rect3184" /></svg>',
				tv: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" width="100%" height="100%"><circle cx="26" cy="26" r="25" id="circle3210" style="fill:#008cce;" /><path fill="#FFFFFF" d="M13.5,15.977v18.463h25V15.977H13.5z M36.334,30.6H15.665V18.087h20.669V30.6z" id="path3216" /><rect x="22.232" y="36.619" fill="#FFFFFF" width="7.536" height="4.358" id="rect3218" /></svg>'
			},
			$globalNavigationNav,
			initialize = function() {
				$('#GlobalNavigation').remove();
				$('<li id="GlobalNavigationMenuButton">' + hamburgerButton + '</li>').insertBefore('li.WikiaLogo');
				$('<div class="GlobalNavigationContainer"><nav><div class="hubs"></div></nav></div>').insertAfter('.WikiaHeader');
				$('.GlobalNavigationContainer').css('position', 'fixed');
				$globalNavigationNav = $('.GlobalNavigationContainer nav');
			},
			buildMenu = function(verticalData) {
				var $hubsMenu = $globalNavigationNav.find('.hubs' ),
					active = verticalData.active || verticalData.menu[0].specialAttr;

				$globalNavigationNav.addClass('count-' + verticalData.menu.length).data('active', active);

				$.each(verticalData.menu, function() {
					var $elem = $('<nav class="' + this.specialAttr + ' hub"><span class="icon" />' +
						'<span class="label" /></nav>');

					$elem.data('submenus', this.children)
						.find('.label').text(this.text).end()
						.find('.icon').html(hubsIconsHover[this.specialAttr]).end()
						.appendTo($hubsMenu);
				});

				$globalNavigationNav
					.append('<section data-submenu="0" />')
					.append('<section data-submenu="1" />');
			},
			attachEvents = function() {
				var $hub = $globalNavigationNav.find('.hub'),
					submenu0 = $globalNavigationNav.find('[data-submenu=0]')[0],
					submenu1 = $globalNavigationNav.find('[data-submenu=1]')[0],
					isOpen = false,
					$WikiaHeader = $('#WikiaHeader'),
					openHub = function() {
						$globalNavigationNav.find('.hub.' + $globalNavigationNav.data('active')).mouseenter();

						$('#GlobalNavigationMenuButton').addClass('active');
						$('.GlobalNavigationContainer').show();

						window.trackClick('top-nav', 'hamburger_entry_point_clicks');
						window.optimizely.push(['trackEvent', 'hamburger_entry_point_clicks']);

						isOpen = true;
					}, closeHub = function() {
						$('#GlobalNavigationMenuButton').removeClass('active');
						$('.GlobalNavigationContainer').hide();

						isOpen = false;
					}, toggleHub = function() {
						if (isOpen) {
							closeHub();
						} else {
							openHub();
						}
					};

				$globalNavigationNav.on('mouseenter', '.hub', function(e) {
					e.preventDefault();
					$hub.removeClass('active');

					window.trackClick('top-nav', 'hub_menu_opens');
					window.optimizely.push(['trackEvent', 'hub_menu_opens']);

					var $this = $(this),
						submenus = $this.data('submenus'),
						html = ['', ''],
						column = 0;

					$this.addClass('active');

					$.each(submenus, function(i) {
						column = Math.floor(i / 2);
						html[column] += '<h2>' + this.text + '</h2><ul>';
						$.each(this.children, function() {
							html[column] += '<li><a href="' + this.href + '">' +  this.text + '</a></li>';
						});
						html[column] += '</ul>';
					});
					submenu0.innerHTML = html[0];
					submenu1.innerHTML = html[1];
				});

				if (navigator.userAgent.toLowerCase().indexOf('android') === -1 &&
					navigator.userAgent.toLowerCase().indexOf('ipad') === -1) {
					$globalNavigationNav.on('mouseleave', function() {
						closeHub();
					});

					$WikiaHeader.on('mouseenter', '#GlobalNavigationMenuButton', function(e) {
						e.preventDefault();
						openHub();
					});
				}

				$globalNavigationNav.on('mousedown', 'section a', function(){
					window.trackClick('top-nav', 'hubs_subitem_clicks');
					window.optimizely.push(['trackEvent', 'hubs_subitem_clicks']);
				});

				$WikiaHeader.on('click', '#GlobalNavigationMenuButton', function(e) {
					e.preventDefault();
					toggleHub();
				});

				$('body').on('click', function(e) {
					if (isOpen && !$(e.target).parents('.GlobalNavigationContainer').length && !$(e.target).parents('#GlobalNavigationMenuButton').length) {
						closeHub();
					}
				});
			};

		$.when(menuPromise).done(function(verticalMenuData) {
			initialize();
			buildMenu(verticalMenuData);
			attachEvents();
		});
	});
});

window.removedFromHoverMenu = false;

$(function(){
	'use strict';

	var $ = jQuery,
		$accountNavigation = $( '#AccountNavigation' ),
		$arrow = $( '<svg width="21" height="17" class="light search-arrow" xmlns="http://www.w3.org/2000/svg"><polygon points="0,5.66 9.0,5.66 9,0 20.5,8.5 9,17 9,11.33 0,11.33" /></svg>' ),
		$avatar = $accountNavigation.find( 'li:first .avatar' ),
		$avatarLink = $( '#AccountNavigation > li:first > a' ),
		avatarSize = 36,
		$loginDropdown = $accountNavigation.find( '#UserLoginDropdown'),
		$accountNavsubnav = $accountNavigation.find('.subnav'),
		$bubblesNotifications,
		$bubblesNavigation,
		$wallNotifications,
		$notifications,
		searchLocalText = 'This wikia',
		searchGlobalText = 'All of Wikia',
		$searchPageInput = $( '#search-v2-input' ),

	// building search
		$globalSearch = $( '<li>' ).addClass( 'global-search' ),
		localSearchUrl = window.location.origin + "/wiki/Special:Search",
		$form = $( '<form>' )
			.addClass( 'search-form' )
			.attr( 'method', 'get' )
			.attr( 'action', localSearchUrl )
			.submit( function() {
				var formAction = {
						'local': localSearchUrl,
						'global': window.wgGlobalSearchUrl
					},
					searchType = $( this ).find( 'select' ).val();
				$( this ).attr( 'action', formAction[ searchType ] );

				// Optimizely event tracking
				if ( searchType === 'global' ) {
					window.trackClick('top-nav', 'global_search_submits');
					window.optimizely.push( [ 'trackEvent', 'global_search_submits' ] );
				} else {
					window.trackClick('top-nav', 'local_search_submits');
					window.optimizely.push( [ 'trackEvent', 'local_search_submits' ] );
				}
			} ),
		$selectWrapper = $( '<div>' )
			.addClass( 'search-select-wrapper' ),
		$selectChevron = $( '<svg width="10" height="5" class="light search-chevron" xmlns="http://www.w3.org/2000/svg"><polygon points="10,0 5,5 0,0" /></svg>' )
			.appendTo( $selectWrapper ),
		$select = $( '<select>' )
			.attr( 'id', 'search-select' )
			.addClass( 'cursor-pointer' ),
		$selectSpan = $( '<span>' )
			.text( searchLocalText ),
		$searchInput = $( '<input>' )
			.addClass( 'search-box' )
			.attr( 'type', 'text' )
			.attr( 'accesskey', 'f' )
			.attr( 'autocomplete', 'off' )
			.attr( 'name', 'search' )
			//TODO i18n
			.attr( 'placeholder', 'Characters, history, quests...' );

	$( '<option>' )
		.val( 'local' )
		.text( searchLocalText )
		.attr( 'selected', 'selected' )
		.appendTo( $select );

	$( '<option>' )
		.val( 'global' )
		.text( searchGlobalText )
		.appendTo( $select );

	$select.appendTo( $selectWrapper );

	$( '<svg width="19" height="19" class="dark" xmlns="http://www.w3.org/2000/svg"><path transform="scale(1.2) translate(0.5,0.5)" stroke-linejoin="null" stroke-linecap="null" d="m14.8613,12.88892l-3.984008,-3.983988c0.536782,-0.885019 0.851497,-1.920426 0.852106,-3.030754c0,-3.238203 -2.622357,-5.861736 -5.860845,-5.862835c-3.237258,0.0011 -5.860767,2.624632 -5.860767,5.8625c0,3.236496 2.623743,5.859635 5.861367,5.859635c1.110886,0 2.146293,-0.314714 3.031312,-0.851395l3.985085,3.984516l1.97575,-1.97768l0,0zm-12.617637,-7.015077c0.003362,-2.00262 1.623002,-3.621701 3.625063,-3.626171c2.000933,0.00447 3.621701,1.623551 3.625053,3.626171c-0.003911,2.001492 -1.62412,3.620584 -3.625053,3.625053c-2.002386,-0.004735 -3.622219,-1.623337 -3.625063,-3.625053z" /></svg>' )
		.appendTo( $selectWrapper );

	$selectSpan.appendTo( $selectWrapper );

	$selectWrapper.appendTo( $form );

	$searchInput.appendTo( $form );

	$( '<input>' )
		.attr( 'type', 'hidden' )
		.attr( 'name', 'resultsLang')
		.val( window.wgUserLanguage )
		.appendTo( $form );

	$( '<input>' )
		.attr( 'type', 'hidden' )
		.attr( 'name', 'fulltext')
		.val( 'Search' )
		.appendTo( $form );

	// setting the searched phrase as the global header search input value
	if ( $searchPageInput.length > 0 && $searchPageInput.val() !== '' ) {
		$searchInput.val( $searchPageInput.val() );
		$arrow.attr( 'class', 'dark search-arrow' );
	}

	// removing in-page search boxes
	$( '#HeaderWikiaSearch' ).remove();
	$( '#WikiaSearch' ).remove();
	$('.wikinav2.oasis-one-column .WikiaMainContentContainer .WikiaPageHeader .tally').css('right', 0);

	// adding behaviour
	$( '<button type="submit">' )
		.focus( function() {
			$arrow.attr( 'class', 'dark search-arrow' );
		} )
		.blur( function() {
			if ( $searchInput.val() === '' ) {
				$arrow.attr( 'class', 'light search-arrow' );
			}
		} )
		.append( $arrow )
		.appendTo( $form );

	$select
		.on('change keyup', function() {
			$selectSpan.text( $( '#search-select' ).find( 'option:selected' ).text() );
		})
		.focus( function() {
			$selectChevron.attr( 'class', 'dark search-chevron' );
		} )
		.blur( function() {
			$selectChevron.attr( 'class', 'light search-chevron' );
		} )
		.change( function() {
			$searchInput.focus();
		} );

	$searchInput
		.focus( function() {
			$arrow.attr( 'class', 'dark search-arrow' );
		} )
		.blur( function() {
			if ( $searchInput.val() === '' ) {
				$arrow.attr( 'class', 'light search-arrow' );
			}
		} );

	$globalSearch.append( $form );

	$( '#WikiaHeader' ).find( '.WikiaLogo' ).after( $globalSearch );

	$('.WikiaHeader')
		.addClass('v3')
		.css({
			'position' : 'fixed',
			'width' : '100%'
		});
	$avatarLink.contents().filter(function() { return this.nodeType === 3; }).wrap( '<span class="login-text">' );
	$accountNavigation.find( '.login-text' ).hide();

	if ( $avatar.length > 0 ) {
		$avatar.attr( 'src', $avatar.attr( 'src' ).replace( '/20px-', '/' + avatarSize + 'px-' ) )
			.attr( 'height', avatarSize)
			.attr( 'width', avatarSize );
	}

	if (window.wgUserName !== null) {
		$wallNotifications = $( '#WallNotifications');
		if(!$wallNotifications.hasClass('prehide')) {
			$notifications = $('<li class="notificationsEntry"><a href="#"><span id="bubbles_count"></span>Notifications</a></li>');

			$accountNavigation.on('mouseover', '.notificationsEntry', function(){
				$('.subnav', $wallNotifications).addClass('show');
				window.trackClick('top-nav', 'notifications_menu_opens');
				window.optimizely.push(['trackEvent', 'notifications_menu_opens']);

			});

			$accountNavigation.on('mouseover', function(){
				if( !window.removedFromHoverMenu ) {
					$bubblesNotifications = $('.notificationsEntry #bubbles_count');
					$bubblesNavigation = $('.bubbles #bubbles_count');
					removeWallNotificationsFromHoverMenu();
					window.removedFromHoverMenu = true;
				}
				$bubblesNotifications.text($bubblesNavigation.text());
			});

			$accountNavigation.on('mouseleave', '.notificationsEntry', function(){
				$('.subnav', $wallNotifications).removeClass('show');
			});



			$avatarLink.append($('.bubbles'));
			$notifications.append($wallNotifications);
			$accountNavsubnav.prepend($notifications);
		} else {
			$wallNotifications.hide();
			$accountNavigation.on('mouseover', function(){
				if( !window.removedFromHoverMenu ) {
					removeWallNotificationsFromHoverMenu();
					window.removedFromHoverMenu = true;
				}
			});
		}

		$accountNavigation.on('mouseleave', function(){
			$('>li >.subnav', $accountNavigation).removeClass('show');
		});
	}

	$accountNavigation.on('mouseenter', function(){
		window.trackClick('top-nav', 'login_dropdown_opens');
		window.optimizely.push(['trackEvent', 'login_dropdown_opens']);
	});

	$accountNavsubnav.find( '.new' ).removeClass( 'new' );
	$accountNavigation.find( '.ajaxRegister' ).wrap( '<div class="ajaxRegisterContainer"></div>' ).parent().prependTo( '#UserLoginDropdown' );
	$accountNavigation.on('mousedown', '.ajaxRegister', function() {
		window.trackClick('top-nav', 'signup_clicks');
		window.optimizely.push(['trackEvent', 'signup_clicks']);
	});

	if ( $loginDropdown.length > 0 || $avatar.attr( 'src' ).indexOf( '/Avatar.jpg' ) > -1 ) {
		$avatar.remove();
		$accountNavigation.find( 'a:first' ).prepend(
			'<div class="avatarContainer"><svg class="avatar" width="' + avatarSize + '" height="' + avatarSize + '" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve"><rect x="0" y="0" width="36" height="36"/><path fill="#FFFFFF" d="m 30.2 27.7 c -2.7 -1.5 -6.3 -3.1 -8.5 -4.3 4.3 -5.4 3.6 -17.3 -3.6 -17.6 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -9 1.6 -7 13.3 -3.6 17.6 -2.2 1.2 -5.8 2.8 -8.5 4.3 6.5 7.9 18.4 7.7 24.4 0 z"/></svg></div>'
		);
	}

	$loginDropdown.find( 'input[type="text"], input[type="password"]' ).each(function() {
		var $input = $( this );
		$input.attr( 'placeholder', $input.prev().hide().text() );
	});


	function removeWallNotificationsFromHoverMenu() {
		var hoverMenus = window.HoverMenuGlobal.menus,
			menu;
		for(menu in hoverMenus) {
			if (hoverMenus.hasOwnProperty(menu)) {
				if(hoverMenus[menu].selector === '#AccountNavigation') {
					hoverMenus[menu].menu.off('focus', '.subnav a');
					hoverMenus.splice(menu,1);
				}
				if(hoverMenus[menu].selector === '#WallNotifications') {
					hoverMenus[menu].menu.off('focus', '.subnav a');
					hoverMenus[menu].menu.off('mouseenter','> li', hoverMenus[menu].mouseover);
					hoverMenus[menu].menu.off('mouseleave','> li', hoverMenus[menu].mouseout);
					hoverMenus.splice(menu,1);
				}
			}
		}
	}


	// global nav cleanup/replace
	(function(){
		var $startAWiki = $('.start-a-wiki a');
		var $wikiaLogo = $('.WikiaLogo a');

		$wikiaLogo.html('<svg version="1.1" class="svglogo" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 217.8 60" enable-background="new 0 0 217.8 60" xml:space="preserve"><path d="M100.6,58.8V0h13.2v33l3.5-4.4l7.4-8.8h18.9L128,35.2l16.5,23.7h-17.2l-9-14.9l-4.6,4.3v10.5H100.6z M51.8,20.1l-5,26.4l-6.4-26.4h-6h-0.3h-2.7h-0.3h-6l-6.4,26.4l-5-26.4H0l10.1,38.8h17.7l5-20.4l5,20.4h17.7l10.1-38.8H51.8z M217.1,47.5l0.7,11.3h-12.1l-0.9-4.2c-2.8,2.9-6.2,5.4-12.3,5.4c-11,0-17-7.1-17-20.6c0-13.5,6-20.6,17-20.6c6.1,0,9.5,2.4,12.3,5.4l0.9-4.2h12.1l-0.7,11.3V47.5z M203.9,34.4c-1.7-2.2-4.3-3.7-7.8-3.7c-4,0-7.1,2.6-7.1,8.7c0,6.1,3.2,8.7,7.1,8.7c3.5,0,6.1-1.5,7.8-3.7V34.4zM79.8,0.2c-4.2,0-7.6,3.4-7.6,7.6c0,4.2,3.4,7.6,7.6,7.6c4.2,0,7.6-3.4,7.6-7.6C87.4,3.6,84,0.2,79.8,0.2 M91.2,27.8v-8.3h-5.7H72.2v13.4v12.5v13.1v0.3h19v-8.2h-5.9V27.8H91.2z M153.7,7.8c0,4.2,3.4,7.6,7.6,7.6c4.2,0,7.6-3.4,7.6-7.6c0-4.2-3.4-7.6-7.6-7.6C157.1,0.2,153.7,3.6,153.7,7.8 M155.8,27.8v22.8h-5.9v8.2h19v-0.3V45.4V32.9V19.5h-13.2h-5.7v8.3H155.8z"/></svg>');
		$wikiaLogo.on('mousedown', function(){
			window.trackClick('top-nav', 'wikia_logo_clicks');
			window.optimizely.push(['trackEvent', 'wikia_logo_clicks']);
		});

		$startAWiki.removeClass('wikia-button').html(
			'<svg version="1.1" id="saw-icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 14 14" enable-background="new 0 0 14 14" xml:space="preserve"><polygon points="14,6 8,6 8,0 6,0 6,6 0,6 0,8 6,8 6,14 8,14 8,8 14,8 "/></svg>' +
				'<span>' + $startAWiki.text() + '</span>'
		);
		$startAWiki.on('mousedown', function(){
			window.trackClick('top-nav', 'cnw_click');
			window.optimizely.push(['trackEvent', 'cnw_click']);
		});
	})();
	// Special:Search cleanup for wwww.wikia.com
	if (window.location.host.indexOf('www.') === 0) {
		$('.SearchInput').remove();
	}
});