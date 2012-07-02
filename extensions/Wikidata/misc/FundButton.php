<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

global $wgHooks;

$wgHooks['SkinTemplateToolboxEnd'][] = 'wfFundHook';

function wfFundHook() {
	$msg = <<<ENDHTML
<li style="list-style: none">
<hr style="height:1px;color:black;border-width:0;" />
Support OmegaWiki development by donating to Stichting Open Progress, a not-for-profit organization:

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <p>
          <input type="hidden" name="cmd" value="_xclick" />

          <input type="hidden" name="business" value="money@openprogress.org" />
          <input type="hidden" name="item_name" value="Support OmegaWiki" />
          <input type="hidden" name="item_number" value="001" />

          <input type="image" src="http://www.paypal.com/images/x-click-but04.gif" style="border: 0" />
          </p>
        </form>
</li>
<li><a href="http://openprogress.org/Donations%2C_putting_your_money_where_your_mouth_is">More information</a></li>

ENDHTML;
	echo( $msg );
	return true;
}
?>
