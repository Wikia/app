<?php foreach ( $stories as $story ) : ?>
	<?= $story['title'] ?>
	<?= $story['excerpt'] ?>
	<?= $story['vertical'] ?>
	<?= $story['image'] ?>
	<?= $story['url'] ?>
<?php endforeach;
