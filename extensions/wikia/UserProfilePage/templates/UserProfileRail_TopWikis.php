<section class="UserProfileRailModule_TopWikis">
	<table>
		<thead>
			<tr>
				<th colspan="2">
					<h2><?= wfMsg( 'userprofilepage-top-wikis-title', $userName ) ;?></h2>
				</th>
				<th>
					<h2><?= wfMsg( 'userprofilepage-top-wikis-edit-count' ) ;?></h2>
				</th>
			</tr>
		</thead>
		<tbody>
			<? $counter = 0 ;?>
			<? foreach( $topWikis as $wikiId => $wikiData ) :?>
				<tr>
					<td class="rank">
						<span class="counter">#<?= ++$counter ;?></span>
						<? if( $userIsOwner )  :?>
							<span class="hide-control"><a href="#" class="HideButton" title="<?= $wikiId ;?>"><?= wfMsg( 'userprofilepage-top-wikis-hide-label' ) ;?></a></span>
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
						<span class="percentage-bar"><?= $wikiData[ 'editCount' ] ;?></span>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<? $hiddenCount = count($hiddenTopWikis) ;?>
	<? if( $userIsOwner && $hiddenCount ) :?>
		<a class="more view-all"><?= wfMsgExt( 'userprofilepage-top-wikis-hidden-see-more', array( 'parsemag' ), $hiddenCount ); ?></a>

		<ul id="profile-top-pages-hidden">
			<? foreach( $hiddenTopWikis as $wikiId => $wikiData ) :?>
				<li>
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
						<a class="UnhideButton" title="<?= $wikiId; ?>"><?= wfMsg( 'userprofilepage-top-wikis-unhide-label' ) ;?></a>
					</div>
				</li>
			<? endforeach; ?>
		</ul>
	<? endif ;?>
</section>