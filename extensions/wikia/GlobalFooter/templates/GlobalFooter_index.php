<footer class="global-footer row">
	<nav>
		<h1><?= wfMessage('oasis-corporatefooter-navigation-header')->text(); ?></h1>
		<div class="branding <?= (!$isCorporate ? 'black' : ''); ?>">
			<div class="wordmark">
				<img src="<?= $wg->BlankImgUrl; ?>" class="wordmark<?= $hub->cat_id ?>">
			</div>
			<?php if(!$isCorporate): ?>
				<div class="hub"><a class="hub<?= $hub->cat_id; ?>" href="<?=$hub->cat_link?>">[ <?=$hub->cat_name?> ]</a></div>
			<?php endif; ?>
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
