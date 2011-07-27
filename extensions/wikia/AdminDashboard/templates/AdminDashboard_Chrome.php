<header class="AdminDashboardHeader" id="AdminDashboardHeader">
	<h1>
		<a href="<?= $mainPageUrl ?>" data-tracking="header/wordmark">
			<? if(empty($wordmarkUrl)) { ?>
				<?= $wordmarkText ?>
			<? } else { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="48">
			<? } ?>
			<?= wfMsg("admindashboard-header") ?>
		</a>
	</h1>
	<nav>
		<?= wfMsgExt("admindashboard-header-help", "parseinline") ?> | <?= wfMsgExt("admindashboard-header-exit", "parseinline") ?>
	</nav>
</header>
<nav class="AdminDashboardTabs" id="AdminDashboardTabs">
	<a href="<?= $adminDashboardUrlAdvanced ?>" class="tab <?= $tab == 'advanced' ? 'active' : '' ?>" data-section="advanced" data-tracking="header/advanced"><?= wfMsg('admindashboard-tab-advanced') ?></a>
	<a href="<?= $adminDashboardUrlGeneral ?>" class="tab <?= $tab == 'general' ? 'active' : '' ?>" data-section="general" data-tracking="header/general"><?= wfMsg('admindashboard-tab-general') ?></a>
</nav>
<aside class="AdminDashboardRail" id="AdminDashboardRail" <?= $hideRail ? 'style="display:none"' : '' ?>>
	<?= $app->renderView( 'FounderProgressBar', 'widget' ) ?>
	<?= $app->renderView( 'QuickStats', 'getStats') ?>
</aside>