<div class="headerMenu color1 reset" id="headerMenuUser">
	<ul>
<?php
	foreach($links as $id => $link) {
?>
		<li<?= ($id == 'widgets') ? ' id="cockpit1"' : '' ?>><a href="<?= $link['href'] ?>" title="<?= $link['tooltip'] ?>" accesskey="<?= $link['accesskey'] ?>"><?= htmlspecialchars($link['text']) ?></a></li>
<?php
	}
?>
	</ul>
</div>

<script type="text/javascript">
	$("#headerMenuUser").makeHeaderMenu("headerButtonUser", {attach_to: "#wikia_page", attach_at: "top"});
	$('#cockpit1').click(WidgetFramework.show_cockpit);
</script>
