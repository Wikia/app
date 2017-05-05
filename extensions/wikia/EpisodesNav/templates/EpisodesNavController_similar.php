<div class="similars-block">
	<div class="scroll scroll-left scroll-disabled"><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'scroll-icon-left' ) ?></div>
	<div class="similars">
		<?php foreach ( $articles as $article ) : ?>
			<div class="similar">
				<a class="similar-link" href="<?= $article['link'] ?>">
					<div class="similar-title-block">
						<span class="similar-title"><?= $article['title'] ?></span>
					</div>
					<img class="similar-image" src="<?= $article['image'] ?>">
				</a>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="scroll scroll-right scroll-disabled"><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'scroll-icon-right' ) ?></div>
</div>
