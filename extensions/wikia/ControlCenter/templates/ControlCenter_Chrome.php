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
	<ul>
		<li class="tab" data-section="advanced">
			<a href="<?= $controlCenterUrlAdvanced ?>">Advanced</a>
		</li>
		<li class="tab active" data-section="general">
			<a href="<?= $controlCenterUrlGeneral ?>">General</a>
		</li>
	</ul>
</nav>
<aside class="ControlCenterRail">
	<?= $founderProgressBar ?>
</aside>