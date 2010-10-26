<section class="UserProfileRailModule_TopWikis">
	<table cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th colspan="2"><?= wfMsg( 'userprofilepage-top-wikis-title', $userName ) ;?></th>
				<th><?= wfMsg( 'userprofilepage-top-wikis-edit-count' ) ;?></th>
			</tr>
		</thead>
		<tbody>
			<? $counter = 0 ;?>
			<? foreach( $topWikis as $wikiId => $wikiData ) :?>
				<tr class="<?= ( ( ++$counter % 2 ) == 0) ? 'odd' : null;?>">
					<td class="rank">
						<span class="counter">#<?= $counter ;?></span>
						<? if( $userIsOwner )  :?>
							<span class="hide-control">
								<a class="HideButton" title="<?= wfMsg( 'userprofilepage-top-wikis-hide-label' ) ;?>" data-id="<?= $wikiId ;?>">
									<img class="sprite-small close" src="<?= wfBlankImgUrl() ;?>" alt="<?= wfMsg( 'userprofilepage-top-wikis-hide-label' ) ;?>"/>
								</a>
							</span>
						<? endif; ?>
					</td>
					<td class="wordmark">
						<a href="<?= $wikiData[ 'wikiUrl' ] ;?><?= $userPageUrl ;?>" title="<?= $wikiData[ 'wikiName' ] ;?>">
							<? if( !empty( $wikiData[ 'wikiLogo' ] ) ) :?>
								<img alt="<?= $wikiData[ 'wikiName' ] ;?>" src="<?= $wikiData[ 'wikiLogo' ] ;?>" width="80" height="20"/>
							<? else :?>
								<?= $wikiData[ 'wikiName' ] ;?>
							<? endif ;?>
						</a>
					</td>
					<td class="edit-count">
						<div class="percentage-bar" style="width: <?= round( ( $wikiData[ 'editCount' ] / $maxEdits ) * 100 ) - 10 ;?>%"><?= $wikiData[ 'editCount' ] ;?></div>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	
	<? $hiddenCount = count($hiddenTopWikis) ;?>
	<? if( $userIsOwner && $hiddenCount ) :?>
		<ul id="profile-top-wikis-hidden">
			<li class="unhide-link">
				<a class="more view-all">
					<?= wfMsgExt( 'userprofilepage-top-wikis-hidden-see-more', array( 'parsemag' ), $hiddenCount ); ?>
					<img src="<?= wfBlankImgUrl() ;?>" class="chevron" />
				</a>
			</li>
			<? $counter = 0 ;?>
			<? foreach( $hiddenTopWikis as $wikiId => $wikiData ) :?>
				<li class="hidden-wiki<?= ( $counter++ == 0 ) ? ' first' : null;?>">
					<div class="wordmark">
						<a href="<?= $wikiData[ 'wikiUrl' ] ;?><?= $userPageUrl ;?>" title="<?= $wikiData[ 'wikiName' ] ;?>">
							<? if( !empty( $wikiData[ 'wikiLogo' ] ) ) :?>
								<img alt="<?= $wikiData[ 'wikiName' ] ;?>" src="<?= $wikiData[ 'wikiLogo' ] ;?>" width="80" height="20"/>
							<? else :?>
								<?= $wikiData[ 'wikiName' ] ;?>
							<? endif ;?>
						</a>
					</div>
					<div class="unhide-control">
						<a class="UnhideButton" title="<?= wfMsg( 'userprofilepage-top-wikis-unhide-label' ) ;?>" data-id="<?= $wikiId; ?>">
							<img class="sprite-small add" src="<?= wfBlankImgUrl() ;?>" alt="<?= wfMsg( 'userprofilepage-top-wikis-unhide-label' ) ;?>"/>
							<?= wfMsg( 'userprofilepage-top-wikis-unhide-label' ) ;?>
						</a>
					</div>
				</li>
			<? endforeach; ?>
		</ul>
	<? endif ;?>
</section>