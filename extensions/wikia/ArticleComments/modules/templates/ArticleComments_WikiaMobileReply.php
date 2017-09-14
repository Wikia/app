<form method=post class="commFrm wkForm">
	<input type=hidden name=wpArticleId value="<?= $wg->title->getArticleID() ;?>"/>
	<textarea class=commText placeholder="<?= wfMessage( 'wikiamobile-article-comments-placeholder' )->escaped(); ?>" name=wpArticleComment></textarea>
	<input type=submit class='commSbt wkBtn main' name=wpArticleSubmit value="<?= wfMessage( 'wikiamobile-article-comments-post' )->escaped() ;?>"/>
</form>