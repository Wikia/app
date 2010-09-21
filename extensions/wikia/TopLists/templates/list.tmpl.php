<div id="toplists-list-body">
	<input type="hidden" id="top-list-title" value="<?= $list->getTitle()->getText() ;?>" />
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
			<?= wfMsgForContent( 'toplists-list-related-to' ) ;?> <a href="<?= $relatedTitle->getLocalURL() ;?>" title="<?= $relatedTitle->getText() ;?>"><?= $relatedTitle->getText() ;?></a>
		</div>
	<? endif ;?>

	<ul>
		<?
		$items = $list->getItems();
		$number1Found = false;
		$hotFound = false;
		?>
		<? foreach ( $items as $index => $item ) :?>
			<li>
				<?
				$index++;
				$isNumber1 = false;

				if (
					$index == 1 &&
					!$number1Found &&
					!empty( $items[ $index ] ) &&
					$items[ $index ]->getVotesCount() != $item->getVotesCount()
				) {
					$isNumber1 = true;
					$number1Found = true;
				}
				?>
				<div class="ItemNumber<?= ( $isNumber1 ) ? ' No1' : ' NotVotable' ;?>">
					<span>#<?= $index ;?></span>
					<button class="VoteButton" id="<?= $item->getTitle()->getSubpageText() ;?>">
						<img src="<?= wfBlankImgUrl() ;?>" class="chevron"/>
						<?= wfMsgForContent( 'toplists-list-vote-up' ) ;?>
					</button>
				</div>
				<div class="ItemContent">
					<?= $item->getParsedContent() ;?>
					<span class="author"><?= wfMsgExt( 'toplists-list-created-by', array( 'parse', 'content' ), array( $item->getEditor()->getName() ) ) ;?></span>
					<? if ( /*$isNumber1 && */!$hotFound ) :?>
						<?
						$timeStamps = $item->getVotesTimestamps();
						?>
						<? if ( !empty( $timeStamps ) ) :?>
							<?
							$latest = max( $timeStamps );
							$lookBackAt = $latest - TOPLISTS_HOT_MIN_TIMESPAN;
							$oldest = $latest;
							$count = 0;
							
							foreach ( $timeStamps as $tms ) {
								if( $tms >= $lookBackAt ) {
									$count++;

									if( $tms < $oldest ) {
										$oldest = $tms;
									}
								}
							}
							?>
							<? if ( $count >= TOPLISTS_HOT_MIN_COUNT ) :?>
								<? $hotFound = true ;?>
								<div class="HotItem">
									<span><?= wfMsgExt( 'toplists-list-hotitem-count', array( 'parsemag', 'content' ), array( $count, TopListHelper::formatTimeSpan( $latest - $oldest ) ) ) ;?></span>
								</div>
							<? endif ;?>
						<? endif ;?>
					<? endif ;?>
				</div>
				<div class="ItemVotes"><?= wfMsgExt( 'toplists-list-votes-num', array( 'parsemag', 'content' ), array( $item->getVotesCount() ) ) ;?></div>
			</li>
		<? endforeach; ?>
			<li>
				<form class="NewItemForm">
					<input type="text" id="toplist-new-item-name" placeholder="<?= wfMsgForContent( 'toplists-list-add-item-name-label' ) ;?>"/>
					<br>
					<button title="<?= wfMsgForContent( 'toplists-list-add-item-label' ) ;?>" class="AddButton">
						<img class="osprite icon-add" src="<?= wfBlankImgUrl() ;?>" alt = "<?= wfMsgForContent( 'toplists-list-add-item-label' ) ;?>"/>
						<?= wfMsgForContent( 'toplists-list-add-item-label' ) ;?>
					</button>
					<p class="error"></p>
				</form>
			</li>
	</ul>
</div>
