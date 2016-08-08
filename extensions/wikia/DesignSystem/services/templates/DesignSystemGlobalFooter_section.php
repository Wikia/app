<section class="wds-global-footer__<?= Sanitizer::encodeAttribute( $parentName ) ?>-section wds-is-<?= Sanitizer::encodeAttribute( $name ) ?>">
	<?php if ( $model['header']['title'] ) : ?>
		<h3 class="wds-global-footer__section-header"><?= DesignSystemHelper::renderText( $model['header']['title'] ) ?></h3>
	<?php endif; ?>

	<?php if ( $model['description'] ) : ?>
		<span class="wds-global-footer__section-description"><?= DesignSystemHelper::renderText( $model['description'] ) ?></span>
	<?php endif; ?>

	<ul class="wds-global-footer__links-list">
		<?php foreach ( $model['links'] as $link ) : ?>
			<li class="wds-global-footer__links-list-item">
				<?php if ( $link['type'] === 'link-image' ) : ?>
					<?= $app->renderView( 'DesignSystemGlobalFooterService', 'linkImage', [ 'model' => $link ] ); ?>
				<?php elseif ( $link['type'] === 'link-branded' ) : ?>
					<?= $app->renderView( 'DesignSystemGlobalFooterService', 'linkBranded', [ 'model' => $link ] ); ?>
				<?php else : ?>
					<?= $app->renderView( 'DesignSystemGlobalFooterService', 'linkText', [ 'model' => $link ] ); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
