<p><?= wfMsg('recipes-template-toggle-label') ?></p>
<fieldset class="recipes-template-toggle accent reset">
	<ul>
<?php
	global $wgTitle;
	$currentPage = $wgTitle->getText();

	foreach($toggles as $toggle) {
		$selected = $currentPage == $toggle['specialPage'];

		if ( !empty( $toggle['type'] ) ) {
			$href = htmlspecialchars(Skin::makeSpecialUrl( $toggle['specialPage'], array( 'type' => $toggle['type'] ) ));
		} else {
			$href = htmlspecialchars(Skin::makeSpecialUrl($toggle['specialPage']));
		}
		$label = htmlspecialchars(wfMsg("recipes-template-toggle-{$toggle['name']}-label"));
?>
		<li<?= $selected ? ' class="accent"' : '' ?>><a href="<?= $href ?>" ref="<?= $toggle['name'] ?>"><?= $label ?></a></li>
<?php
	}
?>
	</ul>
</fieldset>
