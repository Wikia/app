/*global ToolbarCustomize:true*/
var WikiaFooterApp = {

	init: function() {
		//Variables
		var footer = $("#WikiaFooter");
		var toolbar = footer.children(".toolbar");
		var mobileSwitchLink = $('#mobileSwitch');

		if(mobileSwitchLink.exists()){
			footer.on('click', '#mobileSwitch', function(e){
				e.preventDefault();
				document.cookie = 'mobilefullsite=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
				jQuery.tracker.byStr('link/mobilesite');
				location.reload();
			});
		}

		// avoid stack overflow in IE (RT #98938)
		if (toolbar.exists()) {
			var windowObj = $(window);
			var originalWidth = toolbar.width();

			var ie7 = typeof $.browser.msie != 'undefined' && typeof $.browser.version != 'undefined' && $.browser.version && $.browser.version.substring(0, $.browser.version.indexOf('.')) < 8;
			var reflow = false;

			//Scroll Detection
			windowObj.resolvePosition = function() {
				// Disable floating for RTE
				if ($('body').hasClass('rte')) {
					return;
				}

				var scroll = windowObj.scrollTop() + windowObj.height();
				var line = 0;
				if(footer.offset()){
					line = footer.offset().top + toolbar.outerHeight();
				}

				if (scroll > line && footer.hasClass("float")) {
					footer.removeClass("float");
					windowObj.centerBar();
					reflow = true;
				} else if (scroll < line && !footer.hasClass("float")) {
					footer.addClass("float");
					windowObj.centerBar();
					reflow = true;
				}

				if (ie7 && reflow) {	//force reflow the page in IE7.  remove after IE7 is dead
					reflow = false;
					setTimeout(function() {
						$('#WikiaPage').attr('class', $('#WikiaPage').attr('class'));
					}, 1);
				}

			};

			windowObj.centerBar = function() {
				var w = windowObj.width();
				if(w < originalWidth && footer.hasClass('float')) {
					toolbar.css('width', w+10);
					if(!toolbar.hasClass('small')){
						toolbar.addClass('small');
					}
				} else if(toolbar.hasClass('small')) {
					toolbar.css('width', originalWidth);
					toolbar.removeClass('small');
				}
				windowObj.resolvePosition();
			};

			if(jQuery.support.positionFixed){
				windowObj.resolvePosition();
				windowObj.centerBar();
				windowObj.scroll(windowObj.resolvePosition);
				windowObj.resize(windowObj.centerBar);
			}

			WikiaFooterApp.toolbar = new ToolbarCustomize.Toolbar( footer.find('.tools') );
		}
	}

};

(function(){
	window.ToolbarCustomize = window.ToolbarCustomize || {};
	var TC = window.ToolbarCustomize;

	TC.MenuGroup = $.createClass(Observable,{

		showTimer: false,
		hideTimer: false,

		showTimeout: 300,
		hideTimeout: 350,

		showing: false,
		visible: false,

		constructor: function() {
			TC.MenuGroup.superclass.constructor.call(this);
			this.showTimer = Timer.create($.proxy(this.show,this),this.showTimeout);
			this.hideTimer = Timer.create($.proxy(this.hide,this),this.hideTimeout);
		},

		add: function( el ) {
			var e = $(el);
			e
				.unbind('.menugroup')
				.bind('mouseenter.menugroup',$.proxy(this.delayedShow,this))
				.bind('mouseleave.menugroup',$.proxy(this.delayedHide,this))
				.children('a','img')
					.unbind('.menugroup')
					.bind('click.menugroup',$.proxy(this.showOnClick,this));
		},

		remove: function( el ) {
			$(el)
				.unbind('.menugroup')
				.children('a','img')
					.unbind('.menugroup');
		},

		show: function( evt ) {
			this.hideTimer.stop();
			this.showTimer.stop();
			if (!this.showing || this.visible == this.showing) {
				return;
			}

			if (this.visible) {
				this.hide();
			}
			if (this.showing) {
				this.visible = this.showing;
				this.showing = false;
				this.fire('menushow',this,this.visible,this.visible.children('ul'));
				this.visible.children('ul').show();
			}
		},

		delayedShow: function( evt ) {
			this.showing = $(evt.currentTarget);
			if (this.visible) {
				this.show(evt);
			} else {
				this.hideTimer.stop();
				this.showTimer.start();
			}
		},

		showOnClick: function( evt ) {
			evt.preventDefault();
			this.showing = $(evt.currentTarget).parent();
			this.show(evt);
		},

		hide: function( evt ) {
			this.hideTimer.stop();
			this.showTimer.stop();
			if (this.visible) {
				this.fire('menuhide',this,this.visible,this.visible.children('ul'));
				this.visible.children('ul').hide();
				this.visible = false;
			}
		},

		delayedHide: function( evt ) {
			this.hideTimer.stop();
			if (this.visible) {
				this.hideTimer.start();
			} else if (this.showing) {
				this.showing = false;
				this.showTimer.start();
			}
		}

	});

	TC.Toolbar = $.createClass(Object,{

		el: false,
		more: false,

		menuGroup: false,

		constructor: function ( el ) {
			TC.Toolbar.superclass.constructor.call(this);
			this.el = el;
			this.menuGroup = new TC.MenuGroup();
			this.menuGroup.bind('menushow',this.onShowMenu,this);
			this.initialize();
		},

		initialize: function() {
			this.el.find('.tools-customize').click($.proxy(this.openConfiguration,this));
			this.menuGroup.add(this.el.find('li.menu'));
			this.handleOverflowMenu();
		},

		openConfiguration: function( evt ) {
			evt.preventDefault();
			var conf = new TC.ConfigurationLoader(this);
			conf.show();
		},

		buildOveflowItem: function () {
			return this.el.find('.overflow-menu').css('display','');
		},

		handleOverflowMenu: function () {
			var all = this.el.children('li');
			var moreable = all.filter('.overflow');
			var where = moreable.last().next();

			var width = 0, mwidth = 0, fwidth = this.el.width();
			all.each(function(i,v){width += $(v).outerWidth(true);});
			moreable.each(function(i,v){mwidth += $(v).outerWidth(true);});

			if (width < fwidth) {
				return;
			}

			var li_more = this.buildOveflowItem();

			if (where.exists()) {
				where.before(li_more);
			}
			else {
				this.el.append(li_more);
			}
			var more = li_more.children('ul');
			var moreWidth = li_more.outerWidth(true) + 5;

			var rwidth = fwidth - moreWidth - (width - mwidth);
			moreable.each(function(i,v){
				rwidth -= $(v).outerWidth(true);
				if (rwidth < 0) {
					$(v).prependTo(more);
				}
			});
			this.menuGroup.add(li_more,$.proxy(this.onShowMenu,this));
		},

		onShowMenu: function( mgroup, li, ul ) {
			ul.css('left', (li.offset().left-this.el.offset().left)+'px');
			ul.css('right','auto');
		},

		load: function(html) {
			this.el.children('li').not('.loadtime').remove();
			this.el.prepend($(html));
			this.initialize();
		}

	});

	TC.ConfigurationLoader = $.createClass(Object,{

		constructor: function( toolbar ) {
			this.toolbar = toolbar;
		},

		show: function() {
			$.loadLibrary('ToolbarCustomize',
				stylepath + '/oasis/js/ToolbarCustomize.js',
				typeof TC.Configuration,
				$.proxy(function(){
					var c = new TC.Configuration(this.toolbar);
					c.show();
				},this)
			);
		}

	});

})();

$(function() {
	WikiaFooterApp.init();
});
