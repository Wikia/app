<section class="module" id="WikiaRecentActivity">

	<h2 class="activity-module-header"><?= $activityIcon ?><?= $moduleHeader ?></h2>

	<? if ( !empty( $changeList ) ): ?>
		<ul class="activity-items">
			<? foreach ( $changeList as $item ): ?>
				<li class="activity-item">
					<div class="page-title"><a href="<?= $item['page_url'] ?>" data-tracking="activity-title" ><?= $item['page_title'] ?></a></div>
					<div class="edit-info">
						<a class="edit-info-user" data-tracking="activity-username" href="<?= $item['user_profile_url'] ?>"><?= $item['user_name'] ?></a>
						<? if ( !empty( $item['time_ago'] ) ): ?>
							<span class="edit-info-time"> • <?= $item['time_ago'] ?></span>
						<? endif ?>
					</div>
				</li>
			<? endforeach; ?>
		</ul>
	<? endif; ?>
</section>
