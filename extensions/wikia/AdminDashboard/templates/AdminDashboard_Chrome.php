<header class="AdminDashboardHeader" id="AdminDashboardHeader">
	<h1>
		<a href="<?= $mainPageUrl ?>">
			<? if(empty($wordmarkUrl)) { ?>
				<?= $wordmarkText ?>
			<? } else { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="48">
			<? } ?>
			<?= wfMsg("admindashboard-header") ?>
		</a>
	</h1>
	<nav>
		<?= wfMsg("admindashboard-header-help", "") ?> | <?= wfMsg("admindashboard-header-exit", "") ?>
	</nav>
</header>
<nav class="AdminDashboardTabs" id="AdminDashboardTabs">
	<a href="<?= $adminDashboardUrlAdvanced ?>" class="tab <?= $tab == 'advanced' ? 'active' : '' ?>" data-section="advanced">Advanced</a>
	<a href="<?= $adminDashboardUrlGeneral ?>" class="tab <?= $tab == 'general' ? 'active' : '' ?>" data-section="general">General</a>
</nav>
<aside class="AdminDashboardRail" id="AdminDashboardRail">
	<?= $founderProgressBar ?>
</aside>