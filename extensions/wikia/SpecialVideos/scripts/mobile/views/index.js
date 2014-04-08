define('specialVideos.mobile.views.index', [], function () {
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
		console.log('Rendering ', this.collection.data);
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

		this.collection.fetch({
			filter: $tar.text().toLowerCase()
		}).success(function () {
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
