window.LiftiumDART = (function(window, $, WikiaTracker, Athena, AdEngine, AdConfig, Liftium, LiftiumOptions, undef) {
	'use strict';

	var wgPageName = window.wgPageName
		, wgIsMainpage = window.wgIsMainpage || window.top.wgIsMainpage || false
		, hasprefooters
		, width
		, height
		, random = Math.round(Math.random() * 23456787654)
		, sites = {
		  'Auto': 'wka.auto',
		  'Creative': 'wka.crea',
		  'Education': 'wka.edu',
		  'Entertainment': 'wka.ent',
		  'Finance': 'wka.fin',
		  'Gaming': 'wka.gaming',
		  'Green': 'wka.green',
		  'Humor': 'wka.humor',
		  'Lifestyle': 'wka.life',
		  'Music': 'wka.music',
		  'Philosophy': 'wka.phil',
		  'Politics': 'wka.poli',
		  'Science': 'wka.sci',
		  'Sports': 'wka.sports',
		  'Technology': 'wka.tech',
		  'Test Site': 'wka.test',
		  'Toys': 'wka.toys',
		  'Travel': 'wka.travel'
		}
		, slotconfig = {
		   'TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
		   'TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
		   'DOCKED_LEADERBOARD': {'tile': 8, 'loc': "bottom"},
		   'LEFT_SKYSCRAPER_1': {'tile': 3, 'loc': "top"},
		   'LEFT_SKYSCRAPER_2': {'tile': 3, 'loc': "middle"},
		   'LEFT_SKYSCRAPER_3': {'tile': 6, 'loc': "middle"},
		   'FOOTER_BOXAD': {'tile': 5, 'loc': "footer"},
		   'PREFOOTER_LEFT_BOXAD': {'tile': 5, 'loc': "footer"},
		   'PREFOOTER_RIGHT_BOXAD': {'tile': 5, 'loc': "footer"},
		   'PREFOOTER_BIG': {'tile': 5, 'loc': "footer"},
		   'HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
		   'HOME_TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
		   'HOME_LEFT_SKYSCRAPER_1': {'tile':3, 'loc': "top"},
		   'HOME_LEFT_SKYSCRAPER_2': {'tile':3, 'loc': "middle"},
		   'INCONTENT_BOXAD_1': {'tile':4, 'loc': "middle"},
		   'INCONTENT_BOXAD_2': {'tile':5, 'loc': "middle"},
		   'INCONTENT_BOXAD_3': {'tile':6, 'loc': "middle"},
		   'INCONTENT_BOXAD_4': {'tile':7, 'loc': "middle"},
		   'INCONTENT_BOXAD_5': {'tile':8, 'loc': "middle"},
		   'INCONTENT_LEADERBOARD_1': {'tile':4, 'loc': "middle"},
		   'INCONTENT_LEADERBOARD_2': {'tile':5, 'loc': "middle"},
		   'INCONTENT_LEADERBOARD_3': {'tile':6, 'loc': "middle"},
		   'INCONTENT_LEADERBOARD_4': {'tile':7, 'loc': "middle"},
		   'INCONTENT_LEADERBOARD_5': {'tile':8, 'loc': "middle"},
		   'EXIT_STITIAL_INVISIBLE': {'tile':1, 'loc': "exit", 'dcopt': "ist"},
		   'EXIT_STITIAL_BOXAD_1': {'tile':2, 'loc': "exit"},
		   'EXIT_STITIAL_BOXAD_2': {'tile':3, 'loc': "exit"},
		   'INVISIBLE_1': {'tile':10, 'loc': "invisible"},
		   'INVISIBLE_2': {'tile':11, 'loc': "invisible"},
		   'INVISIBLE_TOP': {'tile':13, 'loc': "invisible"},
		   'TEST_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
		   'TEST_HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"}
		}
		, sizeconfig = {
		   '300x250': '300x250',
		   '600x250': '600x250,300x250',
		   '728x90': '728x90,468x60',
		   '160x600': '160x600,120x600',
		   '0x0': '1x1',
		   '300x53': '300x53'
		};

	return {
		getUrl: function(slotname, size, network_options, iframe) {
			var url2 = AdConfig.DART.getUrl(slotname, size, true, 'Liftium')
				, sz = url2.match(/;sz=[0-9x,]+;/)	// replace sz=foo,bar,baz with sz=foo only
				, sz2;

			if (sz) {
				sz2 = sz[0].match(/[0-9]+x[0-9]+/);
				url2 = url2.replace(/;sz=[0-9x,]+;/, ';sz=' + sz2[0] + ';');
			}

			Liftium.d("Dart URL2= " + url2, 4);
			return url2;
		},
		callAd: function (slotname, size, network_options) {
			var url;

			if (Liftium.e(slotconfig[slotname])) {
				Liftium.d("Notice: LiftiumDART not configured for " + slotname);
			}

			url = this.getUrl(slotname, size, network_options, false);
			return '<scr' + 'ipt type="text/javascript" src="' + url + '"><\/sc' + 'ript>';
		},
		getSubdomain: function() {
			var subdomain = 'ad';

			if (!Liftium.e(Liftium.geo.continent)) {
				switch (Liftium.geo.continent) {
					case 'AF':
					case 'EU':
						subdomain = 'ad-emea';
						break;
					case 'AS':
						Liftium.d('country: ' + Liftium.getCountry().toUpperCase(), 4);
						switch (Liftium.getCountry().toUpperCase()) {
							// Middle East
							case 'AE':
							case 'CY':
							case 'BH':
							case 'IL':
							case 'IQ':
							case 'IR':
							case 'JO':
							case 'KW':
							case 'LB':
							case 'OM':
							case 'PS':
							case 'QA':
							case 'SA':
							case 'SY':
							case 'TR':
							case 'YE':
								subdomain = 'ad-emea';
								break;
							default:
								subdomain = 'ad-apac';
						}
						break;
					case 'OC':
						subdomain = 'ad-apac';
						break;
					default: // NA, SA
						subdomain = 'ad';
				}
			}

			return subdomain;
		},
		getAdType: function(iframe) {
			if (iframe) {
				return 'adi';
			}
			return 'adj';
		},
		getDARTSite: function(hub) {
			return sites[hub] || 'wka.wikia';
		},
		getZone1: function(dbname) {
			// Effectively the dbname, defaulting to wikia.
			// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
			if (Liftium.e(dbname)) {
				return '_wikia';
			}
			return '_' + dbname.replace('/[^0-9A-Z_a-z]/', '_');
		},
		getZone2: function() {
			// Page type, ie, "home" or "article"
			if (!Liftium.e(Liftium.getPageVar('page_type'))) {
				return Liftium.getPageVar('page_type');
			}
			return 'article';
		},
		getTileKV: function (slotname) {
			if (!Liftium.e(slotconfig[slotname]) && slotconfig[slotname].tile) {
				return 'tile=' + slotconfig[slotname].tile + ';';
			}
			return '';
		},
		getDcoptKV: function(slotname) {
			if (!Liftium.e(slotconfig[slotname]) && slotconfig[slotname].dcopt) {
				return 'dcopt=' + slotconfig[slotname].dcopt + ';';
			}
			return '';
		},
		getLocKv: function (slotname) {
			if (!Liftium.e(slotconfig[slotname]) && slotconfig[slotname].loc){
				return 'loc=' + slotconfig[slotname].loc + ';';
			}
			return '';
		},
		getArticleKV: function() {
			// Title is one of the always-present key-values
			if (!Liftium.e(Liftium.getPageVar('article_id'))) {
				return "artid=" + Liftium.getPageVar('article_id') + ';';
			}
			return '';
		},
		getTitle: function() {
			if (!Liftium.e(wgPageName)) {
				return "wpage=" + wgPageName + ";";
			}
			return "";
		},
		getDomainKV: function (hostname) {
			var sld = ''
				, lhost = hostname.toLowerCase()
				, pieces = lhost.split(".")
				, np = pieces.length;

			if (pieces[np - 2] === 'co') {
				// .co.uk or .co.jp
				sld = pieces[np - 3] + '.' + pieces[np - 2] + '.' + pieces[np - 1];
			} else {
				sld = pieces[np - 2] + '.' + pieces[np - 1];
			}

			if (sld !== ''){
				return 'dmn=' + sld.replace(/\./g, '') + ';';
			}
			return '';
		},
		getImpressionCount: function (slotname) {
			// depends on jquery.expirystorage.js and jquery.store.js
			// return key-value only if impression cookie exists

			var adDriverNumAllCallStorageName = 'adDriverNumAllCall'
				, storage = ''
				, cookieStorage = ''
				, i;
		
			if (Liftium.e(Liftium.adDriverNumCall)) {
				if (window.wgAdDriverUseExpiryStorage) {
					Liftium.d('Loading AdDriver data from expiry storage');
					storage = $.expiryStorage.get(adDriverNumAllCallStorageName);
				}

				if (window.wgAdDriverUseCookie) {
					Liftium.d('Loading AdDriver data from cookie');
					cookieStorage = Liftium.cookie('adDriverNumAllCall');			
					if (Liftium.e(window.wgAdDriverUseExpiryStorage)) {
						storage = cookieStorage;
					}
				}
				if (!Liftium.e(storage)) {
					try {
						Liftium.adDriverNumCall = JSON.parse(storage);
						Liftium.d('AdDriver data loaded:', 7, Liftium.AdDriverNumCall);
					} catch (e) {
						Liftium.d('AdDriver data load failed', 1);
						WikiaTracker.track([LiftiumOptions.pubid, 'error', 'impctparse', slotname], 'liftium.errors');
					}
				}

				if (window.wgAdDriverUseExpiryStorage && window.wgAdDriverUseCookie) {
					if (storage !== cookieStorage) {
						WikiaTracker.track([LiftiumOptions.pubid, "error", "impctoutofsync", slotname], 'liftium.errors');
					}
				}		
			}

			if (!Liftium.e(Liftium.adDriverNumCall)) {
				for (i = 0; i < Liftium.adDriverNumCall.length; i += 1) {
					if (Liftium.adDriverNumCall[i].slotname === slotname) {
						// check cookie expiration
						// wgAdDriverCookieLifetime in hours, convert to msec
						if (parseInt(Liftium.adDriverNumCall[i].ts, 10) + window.wgAdDriverCookieLifetime * 3600000 > Liftium.now.getTime()) {
							return 'impct=' + parseInt(Liftium.adDriverNumCall[i].num, 10) + ';';
						}
					}
				}
			}
			return '';
		},
		getResolution: function () {
			if (Liftium.e(width) || Liftium.e(height)) {
				width = document.documentElement.clientWidth || document.body.clientWidth;
				height = document.documentElement.clientHeight || document.body.clientHeight;
				Liftium.d("resolution: " + width + "x" + height, 7);
				// Liftium.trackEvent(["resolution", LiftiumDART.width + "x" + LiftiumDART.height]);
			}
			if (width > 1024) {
				return 'dis=large;';
			}
			return '';
		},
		getPrefooterStatus: function () {
			if (Liftium.e(hasprefooters)) {
				if (AdEngine === undef) {
					if (AdEngine.isSlotDisplayableOnCurrentPage("PREFOOTER_LEFT_BOXAD")) {
						hasprefooters = "yes";
					} else {
						hasprefooters = "no";
					}
				} else {
					hasprefooters = "unknown";
				}
			}
			Liftium.d("has prefooters: " + hasprefooters, 7);
		
			return "hasp=" + hasprefooters + ";";
		},
		getAllDartKeyvalues: function (slotname) {
			var d = Liftium.getPageVar('dart', '')
				, out = 's0=' + this.getDARTSite(Liftium.getPageVar('Hub')).replace(/wka\./, '') + ';' +
					's1=' + this.getZone1(Liftium.getPageVar('wgDBname')) + ';' +
					's2=' + this.getZone2() + ';' +
					'@@WIKIA_PROVIDER_VALUES@@' +
					this.getLocKv(slotname) +
					this.getArticleKV() +
					this.getDomainKV(Liftium.getPageVar('domain')) +
					'pos=' + slotname + ';';

			out = out.replace(/@@WIKIA_AQ@@/, Athena.getMinuteTargeting());

			if (!Liftium.e(d)) {
				out = out.replace(/@@WIKIA_PROVIDER_VALUES@@/, d + ';');
			}
			return out;
		}
	};
}(window, window.jQuery, window.WikiaTracker, window.Athena, window.AdEngine, window.AdConfig, window.Liftium, window.LiftiumOptions));
