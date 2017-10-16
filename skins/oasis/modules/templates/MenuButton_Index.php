<?php
	if (is_array($action) && !empty($action)) {
		if (empty($dropdown)) {
			// render simple edit button
			if (isset($action['accesskey'])) {
				$accesskey = ($action['accesskey'] !== false) ? (' accesskey="' . Sanitizer::encodeAttribute( $action['accesskey'] ) . '"') : '';
			}
			else {
				$accesskey = ' accesskey="e"';
			}
?>
			<a<?= $accesskey ?> href="<?= htmlspecialchars($action['href']) ?>" class="<?= Sanitizer::encodeAttribute( $class ) ?>" <?= ( !empty($nofollow) ? 'rel="nofollow"' : '' ); ?> data-id="<?= Sanitizer::encodeAttribute( $actionName ); ?>"<?= $tooltip ?><?= $tabindex ?>><?= $icon ?> <?= htmlspecialchars($action['text']) ?><?= isset($action['html']) ? $action['html'] : '' ?></a>
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
	<a <?= !empty($actionAccessKey) ? 'accesskey="' . Sanitizer::encodeAttribute( $actionAccessKey ) . '"' : '' ?> <?= !empty($data['action']['tabindex']) ? 'tabindex="' . Sanitizer::encodeAttribute( $data['action']['tabindex'] ) . '"' : '' ?> href="<?= empty($action['href']) ? '' : Sanitizer::encodeAttribute( $action['href'] ) ?>" data-id="<?= Sanitizer::encodeAttribute( $actionName ) ?>" <?= empty($action['id']) ? '' : 'id="'. Sanitizer::encodeAttribute( $action['id'] ) .'"'?>>
		<?= $icon ?> <?= htmlspecialchars($action['text']) ?>
	</a>
<?php
			}
			else if ($actionName == 'submit') { ?>
				<input id="<?= Sanitizer::encodeAttribute( $action['id'] ) ?>" class="<?= Sanitizer::encodeAttribute( $action['class'] ) ?>" type="submit" value="<?= Sanitizer::encodeAttribute( $action['text'] ) ?>"/>
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
					$accesskey = ' accesskey="' . Sanitizer::encodeAttribute( $item['accesskey'] ) . '"';
				}
				else {
					$accesskey = '';
				}

				$href = $item['href'] ?? '#';
?>
		<li>
			<a href="<?= Sanitizer::encodeAttribute( $href ); ?>" <?= $accesskey ?> data-id="<?= Sanitizer::encodeAttribute( $key ); ?>" <?= empty($item['title']) ? '' : ' title="'. Sanitizer::encodeAttribute( $item['title'] ) .'"'; ?> <?= empty($item['id']) ? '' : ' id="'. Sanitizer::encodeAttribute( $item['id'] ) .'"' ?><?= empty($item['class']) ? '' : ' class="'. Sanitizer::encodeAttribute( $item['class'] ) .'"' ?><?= empty($item['attr']) ? '' : ' '.$item['attr'] ?>><?=htmlspecialchars($item['text']) ?></a>
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
