<script>
	AdminDashboardChrome.isCollapsed = <?= $isCollapsed ?>;
</script>
<div id="AdminDashboardDrawer" class="AdminDashboardDrawer">
	<span class="arrow<?= ($isCollapsed ? '' : ' expanded') ?>"></span>
</div>
<nav class="AdminDashboardNavigation">
	<a href="<?= $backLink ?>"><?= wfMsg('admindashboard-back-to-dashboard') ?></a>
</nav>
<div class="AdminDashboardGeneralHeader AdminDashboardArticleHeader">
	<h1><?= $headerText ?></h1>
</div>