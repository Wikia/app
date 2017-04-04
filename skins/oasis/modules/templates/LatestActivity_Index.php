<section class="module" id="WikiaRecentActivity">
	<div class="latest-activity-module-header">
		<?= $activityIcon ?><h2><?= $moduleHeader ?></h2>
	</div>

	<? if(!empty($changeList)): ?>
		<ul class="latest-activity-items">
		<? foreach ($changeList as $item): ?>
			<li>
				<em><a href="<?= $item['page_url'] ?>"><?= $item['page_title'] ?></a></em>
				<div class="edited-by"><a href="<?= $item['user_profile_url'] ?>"><?= $item['user_name'] ?></a> • <?= $item['time_ago'] ?></div>
			</li>
		<? endforeach; ?>
		</ul>
	<? endif; ?>
</section>
