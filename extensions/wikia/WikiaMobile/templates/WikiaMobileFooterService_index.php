<footer id="wikiaFooter">
	<a href="http://wikia.com">
		<img id="wikiaLogo" src="<?= $wg->StylePath ;?>/wikiamobile/images/wordmark.png" alt="Wikia.com">
	</a>
	<? if( !empty( $links ) ) :?>
		<ul>
			<? foreach( $links as $link ) :?>
				<li><?= $link ;?></li>
			<? endforeach ;?>
		</ul>
	<? endif ;?>
	<ul>
		<li><a href="#" id="fullSiteSwitch"><?= $wf->Msg('mobile-full-site') ;?></a></li>
		<li><?= $copyrightLink ;?></li>
	</ul>
</footer>