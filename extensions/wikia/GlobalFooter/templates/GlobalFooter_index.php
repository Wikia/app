<footer class="global-footer">
	<nav>
		<div class="branding <?= ( !empty( $verticalShort ) ? 'vertical-' . $verticalShort : '' ); ?> <?= ( !$isCorporate ? 'black' : '' ); ?>">
			<a class="wikia-logo" href="<?=Sanitizer::encodeAttribute( $logoLink ); ?>">
				<img src="<?= $wg->BlankImgUrl; ?>">
				<?php if( !$isCorporate && !empty( $verticalShort ) ): ?>
					<span><?=$verticalNameMessage->escaped(); ?></span>
				<?php endif; ?>
			</a>
		</div>
		<ul>
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
	</nav>
</footer>
