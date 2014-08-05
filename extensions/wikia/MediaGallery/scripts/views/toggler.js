define('mediaGallery.toggler', ['mediaGallery.templates.mustache'], function (templates) {
	'use strict';

	// workaround for nirvana template naming conventions and JSHint conflict
	var templateName = 'MediaGalleryController_showMore';

	/**
	 * Toggle number of images shown in a gallery
	 * @param {Object} options
	 * @constructor
	 */
	function Toggler(options) {
		var $el = options.$el;

		this.$el = $el;
		this.total = $el.data('count');
		this.count = options.count || 16;
		this.visible = options.visible || 8;
		this.$media = $el.find('.media');
	}

	Toggler.prototype.init = function () {
		this.render();
		this.bindEvents();
	};

	Toggler.prototype.render = function () {
		var data = {
				showMore: $.msg('mediagallery-show-more'),
				showLess: $.msg('mediagallery-show-less')
			};
		this.$el.append(Mustache.render(templates[templateName], data));
		this.$more = this.$el.find('.more');
		this.$less = this.$el.find('.less');
	};

	Toggler.prototype.bindEvents = function () {
		this.$more.on('click', $.proxy(this.showMore, this));
		this.$less.on('click', $.proxy(this.showLess, this));
	};

	Toggler.prototype.showMore = function () {
		var $first = this.$media.eq(this.visible),
			last = this.visible + this.count,
			$elems = $first.nextUntil(':nth-child(' + last + ')');

		$elems.addClass('show');
	};

	Toggler.prototype.showLess = function () {

	};

	return Toggler;
});
