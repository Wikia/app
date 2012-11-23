<header class="MarketingToolboxHeader">
	<div class="MarketingToolboxTitle">
		<h1><a href="#"><?= wfMsg('marketing-toolbox-header-dashboard'); ?></a></h1>
		<? if (isset($moduleName)): ?>
			<h2><?=$moduleName;?></h2>
		<? endif ?>

		<? if (isset($date)): ?>
			<p><strong><?=$wg->lang->date($date);?></strong></p>
		<? endif?>
	</div>

	<aside class="right">
		<? if (isset($lastEditTime)): ?>
		<p><strong><?= wfMsg('marketing-toolbox-header-right-last-saved'); ?></strong> <?=$lastEditTime?></p>
		<? endif ?>

		<? if (isset($lastEditor)): ?>
		<p><strong><?= wfMsg('marketing-toolbox-header-right-by'); ?></strong> <?=$lastEditor?></p>
		<? endif ?>
	</aside>
</header>
<div class="MarketingToolboxHeaderGradient"></div>