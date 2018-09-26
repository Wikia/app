<?php /** @var array $members */ ?>
<?php foreach ( $members as $firstChar => $items ) : ?>
    <h3><?= $firstChar ?></h3>
    <ul>
		<?php foreach ( $items as $item ) : ?>
            <li><?= $item ?></li>
		<?php endforeach; ?>
    </ul>
<?php endforeach; ?>
