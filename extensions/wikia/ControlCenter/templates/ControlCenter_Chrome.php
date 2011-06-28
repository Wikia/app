<header class="ControlCenterHeader" id="ControlCenterHeader">
	<h1>
		<? if(empty($wordmarkUrl)) { ?>
			<?= $wordmarkText ?>
		<? } else { ?>
			<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="48">
		<? } ?>
		<?= wfMsg("controlcenter-header") ?>
	</h1>
	<nav>
		<?= wfMsg("controlcenter-header-help", "") ?> | <?= wfMsg("controlcenter-header-exit", "") ?>
	</nav>
</header>
<nav class="ControlCenterTabs" id="ControlCenterTabs">
	<a href="<?= $controlCenterUrlAdvanced ?>" class="tab <?= $tab == 'advanced' ? 'active' : '' ?>" data-section="advanced">Advanced</a>
	<a href="<?= $controlCenterUrlGeneral ?>" class="tab <?= $tab == 'general' ? 'active' : '' ?>" data-section="general">General</a>
</nav>
<aside class="ControlCenterRail" id="ControlCenterRail">
	<?= $founderProgressBar ?>
</aside>