<style>
	#preview {
		width: 320px;
		height: 480px;
		margin: 20px auto;
		display: block;
		border: 2px solid;
		box-shadow: 0 0 3px black;
	}
</style>
<?= $wf->Msg('wikiagameguides-preview-description')?>
<iframe id='preview' src="<?= $url; ?>"></iframe>