<header id="WikiaPageHeader" class="WikiaPageHeader separator">
	<h1><?= wfMsgForContent( 'mobileproducts' ) ;?></h1>
	
	<div id="WikiHeader" class="WikiHeader">
		<? if ( !empty( $languages ) ) :?>
			<nav>
				<ul>
					<li>
						<img src="<?= $wgBlankImgUrl ;?>" class="chevron" width="0" height="0"><?= wfMsgForContent('mobileproducts-language') ;?>
						<ul class="subnav">
							<? foreach ( $languages as $lang ) :?>
								<li>
									<a href="<?= $lang['href'] ;?><?= ( !empty( $product ) ) ? "/{$product}" : null ;?>"><?= $lang['language'] ;?></a>
								</li>
							<? endforeach ;?>
						</ul>
					</li>
				</ul>
			</nav>
		<? endif ;?>
	</div>
	
	<?= wfRenderPartial("Search", "Index", array ( "placeholder" => wfMsgForContent( 'wikiasearch-search-wikia' ), "fulltext" => "0", "wgBlankImgUrl" => $wgBlankImgUrl, "wgTitle" => $wgTitle ) ); ?>
</header>