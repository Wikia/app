<div class="insights-container-nav">
	<ul class="insights-nav-list">
		<? foreach( InsightsHelper::$insightsPages as $key => $page ) : ?>
			<li class="insights-nav-item">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-nav-link">
					<?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $key )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<div class="insights-container-main">
	<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $subpage ) ?> clearfix">
		<h2 class="insights-header-subtitle"><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $subpage )->escaped() ?></h2>
		<p class="insights-header-description"><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $subpage )->escaped() ?></p>
	</div>
	<table class="insights-list">
		<? foreach( $content as $item ): ?>
			<tr>
				<td class="item-number"><?= ++$offset ?></td>

				<?php if ( isset( $item['link'] ) ) : ?>
					<td><?= $item['link'] ?></td>
				<?php endif; ?>
				<td><?php if ( isset( $item['revision'] ) ) : ?>
					<?= wfMessage( 'insights-last-edit' )->rawParams(
							Xml::element( 'a', [
								'href' => $item['revision']['userpage']
							],
								$item['revision']['username']
							),
							date( 'F j, Y', $item['revision']['timestamp'] )
						)->escaped() ?>
				<?php endif; ?></td>

				<td># of views</td>
			</tr>
		<? endforeach ?>
	</table>
</div>

