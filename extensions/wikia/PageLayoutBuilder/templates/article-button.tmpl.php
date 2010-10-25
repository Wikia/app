<p><?php echo wfMsg("plb-create-from-article-new"); ?></p>
<input type="submit" value="<?php echo wfMsg("plb-create-from-article-button") ?>" title="<?php echo wfMsg("plb-create-from-article-button") ?>" name="wpCreatePLB" id="wpCreatePLB"/>
<?php echo wfMsg("plb-create-from-article-button-desc"); ?>
<script type="text/javascript">
	$("#wpCreatePLB").click(function() {
		$("#editform").attr("action", "<?php echo $post_url ?>");
		$("#editform").submit();
	});
</script>
