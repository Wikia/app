<footer class="CorporateFooter">
	<nav>
		<h1>Wikia Inc Navigation</h1>
		<div class="WikiaHubBranding">
			<div class="wordmark">
				<img src="<?= $wgBlankImgUrl; ?>" class="sprite logo">
			</div>
			<?php if ($hub && $hub->cat_id != 4) { // 4: Corporate ?>
			<div class="hub"><a href="<?=$hub->cat_link?>"><?=$hub->cat_name?></a></div>
			<?php } ?>
		</div>
		<ul>
<?php 
foreach ($footer_links as $link) {
		?>
			<li>
			<?php
			// biz logic like this should be in the module but the copyright link an exception RT#74478
			if ($link["text"] == 'GFDL' || (strpos($link["text"], 'LICENSE') > 0) ) {
				echo $wgUser->getSkin()->getCopyright();
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
