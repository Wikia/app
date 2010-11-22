<fieldset class="panel">
<p><b><? echo wfMsgHtml( 'adss-your-balance' ); ?></b> <?php echo wfMsgHtml( 'adss-amount', $balance ); ?><br />
<b><? echo wfMsgHtml( 'adss-your-billing-agreement' ); ?></b> <?php echo $baid; ?></p>

<?php echo $billing; ?>
<?php echo $navigationBar; ?>
</fieldset>

<script type="text/javascript">/*<![CDATA[*/
$(function() {
	var changeTooltipPosition = function(event) {
		var tooltipX = event.pageX - 8;
		var tooltipY = event.pageY + 8;
		$('div.tooltip').css({top: tooltipY, left: tooltipX});
	};

	var showTooltip = function(event) {
		$('div.tooltip').remove();
		$('<div class="tooltip"></div>')
		.append( $(this).find("div").html() )
		.appendTo('body');
		changeTooltipPosition(event);
	};

	var hideTooltip = function() {
		$('div.tooltip').remove();
	};

	$('td.TablePager_col_description').bind({
		mousemove: changeTooltipPosition,
		mouseenter: showTooltip,
		mouseleave: hideTooltip
	});
} );
</script>
