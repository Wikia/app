<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#cityselect {z-index:9000} /* for IE z-index of absolute divs inside relative divs issue */
#citydomain {z-index:0;} **//* abs for ie quirks */


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
			minChars:3,
			deferRequestBy: 0
		});
	});
/*]]>*/
</script>
<br />
<?php if( !empty( $domain) ): ?>
<h2>Results for <?php echo $domain ?>:</h2>
<?php /**
<div id="wf-city-list">
	<br />
	<?php echo  $body ?>
	<br />
	<?php echo  $nav ?>
</div>
**/ ?>
<?php endif ?>
<!-- e:<?= __FILE__ ?> -->
