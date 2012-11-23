<header class="MarketingToolboxHeader">
	<div class="MarketingToolboxTitle">
		<h1><a href="#">Dashboad</a></h1>
		<h2><?=$moduleName;?></h2>

		<p><strong><?=$date;?></strong></p>
	</div>

	<aside class="right">
		<? if (isset($lastEditTime)): ?>
		<p><strong>Last saved: </strong> <?=$lastEditTime?></p>
		<? endif ?>

		<? if (isset($lastEditor)): ?>
		<p><strong>by: </strong> <?=$lastEditor?></p>
		<? endif ?>
	</aside>
</header>
<div class="MarketingToolboxHeaderGradient">

</div>