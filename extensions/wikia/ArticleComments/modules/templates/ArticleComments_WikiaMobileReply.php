<form method=post class=commFrm>
	<input type=hidden name=wpArticleId value="<?= $wg->title->getArticleID() ;?>"/>
	<textarea placeholder="<?= $wf->Msg('wikiamobile-article-comments-placeholder') ;?>" name=wpArticleComment class=wkInp></textarea>
	<input type=submit class='commSbt wkBtn main' name=wpArticleSubmit value="<?= $wf->Msg('wikiamobile-article-comments-post') ;?>"/>
</form>