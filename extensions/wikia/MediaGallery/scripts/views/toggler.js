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
		this.interval = options.interval || 12;
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

		$elems.removeClass('hidden');

		// wait till after display:block before starting transition
		setTimeout(function () {
			$elems.removeClass('fade');
		}, 0);

		this.$less.removeClass('hidden');

		// hide the 'show more' button if there's no more to show
		if (end >= this.$media.length) {
			this.$more.addClass('hidden');
		}

		this.track('show-more-items', this.visible);
	};

	Toggler.prototype.showLess = function () {
		var self = this,
			// get the css fade-duration property in seconds; then wait half that time before hiding elements
			fadeDuration = parseInt(this.$overflow.css('transition-duration')) * 500;

		this.visible = this.oVisible;
		this.$overflow.addClass('fade');

		// wait till after fade out transition to hide the element
		setTimeout(function () {
			self.$overflow.addClass('hidden');
		}, fadeDuration);

		this.$more.removeClass('hidden');
		this.$less.addClass('hidden');

		this.track('show-less-items');
	};

	Toggler.prototype.track = function (label, count) {
		Wikia.Tracker.track({
			category: 'media-lightbox',
			action: Wikia.Tracker.ACTIONS.CLICK,
			label: label,
			trackingMethod: 'both',
			value: count || 0
		});
	};

	return Toggler;
});
