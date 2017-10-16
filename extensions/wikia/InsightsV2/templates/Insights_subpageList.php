<div class="insights-container-nav <?= $themeClass ?>">
	<?= $app->renderView( 'Insights', 'insightsList', [ 'type' => $type ] ) ?>
</div>
<div class="insights-container-main <?= $themeClass ?>">
	<div class="insights-container-main-inner">
		<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $type ) ?> clearfix">
			<h2 class="insights-header-subtitle"><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $type )->escaped() ?></h2>
			<p class="insights-header-description"><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $type )->parse() ?></p>
		</div>
		<?php if ( !empty( $showPageViews ) || !empty( $subtypes ) ): ?>
			<form class="insights-sorting-form" method="GET">
				<?php if ( !empty( $showPageViews ) ): ?>
					<?= $app->renderView( 'Insights', 'pageViews', [ 'sort' => $sort ] ) ?>
				<?php endif ?>
				<?php if ( !empty( $subtypes ) ): ?>
					<div class="insights-header-sorting">

							<label for="sort"><?= wfMessage( 'insights-flags-filter-label' )->escaped(); ?></label>
							<select class="insights-sorting" name="subtype" onchange="this.form.submit()">
								<?php
								foreach ( $subtypes as $id => $type ): ?>
									<option value="<?= Sanitizer::encodeAttribute( $id ); ?>" <?= $id == $subtype ? 'selected="selected"' : ''; ?>><?= htmlspecialchars( $type ) ?></option>
									<?php
								endforeach;
								?>
							</select>

					</div>
				<?php endif ?>
			</form>
		<?php endif ?>

		<div class="insights-content">
			<?php if ( !empty( $content ) ) : ?>
				<table class="insights-list" data-type="<?= Sanitizer::encodeAttribute( $type ) ?>">
					<tr>
						<th class="insights-list-header insights-list-first-column"><?= wfMessage( 'insights-list-header-page' )->escaped() ?></th>
						<?php if ( $hasActions ) : ?>
							<th class="insights-list-header insights-list-header-altaction"><?= wfMessage( "insights-list-header-altaction" )->escaped() ?></th>
						<?php endif; ?>
						<?php if ( $showPageViews ) : ?>
							<th class="insights-list-header insights-list-header-pageviews"><?= wfMessage( 'insights-list-header-pageviews' )->escaped() ?></th>
						<?php endif; ?>
					</tr>
					<?php foreach( $content as $item ): ?>
						<tr class="insights-list-item">
							<td class="insights-list-item-page insights-list-cell insights-list-first-column">
								<a class="insights-list-item-title <?= Sanitizer::encodeAttribute( $item['link']['classes'] ) ?>" title="<?= Sanitizer::encodeAttribute( $item['link']['title'] ) ?>" href="<?= Sanitizer::cleanUrl( $item['link']['url'] ) ?>"><?= Sanitizer::escapeHtmlAllowEntities( $item['link']['text'] ) ?></a>
								<?php if ( isset( $item['metadata'] ) ) : ?>
									<p class="insights-list-item-metadata">
										<?php if ( !empty( $item['metadata']['lastRevision'] ) ) : ?>
											<?php $revision = $item['metadata']['lastRevision'] ?>
											<?= wfMessage( 'insights-last-edit' )->rawParams(
												Html::element( 'a',
													[
														'href' => $revision['userpage']
													],
													$revision['username']
												),
												$wg->Lang->userDate( $revision['timestamp'], $wg->User )
											)->escaped() ?>
										<?php endif; ?>
									</p>
									<p class="insights-list-item-metadata">
										<?php if ( !empty( $item['metadata']['wantedBy'] ) ) : ?>
											<?php $wantedBy = $item['metadata']['wantedBy']; ?>
											<?=
												Html::element( 'a',
													[
														'href' => $wantedBy['url'],
													],
													wfMessage( $wantedBy['message'] )->numParams( $wantedBy['value'] )->escaped()
												);
											?>
										<?php endif; ?>
									</p>
								<?php endif; ?>
							</td>
							<?php if ( $hasActions ) : ?>
							<td class="insights-list-cell insights-list-cell-altaction">
								<a class="wikia-button <?= $item['altaction']['class'] ?>" href="<?= $item['altaction']['url'] ?>" target="_blank">
									<?= $item['altaction']['text'] ?>
								</a>
							</td>
							<?php endif; ?>
							<?php if ( $showPageViews ) : ?>
								<td class="insights-list-item-pageviews insights-list-cell">
									<?= $wg->Lang->formatNum( $item['metadata'][$metadata] ); ?>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</table>
				<?php if ( $pagination ) : ?>
					<?= $pagination ?>
				<?php endif ?>
			<?php endif; ?>
		</div>
	</div>
</div>
