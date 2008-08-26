<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#cityselect {z-index:9000} /* for IE z-index of absolute divs inside relative divs issue */
#citydomain {z-index:0;} **//* abs for ie quirks */

/*** Search suggest ***/
#var-autocomplete .yui-ac-container {
	z-index: 1000;
	position: absolute;
	top: 25px;
	left: 5px;
	width: 171px;
}
#var-autocomplete .yui-ac-content{
	border:1px solid #808080 !important;
	color: #000;
	position: absolute;
	width: 100%;
	background:#fff;
	overflow:hidden;
	z-index:9050;
}
#var-autocomplete .yui-ac-content ul {
	float: none !important;
	margin: 0 !important;
	padding: 0 !important;
	width: 100%;
}
#var-autocomplete .yui-ac-content li {
	float: none !important;
	font-size: 9pt;
	margin: 0 !important;
	/*padding: 2px 5px !important;*/
	padding: 1px 0px 0px 3px;
	cursor: default;
	white-space: nowrap;
}

.wk-form-row { list-style-type: none; display: inline; margin:0; }
.wk-form-row li { display: inline; }
.wk-form-row label { width: 10em; float: left; text-align: left; vertical-align: middle; margin: 5px 0 0 0; }

/** overwrite some pager styles **/
table.TablePager { border: 1px solid gray;}
/*]]>*/
</style>
<!-- s:short info -->
<ul>
	<li>
		You can use this page by requesting
		<strong><?php echo $title->getFullUrl() ?>/wikia-name</strong>
	</li>
	<li>
		You can use "shortcuts" for wikia address (<strong>.wikia.com</strong>
		will be added automaticly). For example food means food.wikia.com
	</li>
	<li>
		You can start typing begining of domain name into input field below
	</li>
	<li>
		You can find Wikia in table
	</li>
	<li>
		<a href="<?php echo $title->getFullUrl() ?>/change.log"><strong>Changelog for variables (all wikis)</strong></a>
	</li>
</ul>
<!-- e:short info -->
<br />
<form method="post" action="<?= $title->getLocalUrl( 'action=select' ) ?>">

<div class="wk-form-row">
 <ul>
 <li><label>Domain name</label></li>
 <li><input type="text" name="wpCityDomain" id="citydomain" value="<?= $domain ?>" size="24" maxlength="255" /></li>
 <li><button style="z-index:9002">Get configuration</button></li>
 </ul>
</div>
<div class="wk-form-row">
<ul>
 <li><label>&nbsp;</label></li>
 <li><div id="var-autocomplete"></div></li>
</div>
</ul>
</form>
<script type="text/javascript">
/*<![CDATA[*/

var wkDataSource = new YAHOO.widget.DS_XHR("<?php echo $GLOBALS["wgScript"] ?>", ["\n", "\t"] );
wkDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
wkDataSource.scriptQueryParam = "rsargs[0]";
wkDataSource.scriptQueryAppend = "action=ajax&rs=axWFactoryDomainQuery";
wkDataSource.connTimeout = 3000;

var wkAutoComp = new YAHOO.widget.AutoComplete("citydomain","var-autocomplete", wkDataSource);
wkAutoComp.maxCacheEntries = 5000;
wkAutoComp.minQueryLength = 3;
wkAutoComp.queryMatchContains = true;
wkAutoComp.queryDelay = 0;
wkAutoComp.typeAhead = false;
wkAutoComp.animHoriz = false;
wkAutoComp.animSpeed = 0.2;
wkAutoComp.queryMatchSubset = true;

/*]]>*/
</script>

<div id="wf-city-list">
	<?php echo $limit ?>
	<br />
	<?php echo  $body ?>
	<br />
	<?php echo  $nav ?>
</div>
<!-- e:<?= __FILE__ ?> -->
