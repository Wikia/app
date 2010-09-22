<!-- s:<?php echo __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
<?php
	if (Wikia::isOasis()) {
		$css = wfGetSassUrl('extensions/wikia/WikiFactory/css/oasis.scss');
		echo "@import url('{$css}');\n\n";
	}

	// TODO: move these CSS rules to oasis.scss
?>
#cityselect {z-index:9000} /* for IE z-index of absolute divs inside relative divs issue */
#citydomain {z-index:0;} /* abs for ie quirks */

#WikiFactoryDomainSelector {position: relative; z-index: 10}
#citydomain {width: 350px}

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
		You can <a href="<?php echo $title->getFullUrl() ?>/add.variable"><strong>add a new variable</strong></a> to be managed by WikiFactory
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
<form id="WikiFactoryDomainSelector" method="post" action="<?php echo $title->getLocalUrl( 'action=select' ) ?>">
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
	$.loadJQueryAutocomplete(function() {
		$('#citydomain').autocomplete({
			serviceUrl: wgServer + wgScript + '?action=ajax&rs=axWFactoryDomainQuery',
			onSelect: function(v, d) {
				// redirect to Special:WikiFactory/<city id>
				window.location.href = wgArticlePath.replace(/\$1/, wgPageName + '/' + d);
			},
			appendTo: '#WikiFactoryDomainSelector',
			deferRequestBy: 0,
			maxHeight: 300,
			minChars: 3,
			width: 350
		});
	});
/*]]>*/
</script>
<br />
<?php if( !empty( $domain) && !empty( $GLOBALS[ "wgDevelEnvironment" ])): ?>
<h2>Results for <?php echo $domain ?>:</h2>
<?php echo $pager ?>
<?php endif ?>
<!-- e:<?php echo __FILE__ ?> -->
