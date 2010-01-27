<div id="page_bar" class="reset clearfix recipes_page_bar">
	<ul id="page_controls">
<?php
	foreach($actionBar as $key => $val) {
?>
		 <li id="control_<?= $key ?>" class="<?= isset($val['class']) ? $val['class'] : '' ?>"><div>&nbsp;</div><a rel="nofollow" id="ca-<?= $key ?>" href="<?= htmlspecialchars($val['href']) ?>" <?= $skin->tooltipAndAccesskey('ca-'.$key) ?>><?= htmlspecialchars(ucfirst($val['text'])) ?></a></li>
<?php
	}
?>
	</ul>
</div>
