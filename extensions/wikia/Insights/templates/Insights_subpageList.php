<div class="insights-container-nav <?= $themeClass ?>">
	<ul class="insights-nav-list">
		<? foreach( $insightsList as $key => $insight ) : ?>
			<?php $subpage == $key ? $class = 'active' : $class = '' ?>
			<li class="insights-nav-item insights-icon-<?= $key ?> <?= $class ?>">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-nav-link">
					<?php if ( $insight['count'] ): ?>
						<div class="insights-red-dot<?php if ( $insight['highlighted'] ):?> highlighted<?php endif ?>"><div class="insights-red-dot-count"><?= $insight['count'] ?></div></div>
					<?php endif ?>

					<?= wfMessage(  $insight['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<div class="insights-container-main <?= $themeClass ?>">
	<div class="insights-container-main-inner">
		<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $subpage ) ?> clearfix">
			<h2 class="insights-header-subtitle"><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $subpage )->escaped() ?></h2>
			<p class="insights-header-description"><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $subpage )->parse() ?></p>
		</div>
		<?php if ( !empty( $dropdown ) ): ?>
			<form class="insights-sorting-form" method="GET">
				<div class="insights-header-sorting">
					<label for="sort"><?= wfMessage( 'insights-sort-label' )->escaped() ?></label>
					<select class="insights-sorting" name="sort">
						<?php foreach( $dropdown as $sortType => $sortLabel ): ?>
							<option value="<?= Sanitizer::encodeAttribute( $sortType ) ?>" <?php if ( $sortType == $current ): ?>selected<?php endif ?>><?= htmlspecialchars( $sortLabel ) ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<?php if ( !empty( $flagTypes ) ): // Flags filter dropdown ?>
					<?= $app->renderView( 'Insights', 'flagsFiltering', [ 'selectedFlagTypeId' => $selectedFlagTypeId, 'flagTypes' => $flagTypes ] ); ?>
				<?php endif ?>
			</form>
		<?php endif ?>

		<div class="insights-content">
			<?php if ( !empty( $content ) ) : ?>
				<table class="insights-list" data-type="<?= Sanitizer::encodeAttribute( $subpage ) ?>">
					<tr>
						<th class="insights-list-header insights-list-first-column"><?= wfMessage( 'insights-list-header-page' )->escaped() ?></th>
						<?php if ( $data['display']['altaction'] ) : ?>
							<th class="insights-list-header insights-list-header-altaction"><?= wfMessage( "insights-list-header-altaction" )->escaped() ?></th>
						<?php endif; ?>
						<?php if ( $data['display']['pageviews'] ) : ?>
							<th class="insights-list-header insights-list-header-pageviews"><?= wfMessage( 'insights-list-header-pageviews' )->escaped() ?></th>
						<?php endif; ?>
					</tr>
					<?php foreach( $content as $item ): ?>
						<tr class="insights-list-item">
							<td class="insights-list-item-page insights-list-cell insights-list-first-column">
								<a class="insights-list-item-title <?= Sanitizer::encodeAttribute( $item['link']['classes'] ) ?>" title="<?= Sanitizer::encodeAttribute( $item['link']['title'] ) ?>" href="<?= Sanitizer::cleanUrl( $item['link']['url'] ) ?>"><?= Sanitizer::escapeHtmlAllowEntities( $item['link']['text'] ) ?></a>
								<?php if ( isset( $item['metadata'] ) ) : ?>
									<p class="insights-list-item-metadata">
										<?php if ( isset( $item['metadata']['lastRevision'] ) ) : ?>
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
										<?php if ( isset( $item['metadata']['wantedBy'] ) ) : ?>
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
							<?php if ( !empty( $item['altaction'] ) ) : ?>
							<td class="insights-list-cell insights-list-cell-altaction">
								<a class="wikia-button <?= $item['altaction']['class'] ?>" href="<?= $item['altaction']['url'] ?>" target="_blank">
									<?= $item['altaction']['text'] ?>
								</a>
							</td>
							<?php endif; ?>
							<?php if ( $data['display']['pageviews'] ) : ?>
								<td class="insights-list-item-pageviews insights-list-cell">
									<?= $wg->Lang->formatNum( $item['metadata'][$metadata] ); ?>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</table>
				<?php if ( $paginatorBar ) : ?>
					<?= $paginatorBar ?>
				<?php endif ?>
			<?php elseif (!empty( $flagTypes ) ) : ?>
				<p>
					<?= wfMessage( 'insights-list-no-flag-types' )->escaped(); ?>
				</p>
			<?php else: ?>
				<p>
					<?= wfMessage( 'insights-list-no-items' )->escaped(); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>
</div>
