<p class="category-page__total-number">
	<?php /** @var $totalNumberOfMembers int */ ?>
	<?= wfMessage( 'category-page3-total-number', $totalNumberOfMembers )->escaped() ?>
</p>
<ul class="category-page__alphabet-shortcuts">
	<?php foreach ( $alphabetShortcuts as $shortcut ) : ?>
		<li class="category-page__alphabet-shortcut<?= $shortcut['isActive'] ? ' is-active': '' ?>">
			<?php $url = Xml::escapeJsString( $title->getFullURL( [ 'from' => $shortcut['from'] ] ) ) ?>
			<?= Html::rawElement( 'a', [
				'href' => '#',
				'onclick' => "window.location.assign('" . $url . "'); return false;"
			], $shortcut['label'] ) ?></li>
		<?php // Don't put a newline before </li> or the bullets will disappear ?>
	<?php endforeach; ?>
</ul>
