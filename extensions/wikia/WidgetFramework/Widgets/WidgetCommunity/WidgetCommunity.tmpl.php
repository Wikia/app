<div class="community_header">
	<?= $header ?>
</div>
<div class="community_body">
	<?= $feedHTML ?>
</div>
<div class="community_footer">
	<a id="community-widget-action-button" href="<?= $footerButton['href'] ?>" class="<?= $footerButton['class'] ?>" rel="nofollow"><span><?= $footerButton['text'] ?></span></a>
</div>
<script>
var params_<?= $tagid ?> = '<?= $jsParams ?>';
</script>