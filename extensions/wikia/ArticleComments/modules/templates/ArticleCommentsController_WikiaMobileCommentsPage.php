<? if ( !empty( $error ) ) :?>
<div class=wkErr><?= $error ;?></div>
<? endif ;?>
<? if ( !$isReadOnly ) :?><?= $app->getView( 'ArticleComments', 'WikiaMobileReply', array( 'title' => $title ) ) ;?><? endif ;?>
<? if ( $pagesCount > 1 && $countCommentsNested > 0) :?>
	<a id=commPrev class="lbl<?= ( !empty( $prevPage ) ) ? ' pag" href="?page=' . $prevPage . '#article-comments"' : '' ?>"><?= wfMsg( 'wikiamobile-article-comments-prev' ) ;?></a>
	<? endif ;?>
<ul id=wkComUl>
	<? if ( $countCommentsNested > 0 ) :?><?= $app->getView( 'ArticleComments', 'WikiaMobileCommentList', array( 'commentListRaw' => $commentListRaw, 'page' => $page, 'useMaster' => false ) )->render();?><? endif ;?>
</ul>
<? if ( $pagesCount > 1 && $countCommentsNested > 0 ) :?>
	<a id=commMore class="lbl<?= ( !empty( $nextPage ) ) ? ' pag" href="?page=' . $nextPage . '#article-comments"' : '' ?>"><?= wfMsg( 'wikiamobile-article-comments-more' ) ;?></a>
<? endif ;?>