<section class="UserProfileRailModule_TopPages">
	<h2><?= wfMsg( 'userprofilepage-top-pages-title', array( $userName, $wikiName ) ) ;?></h2>
	<? if( count( $topPages ) ) :?>
		<? foreach( $topPages as $pageId => $page ) :?>
			<div class="top-page-item">
				<a href="<?= $page['url'] ;?>" title="<?= $page['title'] ;?>">
					<div class="top-page-item-image">
						<img src="<?= $topPageImages[ $pageId ][ 0 ][ 'url' ] ;?>" alt="<?= $page['title'] ;?>">
					</div>
					<details><?= $page['title'] ;?></details>
				</a>
			</div>
		<? endforeach ;?>
		
		<? $hiddenCount = count($hiddenTopPages) ;?>
		<? if( $userIsOwner && $hiddenCount ) :?>
			<a class="more view-all">
				<?= wfMsgExt( 'userprofilepage-top-pages-hidden-see-more', array( 'parsemag' ), $hiddenCount ); ?>
				<img src="<?= wfBlankImgUrl() ;?>" class="chevron" />
			</a>

			<ul id="profile-top-pages-hidden">
				<? foreach( $hiddenTopPages as $pageId => $page ) :?>
					<li>
						<div class="page-title">
							<a href="<?= $page['url'] ;?>" title="<?= $page['title'] ;?>"><?= $page['title'] ;?></a>
						</div>
						<div class="unhide-control">
							<a class="UnhideButton" title="<?= $page['title'] ;?>"><?= wfMsg( 'userprofilepage-top-page-unhide-label' ) ;?></a>
						</div>
					</li>
				<? endforeach; ?>
			</ul>
		<? endif ;?>
	<? else :?>
		<span><?= wfMsg( 'userprofilepage-top-pages-default', $specialRandomLink ) ;?></span>
	<? endif ;?>
</section>