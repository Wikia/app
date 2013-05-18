$(function() {

var Paginator = function(el, summary) {
	this.$el = $(el);
	this.$backward = this.$el.find('.left');
	this.$forward = this.$el.find('.right');
	this.$current = this.$el.find('.page-list-current');
	this.$root = this.$el.parents('.page-listings');
	this.type = this.$root.data('listing-type');
	this.currentPage = 0;
	this.totalCount = 0;
	this.summary = window.FilePageSummary[this.type];
	this.$content = this.$root.find('.page-list-content');
	this.init();
};

Paginator.prototype = {
	ARTICLES_PER_PAGE: 3,
	init: function() {
		var self = this;
		this.$el.on('click', '.arrow', function(e) {
			$target = $(e.target);
			if(!$target.hasClass('disabled')) {
				if($target.hasClass('right')) {
					self.currentPage++;
				} else if ($target.hasClass('left')) {
					self.currentPage--;
				}
				self.updatePager();
				self.updateContent();
			}

		});

		this.flatSummary = [];

		// flatten summary structure
		for(wiki in this.summary) {
			this.flatSummary = this.flatSummary.concat(this.summary[wiki]);
		}

		this.totalCount = this.flatSummary.length;
		this.maxPage = Math.ceil(this.totalCount / Paginator.prototype.ARTICLES_PER_PAGE) - 1;
		if(this.maxPage > 0) {
			this.$el.find('.page-list-total').text(this.maxPage + 1);
			this.updatePager();
			this.$el.show();
		}
	},
	updatePager: function() {
		this.$forward.removeClass('disabled');
		this.$backward.removeClass('disabled');
		if(this.currentPage === 0) {
			this.$backward.addClass('disabled');
		}
		if(this.currentPage === this.maxPage) {
			this.$forward.addClass('disabled');
		}

		this.$current.text(this.currentPage + 1);
	},
	updateContent: function() {
		this.$content.startThrobbing();

		var index = this.currentPage * Paginator.prototype.ARTICLES_PER_PAGE,
			flatSubSummary = this.flatSummary.slice(index, index + Paginator.prototype.ARTICLES_PER_PAGE),
			summary = {},
			i = 0,
			self = this,
			flatSubSummaryLength = flatSubSummary.length;

		for(i = 0; i < flatSubSummaryLength; i++) {
			var wiki = flatSubSummary[i].wiki;
			if(!summary[wiki]) {
				summary[wiki] = [];
			}
			summary[wiki].push(flatSubSummary[i]);
		}

		$.nirvana.sendRequest({
			controller: 'FilePageController',
			method: 'fileList',
			type: 'get',
			format: 'html',
			data: {
				summary: summary,
				type: this.type
			},
			callback: function(html) {
				self.$content.html(html).stopThrobbing();

			}
		});
	}
};

var FilePageTabbed = {
	init: function() {
		this.initTabCookies();

		this.initRemoveVideo();

		this.initPagination();

		// Hide global usage sections in Oasis
		$('#globalusage, #mw-imagepage-section-globalusage').hide();

	},
	/**
	 * Set cookies for logged in users to save which tab is active when they exit the page
	 */
	initTabCookies: function() {
		require(['wikia.localStorage'], function(ls) {
			if(window.wgUserName) {
				var selected = ls.WikiaFilePageTab || 'about';

				$('[data-tab="' + selected + '"] a').click();

				$(window).on('wikiaTabClicked', function(e, tab) {
					ls.WikiaFilePageTab = tab;
				});
			} else {
				$('[data-tab="about"] a').click();
			}
		});
	},
	/**
	 * Initialize pagination for "Appears in these..." sections
	 */
	initPagination: function() {
		$('.page-list-pagination').each(function() {
			new Paginator($(this));
		});
	},
	/**
	 *	Bind event when the "remove" button is clicked in the edit menu
	 */
	initRemoveVideo: function() {
		var self = this;

		$('.WikiaMenuElement').on('click', '.remove', function(e) {
			e.preventDefault();

			$.showCustomModal($.msg('videohandler-remove-video-modal-title'),'', {
				id: 'remove-video-modal',
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.msg('videohandler-remove-video-modal-ok'),
						handler: function(){
							$.nirvana.sendRequest({
								controller: 'VideoHandlerController',
								method: 'removeVideo',
								type: 'POST',
								format: 'json',
								data: {
									title: wgTitle
								},
								callback: function(json) {
									if (json['result'] == 'ok') {
										window.location = json['redirectUrl'];
									} else {
										GlobalNotification.show(json['msg'], 'error');
									}
								}
							});
						}
					},
					{
						id: 'cancel',
						message: $.msg('videohandler-remove-video-modal-cancel'),
						handler: function(){
							self.removeVideoModal.closeModal();
						}
					}
				],
				callback: function() {
					self.removeVideoModal = $('#remove-video-modal');
				}
			});
		});
	}
}

FilePageTabbed.init();

});