<div class="pph-article-header">
	<div class="pph-article-title">
		<?php if ( count( $visibleCategories ) ): ?>
			<div class="pph-categories">
				in:&nbsp;
				<span class="pph-category-links">
					<?php foreach($visibleCategories as $i => $category): ?>
						<?php if ($i === $visibleCategoriesLength - 1 && count($moreCategories) === 0): ?>
							<?= $category ?>
						<?php else: ?>
							<?= $category ?>,
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if($moreCategoriesLength > 0): ?>
						<a href="#">and <?= $moreCategoriesLength ?> more</a>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>
		<h1><?= $title ?></h1>
	</div>
	<div class="pph-article-contribution">
		<div class="pph-languages">
			English
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny'
			) ?>
		</div>
		<div class="pph-contribution-buttons">
			<div class="pph-button-group">
				<?php if ( !empty( $action ) ): ?>
					<a href="<?= empty($action['href']) ? '' : Sanitizer::encodeAttribute( $action['href'] ) ?>" class="pph-button">
						<?php if ( $actionImage === MenuButtonController::EDIT_ICON ) { ?>
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-pencil',
								'wds-icon wds-icon-tiny pph-button-icon'
							) ?>
						<?php } ?>
						<?= htmlspecialchars($action['text']) ?>
					</a>
				<?php endif; ?>
				<a href="#" class="pph-button pph-button-chevron">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-dropdown-tiny',
						'wds-icon wds-icon-tiny pph-local-nav-chevron'
					) ?>
				</a>
				<ul class="WikiaMenuElement" style="display: none">
					<?php
					foreach($dropdown as $key => $item) {
						// render accesskeys
						if ( !empty( $item['accesskey'] ) ) {
							$accesskey =
								' accesskey="' . Sanitizer::encodeAttribute( $item['accesskey'] ) .
								'"';
						} else {
							$accesskey = '';
						}

						$href = $item['href'] ?? '#';
						?>
						<li>
							<a href="<?= Sanitizer::encodeAttribute( $href ); ?>" <?= $accesskey ?> data-id="<?= Sanitizer::encodeAttribute( $key ); ?>" <?= empty($item['title']) ? '' : ' title="'. Sanitizer::encodeAttribute( $item['title'] ) .'"'; ?> <?= empty($item['id']) ? '' : ' id="'. Sanitizer::encodeAttribute( $item['id'] ) .'"' ?><?= empty($item['class']) ? '' : ' class="'. Sanitizer::encodeAttribute( $item['class'] ) .'"' ?><?= empty($item['attr']) ? '' : ' '.$item['attr'] ?>><?=htmlspecialchars($item['text']) ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<a href="#" class="pph-button pph-button-secondary">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-reply-tiny',
					'wds-icon wds-icon-tiny pph-button-icon'
				) ?>
				<?= wfMessage( $commentButtonMsg )->text(); ?>
			</a>

			<? if ( Wikia::isContentNamespace() && $wg->Title->exists() && !$app->checkSkin('oasislight') ): ?>
				<a id="PremiumPageHeaderShareEntryPoint" href="#" class="pph-button pph-button-secondary">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-share-small',
						'wds-icon wds-icon-tiny pph-button-icon'
					) ?>
					<?= wfMessage( 'page-share-entry-point-label' )->escaped()?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
