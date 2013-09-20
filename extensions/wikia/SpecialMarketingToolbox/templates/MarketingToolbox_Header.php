<header class="MarketingToolboxHeader">
	<div class="MarketingToolboxTitle">
		<h1><a href="<?=$dashboardHref;?>"><?= wfMsg('marketing-toolbox-header-dashboard'); ?></a></h1>
		<? if (isset($moduleName)): ?>
			<h2><?=$moduleName;?></h2>
		<? endif ?>

		<? if (isset($date)): ?>
			<p><strong><?=$wg->lang->date($date);?></strong></p>
		<? endif?>
		<? if (isset($regionName) && isset($sectionName) && isset($verticalName)): ?>
			<p class="alternative"><?=$regionName?> / <?=$sectionName ?> / <?=$verticalName?></p>
		<? endif ?>
	</div>

	<aside class="right">
		<? if (isset($lastEditTime)): ?>
		<p><strong><?= wfMsg('marketing-toolbox-header-right-last-saved'); ?></strong> <?=$wg->lang->timeanddate($lastEditTime, true);?></p>
		<? endif ?>

		<? if (isset($lastEditor)): ?>
		<p><strong><?= wfMsg('marketing-toolbox-header-right-by'); ?></strong> <?=$lastEditor?></p>
		<? endif ?>
	</aside>
</header>
<div class="MarketingToolboxHeaderGradient"></div>