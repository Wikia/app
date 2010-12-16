<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

global $wgHooks;

$wgHooks['SkinTemplateToolboxEnd'][] = 'wfFundHook';

function wfFundHook() {
	$msg = <<<ENDHTML

<hr style="height:1px;color:black;" noshade>

Support OmegaWiki development by donating to Stichting Open Progress, a not-for-profit organization:

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <font face="Verdana, Arial, Helvetica, sans-serif">
          <input type="hidden" name="cmd" value="_xclick">

          <input type="hidden" name="business" value="money@openprogress.org">
          <input type="hidden" name="item_name" value="Support OmegaWiki">
          <input type="hidden" name="item_number" value="001">

          <input type="image"
src="http://www.paypal.com/images/x-click-but04.gif" border="0" name=
          </font>
        </form>

<br />
<a href="http://openprogress.org/Donations%2C_putting_your_money_where_your_mouth_is">More information</A>
  
ENDHTML;
	echo( $msg );
	return true;
}
?>
