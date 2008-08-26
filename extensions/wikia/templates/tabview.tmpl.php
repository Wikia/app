<!-- js part -->
<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/skins/common/yui/tabview/assets/border_tabs.css?61"/>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/element/element-beta-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/tabview/tabview-min.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wikia.CustomizeWiki");
YAHOO.Wikia.CustomizeWiki.tabs = new YAHOO.widget.TabView("customizewiki-tabview");
/*]]>*/
</script>

<div id="customizewiki-tabview" class="yui-navset">
    <ul class="yui-nav">
<?php foreach ($names as $id => $name): ?>
        <li <?= ($id==0) ? 'class="selected"': ""; ?>><a href="#<?= $name ?>"><em><?= $labels[$id] ?></em></a></li>
<?php endforeach ?>
    </ul>
    <div class="yui-content" style="padding: 1em;">
<?php foreach ($pages as $id => $page): ?>
        <div id="<?= $labels[$id] ?>"><p><?= $page ?></p></div>
<?php endforeach ?>
    </div>
</div>
