<script type="text/javascript">/*<![CDATA[*/
	$.tracker.byStr(<?= $trackerString; ?>);
/*]]>*/
</script>
<?= wfMsgWikiHtml( $msgKey ); ?>
<?php if (!empty($upsellForm)): ?>
	<?=$upsellForm; ?>
<?php endif; ?>
