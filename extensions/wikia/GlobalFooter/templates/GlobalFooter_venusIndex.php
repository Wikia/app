<footer class="global-footer vertical-<?= $verticalShort ?> page-width">
	<a href="<?= htmlspecialchars( $centralUrl ) ?>" class="wikia-logo" rel="nofollow">
		<img src="<?= $wg->BlankImgUrl ?>" height="37" width="134" alt="<?= wfMessage('venus-wikia')->escaped() ?>" title="<?= wfMessage('venus-wikia')->escaped() ?>">
	</a>
	<ul class="footer-links">
		<?php
		foreach ($footerLinks as $link):
			?>
			<li>
				<?php
				if ($link['isLicense']) {
					echo $copyright;
				} else {?>
					<a<?= ( !empty( $link[ 'id' ] ) ) ? " id=\"{$link[ 'id' ]}\"" : '' ;?> href="<?= $link["href"]; ?>"<?= ( !empty( $link[ 'nofollow' ] ) ) ? ' rel="nofollow"' : '' ;?>><?= $link["text"]; ?></a>
				<?php } ?>
			</li>
		<?php
		endforeach;
		?>
	</ul>
</footer>
