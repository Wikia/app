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
