<?php
	if (is_array($action) && !empty($action)) {
		if (empty($dropdown)) {
			// render [icon] + [link] ("View source")
			if (!empty($iconBefore)) {
?>
<span class="<?= $class ?>"><?= $iconBefore ?><a accesskey="e" href="<?= htmlspecialchars($action['href']) ?>" data-id="<?= $actionName ?>"><?= htmlspecialchars($action['text']) ?></a></span>
<?php
			}
			// render simple edit button
			else {
?>
<a accesskey="e" href="<?= htmlspecialchars($action['href']) ?>" class="<?= $class ?>" data-id="<?= $actionName ?>"><?= $icon ?> <?= htmlspecialchars($action['text']) ?></a>
<?php
			}
		}
		// render edit button with dropdown
		else {
?>
<ul class="<?= $class ?>">
	<li>
		<a accesskey="e" href="<?= htmlspecialchars($action['href']) ?>" data-id="<?= $actionName ?>"><?= $icon ?> <?= htmlspecialchars($action['text']) ?></a>
		<img src="<?= $wgBlankImgUrl ?>" class="chevron">
		<ul>
<?php
			foreach($dropdown as $key => $item) {
				// render accesskeys
				if (isset($item['accesskey'])) {
					$accesskey = ' accesskey="' . $item['accesskey'] . '"';
				}
				else {
					$accesskey = '';
				}
?>
			<li><a href="<?= htmlspecialchars($item['href']) ?>"<?= $accesskey ?> data-id="<?= $key ?>"><?= htmlspecialchars($item['text']) ?></a></li>
<?php
			}
?>
		</ul>
	</li>
</ul>
<?php
		}
	}
?>