/*
	$Revision: 1.5 $Date: 2013/10/07 15:43:21 $
	SevenOne Media Ad Integration for de.wikia.com
*/

window.myAd = {
	revision: '$Revision: 1.5 $Date: 2013/10/07 15:43:21 $',
	soi_site_script:  'wikia.js',

	container_prefix: 'ad-',

	loaded:     {},
	delivered:  {},
	finished:   {},
	messages:   [],

	loadScript: function(which) {
			if (!window.SOI_WERBUNG) return;
			if (this.loaded[which]) return;
			
			var src = '';
			switch (which) {
				case 'global':
					src = '/globalV6.js';
					break;
				case 'site':
					if (this.soi_site_script) src = '/Sites/' + this.soi_site_script;
					break;
			}
			if (!src) return;
			var server = 'http://ad.71i.de/global_js';

			this.loaded[which] = true;
			document.write('<script src="' + server + src + '" type="text/javascript"><\/script>');
		},
	insertAd: function(ad_id) {
			if (!window.SOI_WERBUNG) return;
			if (!window.SoiAd) return;
			if (this.delivered[ad_id]) return;

			var go = false;
			switch (ad_id) {
				case 'popup1':
					go = window.SOI_PU1;
					break;
				case 'fullbanner2':
					go = window.SOI_FB2;
					break;
				case 'skyscraper1':
					go = window.SOI_SC1;
					break;
				case 'rectangle1':
					go = window.SOI_RT1;
					break;
				case 'promo1':
					go = window.SOI_PB1;
					break;
				case 'promo2':
					go = window.SOI_PB2;
					break;
				case 'promo3':
					go = window.SOI_PB3;
					break;
			}
			if (!go) return;
			// misconfiguration: target container is missing
			if (!document.getElementById(this.container_prefix + ad_id))
				return;

			this.delivered[ad_id] = true;
			SoiAd.write(ad_id);
		},
	finishAd: function(ad_id, mode) {
			if (this.finished[ad_id]) return;
			this.finished[ad_id] = true;

			switch (mode) {
				case 'move':
					this.moveAd(ad_id);
					break;
			}

			this.adjustLayoutForAd(ad_id, mode);
		},
	moveAd: function(ad_id) {
			if (!window.SOI_WERBUNG) return;
			if (!window.SoiAd) return;
			
			if (ad_id == 'fullbanner2' && SoiAd.exists(ad_id) && SoiAd.isBillboard(ad_id)) {
				// fullbanner2 and billboard containers are identical
				// => pass empty special_suffix argument
				SoiAd.moveAd(ad_id, this.container_prefix + ad_id + '-postponed', this.container_prefix + ad_id, '');
			}
			else {
				SoiAd.moveAd(ad_id, this.container_prefix + ad_id + '-postponed', this.container_prefix + ad_id);
			}
		},
	adjustLayoutForAd: function(ad_id, mode) {
			var container = document.getElementById(this.container_prefix + ad_id);
			if (!container) return;

			var exists = this.exists(ad_id);

			if (exists) {
				if (ad_id != 'fullbanner2' || !SoiAd.isBillboard(ad_id)) SoiAd.removeStyleAttribute(container);

				if (SoiAd.isBlockpixel(ad_id))
					container.style.display = 'none';
			}

			if (ad_id == 'popup1') {
				// Nothing to be done
			}
			else {
				var width  = 0;
				var height = 0;

				if (exists) {
					width  = SoiAd.getWidth(ad_id);
					height = SoiAd.getHeight(ad_id);
				}

				if (ad_id == 'fullbanner2') {
					if (exists) {
						var is_powerbanner = SoiAd.isPowerbanner(ad_id);
						var is_pushdown    = SoiAd.isPushdown(ad_id);
						var is_wallpaper   = SoiAd.isWallpaper(ad_id);
						var is_fireplace   = SoiAd.isFireplace(ad_id);
						var is_billboard   = SoiAd.isBillboard(ad_id);
						
						container.style.width = width + 'px';

						if (is_fireplace || is_wallpaper) {
							container.style.marginRight = '0px';
							container.style.marginLeft  = 'auto';
						}
						else if (is_billboard) {
							var max_width = parseInt(SoiQuery.getCurrentStyle(this.container_prefix + ad_id + '-outer', 'width')) || 1030;
							var delta = Math.max(parseInt((width - max_width) / 2), 0);
							if (delta) {
								// Wider than content - centrify via negative margin-left
								container.style.marginLeft = (-1 * delta) + 'px';
							}
							else {
								// Not wider than content - centrify via auto margin
								container.style.width = width + 'px';
								container.style.margin = '0px auto';
							}
						}
					}
					else {
						if (!window.SOI_VP || window.SOI_AUTOPLAY == 'off')
							container.style.height = '0px';
					}
				}
				else if (ad_id == 'skyscraper1') {
					// nothing to be done
				}
				else if (ad_id == 'rectangle1') {
					if (!exists) container.style.display = 'none';
				}
				else if (ad_id.match(/^promo[1-5]/)) {
					// nothing to be done
				}
			}
		},
	clearAd: function(ad_id) {
			var container = document.getElementById(this.container_prefix + ad_id);
			if (!container) return;
			container.innerHTML = '';
			container.style.display = 'none';
		},
	clearAds: function() {
			for (var k in this.delivered) {
				this.clearAd(k);
			}
		},
	exists: function(ad_id) {
			return window.SoiAd ? SoiAd.exists(ad_id) || false : false;
		},
	isSpecialAd: function(ad_id, which) {
			var retval = false;
			if (this.exists(ad_id) && window.SoiAd) {
				if (which) {
					which = String(which);
					var method = 'is' + which.substr(0, 1).toUpperCase() + which.substr(1);
					if (SoiAd[method]) retval = SoiAd[method](ad_id);
				}
				else {
					switch (ad_id) {
						case 'fullbanner2':
							retval = SoiAd.isPowerbanner(ad_id) || SoiAd.isPushdown(ad_id)|| SoiAd.isBillboard(ad_id)
								|| SoiAd.isWallpaper(ad_id) || SoiAd.isFireplace(ad_id);
							break;
						case 'rectangle1':
							retval = SoiAd.isHalfpage(ad_id);
							break;
						case 'skyscraper1':
							retval = SoiAd.isSidebar(ad_id);
							break;
					}
				}
			}
			return retval ? true : false;
		},
	videoAdRequest: function(ad_id, data) {
			if (!window.SOI_WERBUNG || !window.SOI_VP) return '';
			
			var lookup = {
					preroll:   window.SOI_VA1,
					postroll:  window.SOI_VA2,
					presplit:  window.SOI_VA3,
					midroll:   window.SOI_VA3,
					postsplit: window.SOI_VA3,
					overlay:   window.SOI_VA4,
					sponsor:   window.SOI_VA5,
					pause:     true
				};
			var type = String(ad_id).replace(/[0-9]+[a-z]?$/, '');
			if (!lookup[type]) return '';

			// Re-initialize in case of repeated video view
			if (this.seen && ad_id.match(/^preroll1a?$/)) {
				if (window.SoiInitDFPVars) window.SoiInitDFPVars();
				window.SOI_AUTOPLAY = 'off';
				this.clearAds();
				this.cleared_display_ads = false; // clear must happen again in first midroll block
			}

			this.seen = true;

			// Exclusiveness of midroll ads
			if (!this.cleared_display_ads && ad_id.match(/^(presplit|midroll|postsplit)/)) {
				this.clearAds();
				this.cleared_display_ads = true; // only required on first midroll block
			}

			// Special adjustment for article player
			var saved = {};
			if (window.SOI_CONTENT != 'video') {
				saved = {
						DFPSite:      window.DFPSite,
						SOI_CONTENT:  window.SOI_CONTENT,
						SOI_VP:       window.SOI_VP,
						SOI_VA1:      window.SOI_VA1,
						SOI_VA2:      window.SOI_VA2,
						SOI_AUTOPLAY: window.SOI_AUTOPLAY
					};
				if (window.DFPSite != 'showroom' && !window.DFPSite.match(/\.video$/))
					window.DFPSite += '.video';
				window.SOI_CONTENT  = 'video';
				window.SOI_VP       = true;
				window.SOI_VA1      = true;
				window.SOI_VA2      = true;
				window.SOI_AUTOPLAY = 'off';
			}

			var ad_request = '';
			try {
				ad_request = window.soi_VideoAdRequest(ad_id, data);
			}
			catch(e) {}

			// Reset global variables
			for (var k in saved) {
				window[k] = saved[k];
			}

			return ad_request || '';
		}
};
