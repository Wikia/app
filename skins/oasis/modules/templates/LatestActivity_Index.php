<section class="module" id="WikiaRecentActivity">

	<h2 class="latest-activity-module-header"><?= $activityIcon ?><?= $moduleHeader ?></h2>

	<? if(!empty($changeList)): ?>
		<ul class="latest-activity-items">
		<? foreach ($changeList as $item): ?>
			<li class="latest-activity-item">
				<div class="page-title"><a href="<?= $item['page_url'] ?>"><?= $item['page_title'] ?></a></div>
				<div class="edited-by"><a href="<?= $item['user_profile_url'] ?>"><?= $item['user_name'] ?></a> • <?= $item['time_ago'] ?></div>
			</li>
		<? endforeach; ?>
		</ul>
	<? endif; ?>
</section>
