<form method=post class=commFrm>
	<input type=hidden name=wpArticleId value="<?= $wg->title->getArticleID() ;?>"/>
	<textarea placeholder="<?= $wf->Msg('wikiamobile-article-comments-placeholder') ;?>" name=wpArticleComment class=commTxt></textarea>
	<input type=submit class='commSbt wkBtn' name=wpArticleSubmit class=wkBtn value="<?= $wf->Msg('wikiamobile-article-comments-post') ;?>"/>
</form>