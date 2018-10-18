<p class="category-page__total-number">
	<?php /** @var $totalNumberOfMembers int */ ?>
	<?= wfMessage( 'category-page3-total-number', $totalNumberOfMembers )->escaped() ?>
</p>
<?php $latinChars = range( 'A', 'Z' ) ?>
<ul class="category-page__alphabet-shortcuts">
	<li class="category-page__alphabet-shortcut">
		<?php $url = Xml::escapeJsString( $title->getFullURL() ) ?>
		<?= Html::rawElement( 'a', [
			'href' => '#',
			'onclick' => "window.location.assign('" . $url . "'); return false;"
		], wfMessage( 'category-page3-shortcut-to-top' ) ) ?></li>
	<?php // Don't put a newline before </li> or the bullets will disappear ?>

	<?php foreach ( $latinChars as $char ) : ?>
		<li class="category-page__alphabet-shortcut">
			<?php $url = Xml::escapeJsString( $title->getFullURL( [ 'from' => $char ] ) ) ?>
			<?= Html::rawElement( 'a', [
				'href' => '#',
				'onclick' => "window.location.assign('" . $url . "'); return false;"
			], $char ) ?></li>
		<?php // Don't put a newline before </li> or the bullets will disappear ?>
	<?php endforeach; ?>

	<li class="category-page__alphabet-shortcut">
		<?php $url = Xml::escapeJsString( $title->getFullURL( [ 'from' => '¡' ] ) ) ?>
		<?= Html::rawElement( 'a', [
			'href' => '#',
			'onclick' => "window.location.assign('" . $url . "'); return false;"
		], wfMessage( 'category-page3-shortcut-to-other' ) ) ?></li>
	<?php // Don't put a newline before </li> or the bullets will disappear ?>
</ul>
