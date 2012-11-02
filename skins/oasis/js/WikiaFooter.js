/*global ToolbarCustomize:true*/
var WikiaFooterApp = {

	init: function() {
		//Variables
		if( window.wgEnableWikiaBarExt ) {
		//the admin tool bar is within wikia bar container which is outside the #WikiaPage
			this.footer = $("#WikiaBarWrapper .wikia-bar");
		} else {
		//the admin tool bar is positioned absolutely but in DOM in it's in #WikiaFooter within #WikiaPage
			this.footer = $("#WikiaFooter");
		}
		this.toolbar = this.footer.children(".toolbar");
		this.gn = $('.global-notification');
		this.windowObj = $(window);
		this.originalWidth = this.toolbar.width();

		// avoid stack overflow in IE (RT #98938)
		if (this.toolbar.exists() || this.gn.exists()) {
			if(!( navigator.platform in {'iPad':'', 'iPhone':'', 'iPod':''} || (navigator.userAgent.match(/android/i) != null))){
				this.addScrollEvent();
				this.addResizeEvent();
			}
			this.tcToolbar = new ToolbarCustomize.Toolbar( this.footer.find('.tools') );
		}
	},
	addScrollEvent: function() {
		WikiaFooterApp.windowObj.off('scroll.FooterAp'); // GlobalNotifications could be re-binding this event.
		WikiaFooterApp.windowObj.on('scroll.FooterAp', WikiaFooterApp.resolvePosition).triggerHandler('scroll');
	},
	addResizeEvent: function (){
		WikiaFooterApp.windowObj.on('resize', WikiaFooterApp.centerBar).triggerHandler('resize');
	},
	centerBar: function() {
		var w = WikiaFooterApp.windowObj.width();
		if(w < WikiaFooterApp.originalWidth && WikiaFooterApp.footer.hasClass('float')) {
			WikiaFooterApp.toolbar.css('width', w+10);
			if(!WikiaFooterApp.toolbar.hasClass('small')){
				WikiaFooterApp.toolbar.addClass('small');
			}
		} else if(WikiaFooterApp.toolbar.hasClass('small')) {
			WikiaFooterApp.toolbar.css('width', WikiaFooterApp.originalWidth);
			WikiaFooterApp.toolbar.removeClass('small');
		}
		WikiaFooterApp.resolvePosition();
	},
	// this is called while scrolling
	resolvePosition: function() {
		// Disable floating for RTE
		if( window.wgIsEditPage ) {
			return;
		}

		var scrollTop = WikiaFooterApp.windowObj.scrollTop(),
			scroll = scrollTop + WikiaFooterApp.windowObj.height(),
			line = 0;

		if(WikiaFooterApp.footer.offset()){
			line = WikiaFooterApp.footer.offset().top + WikiaFooterApp.toolbar.outerHeight();
		}

		if (scroll > line && WikiaFooterApp.footer.hasClass("float")) {
			WikiaFooterApp.footer.removeClass("float");
			WikiaFooterApp.centerBar();
		} else if (scroll < line && !WikiaFooterApp.footer.hasClass("float")) {
			WikiaFooterApp.footer.addClass("float");
			WikiaFooterApp.centerBar();
		}

		// GlobalNotification uses same scroll event for performance reasons (BugId:33365)
		if(window.GlobalNotification && !window.GlobalNotification.isModal()) {
			GlobalNotification.onScroll(scrollTop);
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
			var all = this.el.children('li'),
				moreable = all.filter('.overflow'),
				where = moreable.last().next(),
				width = 0,
				mwidth = 0,
				fwidth = this.el.width();

			all.each(function(i,v) {
				width += $(v).outerWidth(true);
			});
			moreable.each(function(i,v) {
				mwidth += $(v).outerWidth(true);
			});

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

$(function(){
	WikiaFooterApp.init();
});
