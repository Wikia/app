<? if (empty($hideheader)) { ?>
<div id="WikiaPageHeader" class="WikiaPageHeader">
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
	<p><?= $subtitle ?></p>
</div>
<? } ?>