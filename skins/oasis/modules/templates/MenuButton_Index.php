<?php
	if (is_array($action) && !empty($action)) {
		if (empty($dropdown)) {
			// render simple edit button
?>
<a accesskey="e" href="<?= htmlspecialchars($action['href']) ?>" class="<?= $class ?>" data-id="<?= $actionName ?>"><?= $icon ?> <?= htmlspecialchars($action['text']) ?></a>
<?php
		}
		// render edit button with dropdown
		else {
?>
	<? if($contribute): ?>
<ul class="<?= str_replace('loginToEditProtectedPage', '', $class) ?>"><li>
		<?= $icon ?> <?= htmlspecialchars($action['text']) ?>
	<? else: ?>
<nav class="<?= $class ?>" <?= empty($id) ? '' : 'id="'.$id.'"'?>>
	<a <?= !empty($actionAccessKey) ? "accesskey=\"{$actionAccessKey}\"" : '' ?> href="<?= empty($action['href']) ? '' : htmlspecialchars($action['href']) ?>" data-id="<?= $actionName ?>" <?= empty($action['id']) ? '' : 'id="'.$action['id'].'"'?>>
		<?= $icon ?> <?= htmlspecialchars($action['text']) ?>
	</a>
	<? endif; ?>
	<span class="drop">
		<img src="<?= $wgBlankImgUrl ?>" class="chevron">
	</span>
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

			$href = isset($item['href']) ? htmlspecialchars($item['href']) : '#';
?>
		<li>
			<a href="<?= $href ?>"<?= $accesskey ?> data-id="<?= $key ?>" <?= empty($item['id']) ? '' : 'id="'.$item['id'].'"' ?>>
				<?= htmlspecialchars($item['text']) ?>
			</a>
		</li>
<?php
		}
?>
	</ul>
<? if($contribute): ?>
</li></ul>
<? else: ?>
</nav>
<? endif; ?>
<?php
		}
	}
?>
