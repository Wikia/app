<footer class="CorporateFooter">
	<nav>
		<h1><?= wfMsg('oasis-corporatefooter-navigation-header'); ?></h1>
		<div class="WikiaHubBranding <?= (($hub && $hub->cat_id && $hub->cat_id != 4) ? 'HubBrandingBlackBackground' : ''); ?>">
			<div class="wordmark">
				<img src="<?= $wg->BlankImgUrl; ?>" class="sprite logo<?= (($hub && $hub->cat_id) ? "$hub->cat_id" : '4'); // 4: Corporate ?>">
			</div>
			<?php if( $hub && $hub->cat_id != 4): // 4: Corporate ?>
			    <div class="hub"><a class="hub<?= $hub->cat_id; ?>" href="<?=$hub->cat_link?>">[ <?=$hub->cat_name?> ]</a></div>
			<?php endif; ?>
		</div>
		<ul>
<?php
foreach ($footer_links as $link) {
		?>
			<li>
			<?php
			// biz logic like this should be in the module but the copyright link an exception RT#74478
			if ($link["text"] == 'GFDL' || (strpos($link["text"], 'LICENSE') > 0) ) {
				echo $copyright;
			} else {?>
				<a<?= ( !empty( $link[ 'id' ] ) ) ? " id=\"{$link[ 'id' ]}\"" : null ;?> href="<?= $link["href"]; ?>"<?= ( !empty( $link[ 'nofollow' ] ) ) ? ' rel="nofollow"' : null ;?>><?= $link["text"]; ?></a>
			<?php } ?>
			</li>
	<?php
}
		?>
		</ul>
	</nav>
</footer>
