<form method=post class=article-comm-form id=article-comm-form>
	<input type=hidden name=wpArticleId value="<?= $title->getArticleId() ;?>" />
	<textarea type=text placeholder="<?= $wf->Msg('wikiamobile-article-comments-placeholder') ;?>" name=wpArticleComment id=article-comm></textarea>
	<input type=submit name=wpArticleSubmit id=article-comm-submit class=wikia-button value="<?= $wf->Msg('wikiamobile-article-comments-post') ;?>" />
</form>