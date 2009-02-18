<!-- s:<?= __FILE__ ?> -->
<style>
<!---
#daemontasks-tabs {
	background-position:left top;
	background-repeat:repeat-x;
	color:white;
	font-family:tahoma,sans-serif;
	font-size:11pt;
	margin:2px 2px 0;
	overflow:hidden;
	padding:0;
	display:block;
}

.yui-nav {
	border: 0;
	margin:0 !important;	
}

.yui-content {
	background-color: #FFFFFF;
	padding:0.25em 0.5em;
	color: #000;
}

.yui-navset .yui-nav .selected a, 
.yui-navset .yui-nav .selected a:focus, /* no focus effect for selected */ 
.yui-navset .yui-nav .selected a:hover { /* no hover effect for selected */ 
    background:#FFFFFF;
    color: #000000; 
    font-weight:bold;
} 

.yui-navset .yui-nav li {
	padding-left:0px;
	padding-right:0px;
	margin:4px 4px 0 4px;
	line-height:2.6em;
}

.yui-navset .yui-nav li a em, .yui-navset-top .yui-nav li a em, .yui-navset-bottom .yui-nav li a em {
	display:block;
	padding:0 5px;
}
-->
</style>
<script>
var tabView;
</script>
<?php if (!empty($saved)) { ?>
<?php if ($saved == -1) { ?> 
	<div class="errorbox"><strong><?=wfMsg('daemonloader_daemonnotchanged')?></strong></div>
<? } ?>
<br clear="all" />
<?php } ?>
<div id="daemontasks-tabs" class="yui-navset">
	<ul class="yui-nav reset color1 clearfix" style="float:none; background-color:none;">
		<li class="selected"><a href="#createtask"><em><?=wfMsg('daemonloader_createtask')?></em></a></li>
		<li><a href="#tasklists"><em><?=wfMsg('daemonloader_listtask')?></em></a></li>
<?php if (in_array($wgUser->getName(), $wgDaemonLoaderAdmins)) : ?>
		<li><a href="#addscript"><em><?=wfMsg('daemonloader_configure')?></em></a></li>
<?php endif ?>		
	</ul>
	<div class="yui-content">
		<div id="createtask"><p><?=$createTaskForm?></p></div>
		<div id="tasklists"><p><?=$listTaskTab?></p></div>
<?php if (in_array($wgUser->getName(), $wgDaemonLoaderAdmins)) : ?>
		<div id="addscript"><p><?=$addDaemonForm?></p></div>
<?php endif ?>		
	</div>
</div>
<script>
<!--
(function() {
    tabView = new YAHOO.widget.TabView('daemontasks-tabs');
	var act_saved = '<?=$saved?>';
	if (act_saved == 2) {
		tabView.set('activeIndex', 1);
	}
})();
-->
</script>
<!-- e:<?= __FILE__ ?> -->
