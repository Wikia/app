<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
div.ev-info-msg {
	text-align:center;
	float:left;
	background-color:<?=$setup['BackgroundColor']?>;
	color:<?=$setup['TextColor']?>;;
	height:auto;
	left:0px;
	bottom:0px;
	position:absolute;
	padding: 6px 2px 6px 2px;
	width:100%;
}
/*]]>*/
</style>
<script type="text/javascript" src="/extensions/wikia/WikiaEvents/js/wikia_events_data.js"></script>
<script type="text/javascript">
/*<![CDATA[*/

<?=$js_display?>

/*]]>*/
</script>
<?php
foreach ($text_display as $event_id => $values)
{
	ksort($values);
?>	
<div class="ev-info-msg">
<?
	foreach ($values as $id => $value) 
	{
		echo $value."\n"; 
	}
?>	
</div>
<?
}
?>
<!-- e:<?= __FILE__ ?> -->
