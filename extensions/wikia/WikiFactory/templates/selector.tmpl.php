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
		You can use filters in the <a href="<?php echo $title->getFullUrl() ?>/metrics"><strong>metrics interface</strong></a>
	</li>
	<li>
		<a href="<?php echo $title->getFullUrl() ?>/change.log"><strong>Changelog for variables (all wikis)</strong></a>
	</li>
</ul>
<!-- e:short info -->
<br />
<form method="post" action="<?php echo $title->getLocalUrl( 'action=select' ) ?>">
<div class="wk-form-row">
 <ul>
 <li><label>Domain name</label></li>
 <li><input type="text" name="wpCityDomain" id="citydomain" value="<?php echo $domain ?>" size="24" maxlength="255" /></li>
 <li><button style="z-index:9002">Get configuration</button></li>
 </ul>
</div>
</form>
<script type="text/javascript">
/*<![CDATA[*/
	$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
		$('#citydomain').autocomplete({
			serviceUrl: wgServer+wgScript+'?action=ajax&rs=axWFactoryDomainQuery',
			minChars:3
		});
	});
/*]]>*/
</script>
<?php /**
<div id="wf-city-list">
	<?php echo $limit ?>
	<br />
	<?php echo  $body ?>
	<br />
	<?php echo  $nav ?>
</div>
**/ ?>
<!-- e:<?= __FILE__ ?> -->
