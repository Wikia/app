var ArticleComments = {
	processing: false,

	init: function() {
		$('#article-comm-submit').bind('click', {source: '#article-comm'}, ArticleComments.postComment);
		$('#article-comm-order').find('a').bind('click', ArticleComments.changeOrder);
		$('#article-comments-pagination').find('div').css('backgroundColor', $('#wikia_page').css('backgroundColor'));
		$('#article-comments').delegate('.article-comm-delete', 'click', ArticleComments.linkDelete);
		$('#article-comments').delegate('.article-comm-edit', 'click', ArticleComments.edit);
		$('#article-comments').delegate('.article-comm-history', 'click', ArticleComments.linkHistory);
		$('#article-comments').delegate('.article-comm-reply', 'click', ArticleComments.reply);
		$('#article-comments').delegate('.article-comments-li', 'mouseover',  function(){$(this).find('.tools').css('visibility', 'visible');});
		$('#article-comments').delegate('.article-comments-li', 'mouseout',  function(){$(this).find('.tools').css('visibility', 'hidden');});
		$('#article-comm-fbMonit').mouseenter( function() {$('#fbCommentMessage').fadeIn( 'slow' )});
		$('#article-comm-fbMonit').mouseleave( function() {$('#fbCommentMessage').fadeOut( 'slow' )});
		ArticleComments.addHover();
		ArticleComments.showEditLink();
	},

	log: function(msg) {
		$().log(msg, 'ArticleComments');
	},

	track: function(fakeUrl) {
		//blogs
		if (wgNamespaceNumber == 500 || wgNamespaceNumber == 501) {
			WET.byStr('comment/blog/' + fakeUrl);
		} else {
			WET.byStr('comment/article/' + fakeUrl);
		}
	},

	showEditLink: function() {
		//hack to display 'edit' link when slave lag caused it to be hidden
		if (wgUserName) {
			$('#article-comments-ul').find('strong').find('a:contains("' + wgUserName + '")').closest('.article-comments').find('.edit-link').show();
		}
	},

	save: function(e) {
		ArticleComments.log('begin: save');
		e.preventDefault();
		ArticleComments.track('editSave');
		if (ArticleComments.processing) return;

		if ($('#article-comm-form-' + e.data.id)) {

			var textfield = $('#article-comm-textfield-' + e.data.id).attr('readonly', 'readonly');
			if ($.trim(textfield.val()) == '') return;
			var data = {
				action: 'ajax',
				rs: 'ArticleCommentsAjax',
				method: 'axSave',
				article: wgArticleId,
				id: e.data.id,
				wpArticleComment: textfield.val()
			};

			var throbber = $(this).next('.throbber').css('visibility', 'visible');
			$.postJSON(wgScript, data, function(json) {
				throbber.css('visibility', 'hidden');
				if (!json.error) {
					if (json.commentId && json.commentId != 0) {
						//replace
						$('#comm-' + json.commentId).html(json.text)
					}
					//clear error box
					$('#article-comm-info').html('');
				} else {
					//fill error box
					$('#article-comm-info').html(json.msg);
					//reenable textarea
					textfield.removeAttr('readonly');
				}
				ArticleComments.processing = false;
			});
			ArticleComments.processing = true;
		}
		ArticleComments.log('end: save');
	},

	edit: function(e) {
		ArticleComments.log('begin: edit');
		e.preventDefault();
		ArticleComments.track('edit');
		if (ArticleComments.processing) return;

		var data = {
			action: 'ajax',
			rs: 'ArticleCommentsAjax',
			method: 'axEdit',
			article: wgArticleId,
			id: e.target.id.replace(/^comment/, '')
		};

		$.getJSON(wgScript, data, function(json) {
			if (!json.error) {
				$(e.target).closest('.buttons').hide();
				$('#comm-text-' + json.id).html(json.text);
				$('#article-comm-submit-' + json.id).bind('click', {id: json.id}, ArticleComments.save);
			}
			ArticleComments.processing = false;
		});
		ArticleComments.processing = true;
		ArticleComments.log('end: edit');
	},

	reply: function(e) {
		ArticleComments.log('begin: reply');
		e.preventDefault();
		ArticleComments.track('reply');
		if (ArticleComments.processing) return;

		var data = {
			action: 'ajax',
			rs: 'ArticleCommentsAjax',
			method: 'axReply',
			article: wgArticleId,
			id: $(this).closest('li').attr('id').replace(/^comm-/, '')
		};

		$.getJSON(wgScript, data, function(json) {
			if (!json.error) {
				$(e.target).closest('.buttons').hide();
				$('#comm-text-' + json.id).after(json.html);
				$('#article-comm-submit-' + json.id).bind('click', {source: '#article-comm-textfield-' + json.id, parentId: json.id}, ArticleComments.postComment);
				$('#article-comm-textfield-' + json.id).focus();
			} else {
				//TODO: add caption
				$.showModal('', json.msg);
			}
			ArticleComments.processing = false;
		});
		ArticleComments.processing = true;
		ArticleComments.log('end: reply');
	},

	postComment: function(e) {
		ArticleComments.log('begin: postComment');
		e.preventDefault();
		ArticleComments.track('post');
		if (ArticleComments.processing) return;
		if ($.trim($(e.data.source).val()) == '') return;
		$(e.data.source).attr('readonly', 'readonly');

		var data = {
			action: 'ajax',
			rs: 'ArticleCommentsAjax',
			method: 'axPost',
			article: wgArticleId,
			wpArticleComment: $(e.data.source).val()
		};
		if (e.data.parentId) {
			data.parentId = e.data.parentId;
			data.page = $('.article-comments-pagination-link-active').eq(0).attr('page');
		}
		var showall = $.getUrlVar('showall');
		if (showall) {
			data.showall = 1;
		}

		var throbber = $(this).next('.throbber').css('visibility', 'visible');
		$.postJSON(wgScript, data, function(json) {
			throbber.css('visibility', 'hidden');
			if (!json.error) {
				//remove zero comments div
				$('#article-comments-zero').remove();
				$('#article-comments-ul').replaceWith(json.text);
				//pagination
				if (json.pagination != '') {
					$('#article-comments-pagination').show().html('<div>' + json.pagination + '</div>');
				}
				//update counter
				$('#article-comments-counter').text(json.counter);
				//readd events
				ArticleComments.addHover();
				//force to show 'edit' links for owners
				ArticleComments.showEditLink();
				//clear error box
				$('#article-comm-info').html('');
			} else {
				//fill error box
				$('#article-comm-info').html(json.msg);
			}
			$(e.data.source).removeAttr('readonly');
			$(e.data.source).val('');
			ArticleComments.processing = false;
		});
		ArticleComments.processing = true;
		ArticleComments.log('end: postComment');
	},

	setPage: function(e) {
		ArticleComments.log('begin: setPage');
		e.preventDefault();
		var page = parseInt($(this).attr('page'));

		var trackingPage = page;
		var id = $(this).attr('id');
		if (id == 'article-comments-pagination-link-prev') {
			trackingPage = 'prev';
		} else if (id == 'article-comments-pagination-link-next') {
			trackingPage = 'next';
		}
		ArticleComments.track('pageSwitch/' + trackingPage);
		$('#article-comments-pagination-link-' + trackingPage).blur();

		$.getJSON(wgScript + '?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&article=' + wgArticleId, {page: page, order: $('#article-comm-order').attr('value')}, function(json) {
			if (!json.error) {
				$('#article-comments-ul').replaceWith(json.text);
				$('#article-comments-pagination').find('div').html(json.pagination);
				ArticleComments.addHover();
				$('html, body').animate({
						scrollTop: $('#article-comment-header').offset().top
					},
					400
				);
			}
			ArticleComments.processing = false;
		});
		ArticleComments.log('end: setPage');
	},

	linkDelete: function() {
		ArticleComments.track('delete');
	},

	linkHistory: function() {
		ArticleComments.track('history');
	},

	addHover: function() {
		$('.article-comments-pagination-link').bind('click', ArticleComments.setPage).not('.article-comments-pagination-link-active, #article-comments-pagination-link-prev, #article-comments-pagination-link-next').hover(function() {$(this).addClass('accent');}, function() {$(this).removeClass('accent');});
	},

	changeOrder: function() {
		ArticleComments.log('begin: changeOrder');
		if ($(this).hasClass('desc')) {
			ArticleComments.track('orderSwitch/newestFirst');
		} else {
			ArticleComments.track('orderSwitch/newestLast');
		}
		ArticleComments.log('end: changeOrder');
	}
};

//on content ready
wgAfterContentAndJS.push(ArticleComments.init);