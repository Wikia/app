define('specialVideos.mobile.views.index', [
	'wikia.mustache',
	'media',
	'specialVideos.templates.mustache',
	'wikia.tracker'
], function (Mustache, WikiaMobileMediaControls, templates, Tracker) {
	'use strict';

	/**
	 * SpecialVideosIndexView
	 * @constructor
	 * @description View class for Special:Videos on mobile
	 * @param {Object} config An object that contains 'el' & 'collection' properties
	 */
	function SpecialVideosIndexView(config) {
		this.$el = $(config.el);
		this.$filter = this.$el.find('.filter');
		this.$loadMoreBtn = this.$el.find('.load-more');

		this.collection = config.collection;
		this.filterActiveClass = config.filterActiveClass;

		WikiaMobileMediaControls.disableSwipe();
		this.initialize();
	}

	/**
	 * initialize
	 * @description set up event bindings for view
	 */
	SpecialVideosIndexView.prototype.initialize = function () {
		this.$filter.find('a').on('click', $.proxy(this, 'onFilterClick'));
		this.$loadMoreBtn.on('click', $.proxy(this, 'onLoadMoreClick'));
		this.$el.find('.video-list').on('click', '.title', $.proxy(this, 'onTitleClick'));
		this.$el.find('.video-list').on('click', '.play-circle', $.proxy(this, 'onPlayButtonClick'));
		this.track({
			action: Tracker.ACTIONS.IMPRESSION,
			label: 'page'
		});
	};

	/**
	 * track
	 * @param {Object} params
	 * @return {Function} partially applied tracking function
	 */
	SpecialVideosIndexView.prototype.track = Tracker.buildTrackingFunction({
		category: 'wikiamobile-special-videos',
		trackingMethod: 'analytics'
	});

	/**
	 * render
	 * @description renders view from json using mustache template
	 * @return {SpecialVideosIndexView} instance of class
	 */
	SpecialVideosIndexView.prototype.render = function () {
		var html,
			insertionMethod;

		html = '';
		// if filter is changed, then we user $.fn.html, else $.fn.append
		insertionMethod = (this.collection.page > 1) ? 'append' : 'html';

		this.collection.data.videos.forEach(function (item) {
			html += Mustache.render(templates.video, item);
		});

		this.$el.find('.video-list')[insertionMethod](html);
		WikiaMobileMediaControls.reset();
		return this;
	};

	/**
	 * onFilterClick
	 * @param {Object} evt jQuery event object
	 * @return {Boolean} false
	 */
	SpecialVideosIndexView.prototype.onFilterClick = function (evt) {
		var $tar = $(evt.target),
			self = this;

		if ($tar.hasClass(this.filterActiveClass)) {
			return;
		}

		$tar.addClass(this.filterActiveClass).siblings().removeClass(this.filterActiveClass);
		this.collection.fetch($tar.text())
			.success(function () {
				self.render();
			});

		this.track({
			action: Tracker.ACTIONS.CLICK,
			label: 'sort-filter-btn',
			value: $tar.index()
		});

		return false;
	};

	/**
	 * onLoadMoreClick
	 * @return {Boolean} false
	 */
	SpecialVideosIndexView.prototype.onLoadMoreClick = function () {
		var self = this;
		this.collection.fetch().success(function () {
			self.render();
		});
		this.track({
			action: Tracker.ACTIONS.CLICK,
			label: 'load-more-btn'
		});
		return false;
	};

    /**
     * onPlayButtonClick
	 * @description This method exists because there isn't a more eloquent way to at arbitrary elements to the
	 * mechanism that opens the mobile lightbox. When our .play-circle span is clicked, it triggers a click on the
	 * neighboring image tag.
	 * @param {Object} evt jQuery event object
	 * @return {Boolean} false
     */
	SpecialVideosIndexView.prototype.onPlayButtonClick = function (evt) {
		$(evt.target).prevAll('img').trigger('click');
		return false;
	};

	/**
	 * onTitleClick
	 * @description This method exists because there isn't a more eloquent way to at arbitrary elements to the
	 * mechanism that opens the mobile lightbox. When our .title span is clicked, it triggers a click on the
	 * neighboring image tag.
	 * @param {Object} evt jQuery event object
	 * @return {Boolean} false
	 */
	SpecialVideosIndexView.prototype.onTitleClick = function (evt) {
		var $tar = $(evt.target);
		$tar.closest('.info').prev().find('img').trigger('click');
		return false;
	};

	return SpecialVideosIndexView;
});
