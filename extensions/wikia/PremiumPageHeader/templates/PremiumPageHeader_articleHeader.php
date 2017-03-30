<div class="pph-article-header-tracking pph-article-header">
	<div class="pph-article-title">
		<?php if ( count( $visibleCategories ) > 0 ): ?>
			<div class="pph-categories">
				<span class="pph-categories-in pph-track" data-tracking="categories-top-in"><?= $inCategoriesText ?>:</span>
				<span class="pph-category-links">
					<?= join( ', ', $visibleCategories ); ?><!--
				 --><?php if ( $moreCategoriesLength > 0 ): ?><!--
						--><div class="pph-dropdown-container"><?= $moreCategoriesSeparator ?><!--
						--><a class="pph-categories-show-more"
							  data-tracking="categories-more"><?= $moreCategoriesText ?></a>
							<div class="pph-dropdown">
								<ul class="pph-dropdown-scrollable">
									<?php foreach ( $moreCategories as $category ): ?>
										<li><?= $category; ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<span class="pph-more-categories"><?= join( ', ', $moreCategories ); ?></span>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>
		<h1 class="pph-track" data-tracking="article-title"><?= $title ?></h1>
	</div>
	<div class="pph-article-contribution">
		<div class="pph-languages pph-dropdown-container<?= count( $languageList ) <= 1 ? ' pph-disabled' : '' ?>">
			<span class="pph-track" data-tracking="interwiki-dropdown">
				<?= $currentLangName ?>
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny pph-dropdown-chevron'
				) ?>
			</span>
			<?php if ( count( $languageList ) > 1 ): ?>
				<div class="pph-dropdown">
					<ul class="pph-dropdown-scrollable">
						<?php foreach ( $languageList as $key => $val ) : ?>
							<li>
								<a href="<?= Sanitizer::encodeAttribute( $val['href'] ); ?>"
								   data-tracking="top-<?= $key ?>"><?= htmlspecialchars( $val['name'] ); ?></a>
							</li>
						<?php endforeach ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
		<div class="pph-contribution-buttons">
			<div class="pph-button-group">
				<?php if ( !empty( $action ) ): ?>
					<a href="<?= empty( $action['href'] ) ? '' : Sanitizer::encodeAttribute( $action['href'] ) ?>"
					   class="pph-button<?= $actionButtonClass; ?>" data-tracking="edit">
						<?php if ( $actionImage === MenuButtonController::EDIT_ICON ) { ?>
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-pencil',
								'wds-icon wds-icon-tiny pph-button-icon'
							) ?>
						<?php } ?>
						<?= htmlspecialchars( $action['text'] ) ?>
					</a>
				<?php endif; ?>
				<?php if ( !empty( $dropdown ) ): ?>
					<div class="pph-dropdown-container">
						<a class="pph-button pph-button-chevron" data-tracking="edit-dropdown">
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-dropdown-tiny',
								'wds-icon wds-icon-tiny pph-local-nav-chevron pph-dropdown-chevron'
							) ?>
						</a>
						<ul class="pph-dropdown">
							<?php
							foreach ( $dropdown as $key => $item ) {
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
									<a href="<?= Sanitizer::encodeAttribute( $href ); ?>" <?= $accesskey ?>
									   data-tracking="edit-<?= Sanitizer::encodeAttribute( $key ) ?>"
									   data-id="<?= Sanitizer::encodeAttribute( $key ); ?>"
										<?= empty( $item['title'] ) ? '' : ' title="' . Sanitizer::encodeAttribute( $item['title'] ) . '"'; ?>
										<?= empty( $item['id'] ) ? '' : ' id="' . Sanitizer::encodeAttribute( $item['id'] ) . '"' ?>
										<?= empty( $item['class'] ) ? '' : ' class="' . Sanitizer::encodeAttribute( $item['class'] ) . '"' ?>
										<?= empty( $item['attr'] ) ? '' : ' ' . $item['attr'] ?>><?= htmlspecialchars( $item['text'] ) ?>
									</a>
								</li>
							<?php } ?>
							<?php if ( !empty( $curatedContentButton ) ) : ?>
								<li>
									<a data-tracking="edit-main-page"
									   id="<?= $curatedContentButton['id'] ?>"
									   href="<?= $curatedContentButton['href'] ?>"><?= $curatedContentButton['text'] ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<a href="<?= $commentsLink; ?>" class="pph-button pph-button-secondary" data-tracking="comments">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-reply-tiny',
					'wds-icon wds-icon-tiny pph-button-icon'
				) ?>
				<?= wfMessage( $commentButtonMsg )->text(); ?>
			</a>

			<? if ( Wikia::isContentNamespace() && $wg->Title->exists() && !$app->checkSkin( 'oasislight' ) ): ?>
				<a id="PremiumPageHeaderShareEntryPoint" class="pph-button pph-button-secondary"
				   data-tracking="share">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-share-small',
						'wds-icon wds-icon-tiny pph-button-icon'
					) ?>
					<?= wfMessage( 'page-share-entry-point-label' )->escaped() ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
