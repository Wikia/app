<?php
	if (is_array($action) && !empty($action)) {
		if (empty($dropdown)) {
			// render simple edit button
			if (isset($action['accesskey'])) {
				$accesskey = ($action['accesskey'] !== false) ? (' accesskey="' . $action['accesskey'] . '"') : '';
			}
			else {
				$accesskey = ' accesskey="e"';
			}
?>
			<a<?= $accesskey ?> href="<?= htmlspecialchars($action['href']) ?>" class="<?= Sanitizer::encodeAttribute( $class ) ?>" <?= ( !empty($nofollow) ? 'rel="nofollow"' : '' ); ?> data-id="<?= $actionName ?>"<?= $tooltip ?><?= $tabindex ?>><?= $icon ?> <?= htmlspecialchars($action['text']) ?><?= isset($action['html']) ? $action['html'] : '' ?></a>
<?php
		}
		// render edit button with dropdown
		else {
?>
<nav class="<?= Sanitizer::encodeAttribute( $class ) ?><?= (isset($action['href']) || $actionName == 'submit') ? '' : ' combined' ?>" <?= empty($id) ? '' : 'id="'.$id.'"'?>>
<?php
			// render edit menu
			if (isset($action['href'])) {
?>
	<a <?= !empty($actionAccessKey) ? "accesskey=\"{$actionAccessKey}\"" : '' ?> <?= !empty($data['action']['tabindex']) ? "tabindex=\"{$data['action']['tabindex']}\"" : '' ?> href="<?= empty($action['href']) ? '' : htmlspecialchars($action['href']) ?>" data-id="<?= $actionName ?>" <?= empty($action['id']) ? '' : 'id="'.$action['id'].'"'?>>
		<?= $icon ?> <?= htmlspecialchars($action['text']) ?>
	</a>
<?php
			}
			else if ($actionName == 'submit') { ?>
				<input id="<?= $action['id'] ?>" class="<?= Sanitizer::encodeAttribute( $action['class'] ) ?>" type="submit" value="<?= $action['text'] ?>"/>
<?php
			}
			// render menu without URL defined for a button
			else {
?>
	<?= $icon ?> <?= htmlspecialchars($action['text']) ?>
<?php
			}
?>

	<span class="drop">
		<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
	</span>
	<ul class="WikiaMenuElement">
<?php
			foreach($dropdown as $key => $item) {
				// render accesskeys
				if (!empty($item['accesskey'])) {
					$accesskey = ' accesskey="' . $item['accesskey'] . '"';
				}
				else {
					$accesskey = '';
				}

				$href = isset($item['href']) ? htmlspecialchars($item['href']) : '#';
?>
		<li>
			<a href="<?= $href ?>" <?= $accesskey ?> data-id="<?= $key ?>" <?= empty($item['title']) ? '' : ' title="'.$item['title'].'"'; ?> <?= empty($item['id']) ? '' : ' id="'.$item['id'].'"' ?><?= empty($item['class']) ? '' : ' class="'. Sanitizer::encodeAttribute( $item['class'] ) .'"' ?><?= empty($item['attr']) ? '' : ' '.$item['attr'] ?>><?=htmlspecialchars($item['text']) ?></a>
		</li>
<?php
			}
?>
	</ul>
</nav>
<?php
		}
	}
?>
