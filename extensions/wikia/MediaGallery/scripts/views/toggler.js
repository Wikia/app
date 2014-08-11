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
		this.$media = $el.find('.media');
		this.$overflow = this.$media.filter('.hidden');
		this.interval = options.interval || 2;
		this.visible = this.$media.not(this.$overflow).length;
		this.oVisible = this.visible;
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
		this.$more = this.$el.find('.show');
		this.$less = this.$el.find('.hide');
	};

	Toggler.prototype.bindEvents = function () {
		this.$more.on('click', $.proxy(this.showMore, this));
		this.$less.on('click', $.proxy(this.showLess, this));
	};

	Toggler.prototype.showMore = function () {
		var start = this.visible,
			end = start + this.interval,
			$elems = this.$media.slice(start, end);

		// update tally of visible images
		this.visible += this.interval;

		$elems.find('img').attr('src', function () {
			return $(this).attr('data-src');
		});
		$elems.removeClass('hidden');
	};

	Toggler.prototype.showLess = function () {
		this.visible = this.oVisible;
		this.$overflow.addClass('hidden');
	};

	return Toggler;
});
