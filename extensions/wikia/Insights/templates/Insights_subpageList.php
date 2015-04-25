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
		<div class="insights-content">
			<ul class="insights-list">
				<?php foreach( $content as $item ): ?>
					<li class="insights-list-item">
						<a class="insights-list-item-title <?= $item['link']['classes'] ?>" title="<?= $item['link']['title'] ?>" href="<?= $item['link']['url'] ?>"><?= $item['link']['text'] ?></a>
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
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
