<form method=post id=wkCommFrm>
	<textarea placeholder="<?= $wf->Msg('wikiamobile-article-comments-placeholder') ;?>" name=wpArticleComment id=wkCommTxt></textarea>
	<input type=submit name=wpArticleSubmit class=wkBtn value="<?= $wf->Msg('wikiamobile-article-comments-post') ;?>"/>
</form>