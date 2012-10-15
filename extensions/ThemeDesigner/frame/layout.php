<nav id="designer-nav">
	<ul>
		<li><span><?php echo htmlspecialchars(wfMsg('themedesigner')); ?></span></li>
		<li><a href="<?php echo Title::newMainPage()->escapeLocalURL(); ?>"><?php echo htmlspecialchars(wfMsg('mainpage-description')); ?></a></li>
		<li><a href="<?php echo SpecialPage::getTitleFor('Recentchanges')->escapeLocalURL(); ?>"><?php echo htmlspecialchars(wfMsg('recentchanges')); ?></a></li>
		<li><a href="<?php echo SpecialPage::getTitleFor('Specialpages')->escapeLocalURL(); ?>"><?php echo htmlspecialchars(wfMsg('specialpages')); ?></a></li>
	</ul>
</nav>
<div id=designer-interface>
	<div id=designer-interface-bar class=secondary-bar>
		<?php echo htmlspecialchars(wfMsg('themedesigner-interface-skinlabel')) ?>
<?php
		$validSkinNames = Skin::getUsableSkins();
		foreach ( $validSkinNames as $skinkey => &$skinname ) {
			$msgName = "skinname-{$skinkey}";
			$localisedSkinName = wfMsg( $msgName );
			if ( !wfEmptyMsg( $msgName, $localisedSkinName ) ) {
				$skinname = htmlspecialchars( $localisedSkinName );
			}
		}
		asort( $validSkinNames );
		/*		if ( empty($par) || !isset($validSkinNames[strtolower($par)]) ) {
			$par = $GLOBALS["wgUser"]->getSkin()->skinname;
		}
		$skinSelect = new XmlSelect( 'skin', false, strtolower($par) );*/
		$skinSelect = new XmlSelect( 'skin', false, $GLOBALS["wgUser"]->getSkin()->skinname );
		$skinSelect->addOptions( array_combine( array_values($validSkinNames), array_keys($validSkinNames) ) );
		echo $skinSelect->getHTML(); ?>
	</div>
	<h2>Basic</h2>
	<section>
		...
	</section>
	<h2>Advanced</h2>
	<section>
		<textarea rows=15 id=advanced-css></textarea>
	</section>
</div>
<div id=designer-viewer>
	<noscript><?php echo wfMsgWikiHtml('themedesigner-noscript'); ?></noscript>
	<div id=designer-viewer-bar class=secondary-bar>
	</div>
	<div id=designer-wrongskinmessage><?php echo wfMsgWikiHtml('themedesigner-wrongskin'); ?></div>
	<div id=designer-viewer-framewrapper></div>
</div>
