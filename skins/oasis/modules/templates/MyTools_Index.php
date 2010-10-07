<ul id="my-tools-menu" class="my-tools-menu">

<?php
foreach($customTools as $tool) {
	if($tool['usercan']) {
?>
		<li class="custom"><a href="<?= $tool['href'] ?>" data-name="<?= $tool['name'] ?>"><?= $tool['text'] ?></a></li>
<?php
	} else {
?>
		<li class="custom"><span><?= $tool['text'] ?></span></li>
<?php
	}
}
?>

<?php foreach($defaultTools as $tool) { ?>
	<li class="default">
		<a href="<?= $tool['href'] ?>" data-name="<?= $tool['name'] ?>"><?= $tool['text'] ?></a>
	</li>
<?php } ?>

	<li>
		<a href="#" class="my-tools-edit"><?= wfMsg('oasis-edit-my-tools-link') ?></a>
	</li>

</ul>