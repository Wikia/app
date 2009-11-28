var ArticleComments = {};

ArticleComments.processing = false;

ArticleComments.add = function(json) {
	$().log('begin: add');
	//check order and place for new comment
	if ($('#blog-comm-order').attr('value') == 'asc') {
		//add at the end
		$('<li>').html(json.text).attr('id', 'comm-' + json.id).appendTo('#blog-comments-ul');
	} else {
		//add at the beginning
		$('<li>').html(json.text).attr('id', 'comm-' + json.id).prependTo('#blog-comments-ul');
	}
	$('#' + json.id).bind('click', ArticleComments.edit);
	$().log('end: add');
}

ArticleComments.save = function(e) {
	$().log('begin: save');
	e.preventDefault();
	if (ArticleComments.processing) return;
	if ($('#blog-comm-form-' + e.data.id)) {
		e.preventDefault();
		WET.byStr('articleAction/postComment');
		var textfield = $('#blog-comm-textfield-' + e.data.id).attr('readonly', 'readonly');
		$.getJSON(wgScript + '?action=ajax&rs=ArticleComment::axSave&article=' + wgArticleId + "&id=" + e.data.id, {wpArticleComment: $(textfield).val()}, function(json) {
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
				$('#blog-comm-bottom-info').html('');
			} else {
				//fill error box
				$('#blog-comm-bottom-info').html(json.msg);
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
			$('#blog-comm-submit-' + json.id).bind('click', {id: json.id}, ArticleComments.save);
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
		if (!json.error) {
			//remove zero comments div
			$('#blog-comments-zero').remove();
			ArticleComments.add(json);
			//clear error box
			$('#blog-comm-bottom-info').html('');
		} else {
			//fill error box
			$('#blog-comm-bottom-info').html(json.msg);
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
	$('#blog-comm-submit-top').bind('click', {source: '#blog-comm-top'}, ArticleComments.postComment);
	$('#blog-comm-submit-bottom').bind('click', {source: '#blog-comm-bottom'}, ArticleComments.postComment);
	$('#blog-comm-form-select').bind('change', function() {this.submit()});
	$('.blog-comm-edit').bind('click', ArticleComments.edit);
}
//on DOM ready
$(ArticleComments.init);