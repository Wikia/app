<? if ( !empty( $topWikis ) ) :?>
	<div id="profile-top-wikis-body" class="UserProfileRailModule_TopWikis">
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
					<tr class="<?= ( ( ++$counter % 2 ) == 0) ? 'odd' : null;?><?= ($userIsOwner) ? ' removable' : null ;?>">
						<td class="rank">
							<span class="counter">#<?= $counter ;?></span>
							<? if( $userIsOwner )  :?>
								<span class="hide-control">
									<? if ( $wikiId != $currentWikiId ) :?>
										<a class="HideButton" title="<?= wfMsg( 'userprofilepage-top-wikis-hide-label' ) ;?>" data-id="<?= $wikiId ;?>">
											<img class="sprite-small close" src="<?= wfBlankImgUrl() ;?>" alt="<?= wfMsg( 'userprofilepage-top-wikis-hide-label' ) ;?>"/>
										</a>
									<? else :?>
										<a class="LockButton" title="<?= wfMsg( 'userprofilepage-top-wikis-locked-label' ) ;?>">
											<img class="sprite lock" src="<?= wfBlankImgUrl() ;?>" alt="<?= wfMsg( 'userprofilepage-top-wikis-locked-label' ) ;?>"/>
										</a>
									<? endif ;?>
								</span>
							<? endif; ?>
						</td>
						<td class="wordmark">
							<a href="<?= $wikiData[ 'wikiUrl' ] ;?><?= $userPageUrl ;?>" title="<?= $wikiData[ 'wikiName' ] ;?>">
								<? if( !empty( $wikiData[ 'wikiLogo' ] ) ) :?>
									<img alt="<?= $wikiData[ 'wikiName' ] ;?>" src="<?= $wikiData[ 'wikiLogo' ] ;?>" width="80" height="20"/>
								<? elseif( !empty( $wikiData['wikiWordmarkText'] ) ) :?>
									<?= $wikiData[ 'wikiWordmarkText' ] ;?>
								<? else :?>
									<?= $wikiData[ 'wikiName' ] ;?>
								<? endif ;?>
							</a>
						</td>
						<td class="edit-count">
							<? $percentageWidth = round( ( $wikiData[ 'editCount' ] / $maxEdits ) * 100 ) - 10 ;?>
							<div class="percentage-bar"<?= ( $percentageWidth < 3 ) ? null : " style=\"width: {$percentageWidth}%;\"" ;?>><?= $wikiData[ 'editCount' ] ;?></div>
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>

		<? $hiddenCount = count($hiddenTopWikis) ;?>
		<? if( $userIsOwner && $hiddenCount ) :?>
			<ul class="user-profile-action-menu" id="profile-top-wikis-hidden">
				<li class="unhide-link">
					<a class="more view-all">
						<?= wfMsgExt( 'userprofilepage-top-wikis-hidden-see-more', array( 'parsemag' ), $hiddenCount ); ?>
						<img src="<?= wfBlankImgUrl() ;?>" class="chevron" />
					</a>
				</li>
				<? $counter = 0 ;?>
				<? foreach( $hiddenTopWikis as $wikiId => $wikiData ) :?>
					<li class="hidden-item<?= ( $counter++ == 0 ) ? ' first' : null;?>">
						<div class="item-name">
							<a href="<?= $wikiData[ 'wikiUrl' ] ;?><?= $userPageUrl ;?>" title="<?= $wikiData[ 'wikiName' ] ;?>">
								<? if( !empty( $wikiData[ 'wikiLogo' ] ) ) :?>
									<img alt="<?= $wikiData[ 'wikiName' ] ;?>" src="<?= $wikiData[ 'wikiLogo' ] ;?>" width="80" height="20"/>
								<? elseif( !empty( $wikiData['wikiWordmarkText'] ) ) :?>
									<?= $wikiData[ 'wikiWordmarkText' ] ;?>
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
	</div>
<? endif ;?>