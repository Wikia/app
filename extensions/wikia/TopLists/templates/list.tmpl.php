<p><?= htmlspecialchars( $description ) ?></p>
<div id="toplists-list-body">
	<input type="hidden" id="top-list-title" value="<?= Sanitizer::encodeAttribute( $listTitle ) ?>">
	<? if ( !empty( $relatedImage ) ) :?>
		<div class="thumb tright">
			<div class="thumbinner" style="width:200px;">
				<a href="<?= Sanitizer::encodeAttribute( !is_null( $relatedTitleData ) ? $relatedTitleData['localURL'] : '/wiki/File:' . urlencode( $relatedImage[ 'name' ] ) ); ?>" class="image"
				   title="<?= Sanitizer::encodeAttribute( !is_null( $relatedTitleData ) ? $relatedTitleData['text'] : $relatedImage[ 'name' ] ); ?>">
					<img alt="<?= Sanitizer::encodeAttribute( !is_null( $relatedTitleData ) ? $relatedTitleData['text'] : $relatedImage[ 'name' ] ); ?>"
					     src="<?= Sanitizer::encodeAttribute( $relatedImage[ 'url' ] ); ?>"
					     border="0"
					     class="thumbimage" />
				</a>
				<div class="thumbcaption">
					<div class="magnify">
						<a href="/wiki/File:<?= Sanitizer::encodeAttribute( urlencode( $relatedImage[ 'name' ] ) ); ?>" class="internal" title="<?= wfMsgForContent( 'thumbnail-more' ); ?>">
							<img src="<?= wfBlankImgUrl() ;?>" class="sprite details" width="16" height="16" alt="" />
						</a>
					</div>
					<? if( !is_null( $relatedTitleData ) ) :?>
						<a href="<?= Sanitizer::encodeAttribute( $relatedTitleData['localURL'] ) ?>" title="<?= Sanitizer::encodeAttribute( $relatedTitleData['text'] ) ?>"><?= htmlspecialchars( $relatedTitleData['text'] ) ?></a>
					<? endif ;?>
				</div>
			</div>
		</div>
	<? elseif( !is_null( $relatedTitleData ) ) :?>
		<div class="ListRelatedArticle">
			<?= wfMessage( 'toplists-list-related-to' )->inContentLanguage()->escaped(); ?> <a href="<?= Sanitizer::encodeAttribute( $relatedTitleData['localURL'] ) ?>" title="<?= Sanitizer::encodeAttribute( $relatedTitleData['text'] ) ?>"><?= htmlspecialchars( $relatedTitleData['text'] ) ?></a>
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
					<button class="VoteButton" id="<?= Sanitizer::encodeAttribute( $item->getTitle()->getSubpageText() ); ?>">
						<img src="<?= wfBlankImgUrl() ;?>" class="chevron"/>
						<?= wfMessage( 'toplists-list-vote-up' )->inContentLanguage()->escaped(); ?>
					</button>
				</div>
				<div class="ItemContent">
					<?= $item->getParsedContent() ;?>
					<span class="author"><?= wfMessage( 'toplists-list-created-by', $item->getEditor()->getName() )->inContentLanguage()->parse(); ?></span>
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
									<span><?= wfMessage( 'toplists-list-hotitem-count', $count, TopListHelper::formatTimeSpan( $latest - $oldest ) )->inContentLanguage()->escaped(); ?></span>
								</div>
							<? endif ;?>
						<? endif ;?>
					<? endif ;?>
				</div>
				<div class="ItemVotes"><?= wfMessage( 'toplists-list-votes-num', $item->getVotesCount() )->inContentLanguage()->parse(); ?></div>
			</li>
		<? endforeach; ?>
			<li>
				<form class="NewItemForm">
					<input type="text" id="toplist-new-item-name" placeholder="<?= wfMessage( 'toplists-list-add-item-name-label' )->inContentLanguage()->escaped(); ?>"/>
					<br>
					<button title="<?= wfMessage( 'toplists-list-add-item-label' )->inContentLanguage()->escaped(); ?>" class="AddButton">
						<img class="osprite icon-add" src="<?= wfBlankImgUrl() ;?>" alt="<?= wfMessage( 'toplists-list-add-item-label' )->inContentLanguage()->escaped(); ?>"/>
						<?= wfMessage( 'toplists-list-add-item-label' )->inContentLanguage()->escaped(); ?>
					</button>
					<p class="error"></p>
				</form>
			</li>
	</ul>
	<div class="create-new-list">
		<h5><?= wfMessage( 'toplists-create-heading' )->inContentLanguage()->parse(); ?></h5>
		<?= Wikia::specialPageLink('CreateTopList', 'toplists-create-button-msg', 'wikia-button createtoplist', 'blank.gif', 'toplists-create-button-msg', 'sprite new'); ?>
	</div>
</div>
