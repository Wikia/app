<div class="insights-container-nav">
	<ul class="insights-nav-list">
		<? foreach( $data['messageKeys'] as $key => $messages ) : ?>
			<li class="insights-nav-item">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-nav-link">
					<?= wfMessage( $messages['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<div class="insights-container-main">
	<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $subpage ) ?> clearfix">
		<h2 class="insights-header-subtitle"><?= wfMessage( $data['messageKeys'][$subpage]['subtitle'] )->escaped() ?></h2>
		<p class="insights-header-description"><?= wfMessage( $data['messageKeys'][$subpage]['description'] )->escaped() ?></p>
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

