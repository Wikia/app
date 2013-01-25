<form method=post class="commFrm wkForm">
	<input type=hidden name=wpArticleId value="<?= $wg->title->getArticleID() ;?>"/>
	<textarea class=commText placeholder="<?= $wf->Msg('wikiamobile-article-comments-placeholder') ;?>" name=wpArticleComment></textarea>
	<input type=submit class='commSbt wkBtn main' name=wpArticleSubmit value="<?= $wf->Msg('wikiamobile-article-comments-post') ;?>"/>
</form>