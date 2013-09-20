<style>
	.gg-preview {
		width: 320px;
		height: 480px;
		margin: 5px;
		display: inline-block;
		border: 2px solid grey;
		box-shadow: 0 0 3px black;
	}

	#skinMode {
		display: block;
	}
</style>
<button id=skinMode>Change Skin Mode</button>
<? foreach ( $urls as $url ): ?>
<iframe class='gg-preview' src="<?= $url; ?>"></iframe>
<? endforeach; ?>
<script>
	$('#skinMode').on('click', function(){
		$('.gg-preview').each(function(){
			this.contentWindow.Skin.getInstance().toggleMode();
		});
	});
</script>