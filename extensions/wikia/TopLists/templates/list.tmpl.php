<div id="toplists-list-body">
	<? if ( !empty( $relatedImage ) ) :?>
		<div class="thumb tright">
			<div class="thumbinner" style="width:200px;">
				<a href="<?= ( $relatedTitle instanceof Title ) ? $relatedTitle->getLocalURL() : "/wiki/File:{$relatedImage[ 'name' ]}\" class=\"image" ;?>"
				   title="<?= ( $relatedTitle instanceof Title ) ? $relatedTitle->getText() : $relatedImage[ 'name' ] ;?>">
					<img alt="<?= ( $relatedTitle instanceof Title ) ? $relatedTitle->getText() : $relatedImage[ 'name' ] ;?>"
					     src="<?= $relatedImage[ 'url' ] ;?>"
					     border="0"
					     class="thumbimage" />
				</a>
				<div class="thumbcaption">
					<div class="magnify">
						<a href="/wiki/File:<?= $relatedImage[ 'name' ] ;?>" class="internal" title="<?= wfMsgForContent( 'thumbnail-more' ); ?>">
							<img src="<?= wfBlankImgUrl() ;?>" class="sprite details" width="16" height="16" alt="" />
						</a>
					</div>
					<? if( $relatedTitle instanceof Title ) :?>
						<a href="<?= $relatedTitle->getLocalURL() ;?>" title="<?= $relatedTitle->getText() ;?>"><?= $relatedTitle->getText() ;?></a>
					<? endif ;?>
				</div>
			</div>
		</div>
	<? elseif( $relatedTitle instanceof Title ) :?>
		<div class="ListRelatedArticle">
			<a href="<?= $relatedTitle->getLocalURL() ;?>" title="<?= $relatedTitle->getText() ;?>"><?= $relatedTitle->getText() ;?></a>
		</div>
	<? endif ;?>

	<ul>
		<? foreach ( $list->getItems() as $index => $item ) :?>
			<li>
				<div class="ItemNumber">
					<span>#<?= ( ++$index ) ;?></span>
					<div class="button item-vote-button" id="<?= $item->getTitleText() ;?>"><?= wfMsgForContent( 'toplists-list-vote-up' ) ;?></div>
				</div>
				<div class="ItemContent">
					<?= $item->getParsedContent() ;?>
					<span class="author"><?= wfMsgForContent( 'toplists-list-created-by', array( $item->getCreatorUserName() )) ;?></span>
				</div>
				<div class="ItemVotes"><?= wfMsgForContent( 'toplists-list-votes-num', array( $item->getVotesCount() ) ) ;?></div>
			</li>
		<? endforeach; ?>
	</ul>
</div>