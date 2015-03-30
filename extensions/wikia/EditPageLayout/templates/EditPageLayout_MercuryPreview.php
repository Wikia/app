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
<form method="POST" action="<?= Sanitizer::encodeAttribute( $mercuryUrl ); ?>">
	<textarea name="parserOutput"><?= htmlspecialchars( $parserOutput ); ?></textarea>
	<textarea name="mwHash"><?= htmlspecialchars( $mwHash ) ?></textarea>
</form>
<script>
	var img = new Image();
	img.src = parent.stylepath + '/common/images/ajax.gif';
	img.onload = img.onerror = function () {
		document.querySelector('form').submit();
	};
	document.body.appendChild(img);
</script>
