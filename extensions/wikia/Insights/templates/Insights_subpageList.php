<div class="insights-container-nav <?= $themeClass ?>">
	<ul class="insights-nav-list">
		<? foreach( InsightsHelper::getMessageKeys() as $key => $messages ) : ?>
			<?php $subpage == $key ? $class = 'active' : $class = '' ?>
			<li class="insights-nav-item insights-icon-<?= $key ?> <?= $class ?>">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-nav-link">
					<?= wfMessage( $messages['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<div class="insights-container-main <?= $themeClass ?>">
	<div class="insights-container-main-inner">
		<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $subpage ) ?> clearfix">
			<h2 class="insights-header-subtitle"><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $subpage )->escaped() ?></h2>
			<p class="insights-header-description"><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $subpage )->escaped() ?></p>
		</div>
		<?php if (!empty($dropdown)): ?>
			<div class="insights-header-sorting">
				<form class="insights-sorting-form" method="GET">
					<label for="sort"><?= wfMessage( 'insights-sort-label' )->escaped() ?></label>
					<select class="insights-sorting" name="sort">
						<?php foreach($dropdown as $sortType => $sortLabel): ?>
							<option value="<?= $sortType ?>" <?php if ( $sortType == $current ): ?>selected<?php endif ?>><?= $sortLabel ?></option>
						<?php endforeach ?>
					</select>
				</form>
			</div>
		<?php endif ?>
		<div class="insights-content">
			<?php if ( !empty( $content ) ) : ?>
				<table class="insights-list" data-type="<?= Sanitizer::encodeAttribute( $subpage ) ?>">
					<tr>
						<th class="insights-list-header insights-list-first-column"><?= wfMessage( 'insights-list-header-page' )->escaped() ?></th>
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
											<?= wfMessage( 'insights-last-edit' )->rawParams(
											Xml::element( 'a', [
													'href' => $item['metadata']['lastRevision']['userpage']
												],
													$item['metadata']['lastRevision']['username']
												),
											date( 'F j, Y', $item['metadata']['lastRevision']['timestamp'] )
											)->escaped() ?>
										<?php endif; ?>
										<?php if ( isset( $item['metadata']['wantedBy'] ) ) : ?>
											<?= $item['metadata']['wantedBy'] ?>
										<?php endif; ?>
									</p>
								<?php endif; ?>
							</td>
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
			<?php else: ?>
				<p>
					<?= wfMessage( 'insights-list-no-items' )->escaped(); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
