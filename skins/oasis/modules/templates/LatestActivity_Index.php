<section class="WikiaActivityModule module" id="<?= !empty( $userName ) ? 'WikiaRecentActivityUser' : 'WikiaRecentActivity'; ?>">
	<h2 class="activity-heading"><?= wfMessage( 'oasis-activity-header' )->escaped(); ?></h2>
	<ul>
<?php
if ( !empty( $changeList ) ):
	foreach ( $changeList as $item ):
?>
		<li>
			<img src="<?= $wg->BlankImgUrl ?>" class="sprite <?= $item['changeicon'] ?>" height="20" width="20">
			<em><?= $item['page_href'] ?></em>
			<div class="edited-by"><?= $item['changemessage'] ?></div>
		</li>
	<?php endforeach; ?>
<?php elseif ( !empty( $userName ) ): ?>
		<?= wfMessage( 'userprofilepage-recent-activity-default', $userName )->escaped(); ?>
<?php endif; ?>
	</ul>

	<? if ( $userName && count( $changeList ) ) :?>
		<a class="more" href="<?= Skin::makeSpecialUrl( 'Contributions/' . $userName ); ?>"><?= wfMessage( 'userprofilepage-top-recent-activity-see-more' )->escaped(); ?></a>
	<? elseif ( empty( $userName ) ): ?>
		<a class="more" href="<?= Skin::makeSpecialUrl( 'WikiActivity' ); ?>"><?= wfMessage( 'oasis-more' )->escaped(); ?></a>
	<? endif; ?>
</section>
