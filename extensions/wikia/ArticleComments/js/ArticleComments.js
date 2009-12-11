var ArticleComments = {};

ArticleComments.processing = false;

ArticleComments.save = function(e) {
	$().log('begin: save');
	e.preventDefault();
	if (ArticleComments.processing) return;
	if ($('#article-comm-form-' + e.data.id)) {
		e.preventDefault();
		WET.byStr('article/editSave');
		var textfield = $('#article-comm-textfield-' + e.data.id).attr('readonly', 'readonly');
		$.postJSON(wgScript, {action: 'ajax', rs: 'ArticleComment::axSave', article: wgArticleId, id: e.data.id, wpArticleComment: textfield.val()}, function(json) {
			$().log(json);
			if (!json.error) {
				if (json.commentId && json.commentId != 0) {
					//replace
					$('#comm-' + json.commentId).html(json.text)
					$('#' + json.commentId).bind('click', ArticleComments.edit);
					ArticleComments.bind();
				}
				//clear error box
				$('#article-comm-bottom-info').html('');
			} else {
				//fill error box
				$('#article-comm-bottom-info').html(json.msg);
				//reenable textarea
				textfield.removeAttr('readonly');
			}
			if (typeof TieDivLibrary != 'undefined') {
				TieDivLibrary.calculate();
			}
			ArticleComments.processing = false;
		});
		ArticleComments.processing = true;
	}
	$().log('end: save');
}

ArticleComments.edit = function(e) {
	$().log('begin: edit');
	e.preventDefault();
	WET.byStr('article/edit');
	if (ArticleComments.processing) return;
	$.getJSON(wgScript + '?action=ajax&rs=ArticleComment::axEdit&id=' + e.target.id + '&article=' + wgArticleId, function(json) {
		if (!json.error) {
			$('#comm-text-' + json.id).html(json.text);
			$('#article-comm-submit-' + json.id).bind('click', {id: json.id}, ArticleComments.save);
			if (typeof TieDivLibrary != 'undefined') {
				TieDivLibrary.calculate();
			}
		}
		ArticleComments.processing = false;
	});
	ArticleComments.processing = true;
	$().log('end: edit');
};

ArticleComments.postComment = function(e) {
	$().log('begin: postComment');
	e.preventDefault();
	WET.byStr('article/post');
	if (ArticleComments.processing) return;
	$(e.data.source).attr('readonly', 'readonly');
	$.postJSON(wgScript, {action: 'ajax', rs: 'ArticleComment::axPost', article: wgArticleId, wpArticleComment: $(e.data.source).val(), order: $('#article-comm-order').attr('value')}, function(json) {
		$().log(json);
		if (!json.error) {
			//remove zero comments div
			$('#article-comments-zero').remove();
			$('#article-comments-ul').replaceWith(json.text);
			$('.article-comm-edit').bind('click', ArticleComments.edit);
			//pagination
			$('#article-comments-pagination').html('<div>' + json.pagination + '</div>');
			//readd events
			$('.article-comments-pagination-link').bind('click', ArticleComments.setPage).not('.article-comments-pagination-link-active').hover(function() {$(this).addClass('accent');}, function() {$(this).removeClass('accent');});;
			ArticleComments.bind();
			//clear error box
			$('#article-comm-bottom-info').html('');
		} else {
			//fill error box
			$('#article-comm-bottom-info').html(json.msg);
		}
		$(e.data.source).removeAttr('readonly');
		$(e.data.source).val('');
		if (typeof TieDivLibrary != 'undefined' ) {
			TieDivLibrary.calculate();
		}
		ArticleComments.processing = false;
	});
	ArticleComments.processing = true;
	$().log('end: postComment');
}

ArticleComments.setPage = function(e) {
	$().log('begin: setPage');
	e.preventDefault();
	var page = $(this).attr('page');
	WET.byStr('article/pageSwitch/' + page);
	$('#article-comments-pagination-link-' + page).blur();

	$.getJSON(wgScript + '?action=ajax&rs=ArticleCommentList::axGetComments&article=' + wgArticleId, {page: page, order: $('#article-comm-order').attr('value')}, function(json) {
		$().log(json);
		if (!json.error) {
			$('.article-comments-pagination-link').removeClass('article-comments-pagination-link-active accent').unbind('mouseenter mouseleave');
			$('#article-comments-pagination-link-' + page).addClass('article-comments-pagination-link-active');
			$('.article-comments-pagination-link').not('.article-comments-pagination-link-active').hover(function() {$(this).addClass('accent');}, function() {$(this).removeClass('accent');});
			$('#article-comments-ul').replaceWith(json.text);
			$('.article-comm-edit').bind('click', ArticleComments.edit);
			ArticleComments.bind();
		}
		ArticleComments.processing = false;
	});
	$().log('end: setPage');
}

ArticleComments.linkDelete = function() {
	WET.byStr('article/delete');
}

ArticleComments.linkHistory = function() {
	WET.byStr('article/history');
}

ArticleComments.bind = function() {
	$('.article-comm-delete').bind('click', ArticleComments.linkDelete);
	$('.article-comm-history').bind('click', ArticleComments.linkHistory);
}

ArticleComments.init = function() {
	$('#article-comm-submit-top').bind('click', {source: '#article-comm-top'}, ArticleComments.postComment);
	$('#article-comm-submit-bottom').bind('click', {source: '#article-comm-bottom'}, ArticleComments.postComment);
	$('#article-comm-order').bind('change', function() {$('#article-comm-form-select').submit()});
	$('.article-comm-edit').bind('click', ArticleComments.edit);
	$('.article-comments-pagination-link').bind('click', ArticleComments.setPage).not('.article-comments-pagination-link-active').hover(function() {$(this).addClass('accent');}, function() {$(this).removeClass('accent');});
	$('#article-comments-pagination div').css('backgroundColor', $('#wikia_page').css('backgroundColor'));
}
//on content ready
wgAfterContentAndJS.push(ArticleComments.init);