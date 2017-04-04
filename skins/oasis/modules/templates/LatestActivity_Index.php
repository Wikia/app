<section class="WikiaActivityModule module" id="WikiaRecentActivity">
	<!--TODO: activity icon-->
	<h2 class="activity-heading"><?= $moduleHeader ?></h2>

	<? if(!empty($changeList)): ?>
		<ul>
		<? foreach ($changeList as $item): ?>
			<li>
				<em><a href="<?= $item['page_url'] ?>"><?= $item['page_title'] ?></a></em>
				<div class="edited-by"><a href="<?= $item['user_profile_url'] ?>"><?= $item['user_name'] ?></a> • <?= $item['time_ago'] ?></div>
			</li>
		<? endforeach; ?>
		</ul>
	<? endif; ?>

	<?= Wikia::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>
