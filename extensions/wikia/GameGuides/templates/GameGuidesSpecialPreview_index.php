<style>
	.preview {
		width: 320px;
		height: 480px;
		margin: 5px;
		display: inline-block;
		border: 2px solid grey;
		box-shadow: 0 0 3px black;
	}
</style>
<? foreach ( $urls as $url ): ?>
<iframe class='preview' src="<?= $url; ?>"></iframe>
<? endforeach; ?>