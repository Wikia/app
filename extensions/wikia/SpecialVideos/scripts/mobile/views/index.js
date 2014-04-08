define('specialVideos.mobile.views.index', [
	'wikia.mustache',
	'specialVideos.templates.mustache'
], function (Mustache, templates) {
	'use strict';

	/**
	 * SpecialVideosIndexView
	 * @constructor
	 * @description View class for Special:Videos on mobile
	 * @param cfg An object that contains 'el' & 'collection' properties
	 */
	function SpecialVideosIndexView(cfg) {
		this.$el = $(cfg.el);
		this.$filter = this.$el.find('.filter');
		this.$loadMoreBtn = this.$el.find('.load-more');

		this.collection = cfg.collection;
		this.filterActiveClass = cfg.filterActiveClass;

		this.initialize();
	}

	/**
	 * initialize
	 * @description set up event bindings for view
	 */
	SpecialVideosIndexView.prototype.initialize = function () {
		this.$filter.find('li').on('click', $.proxy(this, 'onFilterClick'));
		this.$loadMoreBtn.on('click', $.proxy(this, 'onLoadMoreClick'));
	};

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
		console.log(this.collection.page);
		insertionMethod = (this.collection.page > 1) ? 'append' : 'html';

		this.collection.data.videos.forEach(function (item) {
			html += Mustache.render(templates.video, item);
		});

		this.$el.find('.video-list')[insertionMethod](html);
		return this;
	};

	/**
	 * onFilterClick
	 * @description
	 * @param evt jQuery event object
	 * @return {Boolean} false
	 */
	SpecialVideosIndexView.prototype.onFilterClick = function (evt) {
		var $tar = $(evt.target),
			self = this;

		if ($tar.hasClass(this.filterActiveClass)) {
			return;
		}

		this.collection.fetch($tar.text())
			.success(function () {
				$tar.addClass(self.filterActiveClass).siblings().removeClass(self.filterActiveClass);
				self.render();
			});
		return false;
	};

	/**
	 * onLoadMoreClick
	 * @description
	 * @param evt jQuery event object
	 * @return {Boolean} false
	 */
	SpecialVideosIndexView.prototype.onLoadMoreClick = function () {
		var self = this;
		this.collection.fetch().success(function () {
			self.render();
		});
		return false;
	};

	return SpecialVideosIndexView;
});
