<p class="category-page__total-number">
	<?php /** @var $totalNumberOfMembers int */ ?>
	<?= wfMessage( 'category-page3-total-number', $totalNumberOfMembers )->escaped() ?>
</p>
<ul class="category-page__alphabet-shortcuts">
	<?php foreach ( $alphabetShortcuts as $shortcut ) : ?>
		<li class="category-page__alphabet-shortcut<?= $shortcut['isActive'] ? ' is-active': '' ?>">
			<?= Html::rawElement( 'a', [
				'href' => '#',
				'rel' => 'nofollow',
				'data-category-url-encoded' => base64_encode( $title->getFullURL( [ 'from' => $shortcut['from'] ] ) )
			], $shortcut['label'] ) ?></li>
		<?php // Don't put a newline before </li> or the bullets will disappear ?>
	<?php endforeach; ?>
</ul>
