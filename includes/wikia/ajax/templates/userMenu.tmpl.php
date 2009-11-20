<div class="headerMenu color1 reset" id="headerMenuUser">
	<ul>
<?php
	foreach($links as $id => $link) {
?>
		<li<?= ($id == 'widgets') ? ' id="cockpit1"' : '' ?>><a id="<?php echo $link['id']; ?>" href="<?= $link['href'] ?>" title="<?= $link['tooltip'] ?>" accesskey="<?= $link['accesskey'] ?>"><?= htmlspecialchars($link['text']) ?></a></li>
<?php
	}
?>
	</ul>
</div>
