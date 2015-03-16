<style>
	img {
		left: 50%;
		margin: -8px;
		position: absolute;
		top: 50%;
	}
	form {
		display: none;
	}
</style>
<form method="POST" action="<?= htmlspecialchars($mercuryUrl); ?>">
	<textarea name="parserOutput"><?= htmlspecialchars($parserOutput) ?></textarea>
	<textarea name="title"><?= htmlspecialchars($title) ?></textarea>
	<textarea name="mwHash"><?= htmlspecialchars($mwHash) ?></textarea>
	<button type="submit">Go</button>
</form>
<script>
	var img = new Image();
	img.src = parent.stylepath + '/common/images/ajax.gif';
	document.body.appendChild(img);
	document.querySelector('form').submit();
</script>
