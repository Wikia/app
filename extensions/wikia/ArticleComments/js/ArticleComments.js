var ArticleComments = {};

ArticleComments.processing = false;

ArticleComments.add = function(json) {
	$().log('begin: add');
	var node = $('<li>').html(json.text).attr('id', 'comm-' + json.id).addClass('article-comments-li');
	//check order and place for new comment
	if ($('#article-comm-order').attr('value') == 'asc') {
		//add at the end
		node.appendTo('#article-comments-ul');
	} else {
		//add at the beginning
		node.prependTo('#article-comments-ul');
	}
	$('#' + json.id).bind('click', ArticleComments.edit);
	$().log('end: add');
}

ArticleComments.save = function(e) {
	$().log('begin: save');
	e.preventDefault();
	if (ArticleComments.processing) return;
	if ($('#article-comm-form-' + e.data.id)) {
		e.preventDefault();
		WET.byStr('articleAction/postComment');
		var textfield = $('#article-comm-textfield-' + e.data.id).attr('readonly', 'readonly');
		$.getJSON(wgScript + '?action=ajax&rs=ArticleComment::axSave&article=' + wgArticleId + "&id=" + e.data.id, {wpArticleComment: textfield.val()}, function(json) {
			$().log(json);
			if (!json.error) {
				if (json.commentId && json.commentId != 0) {
					//replace
					$('#comm-' + json.commentId).html(json.text)
					$('#' + json.commentId).bind('click', ArticleComments.edit);
				} else {
					//add
					ArticleComments.add(json);
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
	if (ArticleComments.processing) return;
	$(e.data.source).attr('readonly', 'readonly');
	$.getJSON(wgScript + '?action=ajax&rs=ArticleComment::axPost&article=' + wgArticleId, {wpArticleComment: $(e.data.source).val()}, function(json) {
		$().log(json);
		if (!json.error) {
			//remove zero comments div
			$('#article-comments-zero').remove();
			ArticleComments.add(json);
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

ArticleComments.init = function() {
	$('#article-comm-submit-top').bind('click', {source: '#article-comm-top'}, ArticleComments.postComment);
	$('#article-comm-submit-bottom').bind('click', {source: '#article-comm-bottom'}, ArticleComments.postComment);
	$('#article-comm-form-select').bind('change', function() {this.submit()});
	$('.article-comm-edit').bind('click', ArticleComments.edit);
}
//on DOM ready
$(ArticleComments.init);