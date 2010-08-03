<?php

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'MiniDonation',
	'url' => 'http://mediawiki.org/wiki/Extension:MiniDonation',
	'description' => 'Adds a tag <tt>&lt;donateform&gt;</tt> to support donations via PayPal',
	'descriptionmsg' => 'donationform-desc',
	'svn-date' => '$LastChangedDate: 2008-07-04 17:36:45 +0200 (ptk, 04 lip 2008) $',
	'svn-revision' => '$LastChangedRevision: 37061 $',
);

$wgExtensionFunctions[] = 'wfSetupMiniDonation';
$wgExtensionMessagesFiles['MiniDonation'] = dirname(__FILE__) . '/MiniDonation.i18n.php';

function wfSetupMiniDonation() {
	global $wgParser;

	$wgParser->setHook( 'donationform', 'wfMiniDonationHook' );
}

function wfMiniDonationHook( $text, $params, $parser ) {
	wfLoadExtensionMessages( 'MiniDonation' );

	$default = "25";
	$fontSize = "90%";
	$encDefault = htmlspecialchars( $default );
	$encDonate = htmlspecialchars( wfMsg( 'donationform-submit' ) );
	return <<<EOT
<span class="wikimedia-mini-donation"><form style="display: inline" action="https://www.paypal.com/cgi-bin/webscr" method="post" onsubmit="if(document.getElementById('don-amount-pp').value.indexOf('.') &gt;= 0 &amp;&amp; document.getElementById('don-amount-pp').value.indexOf('.00') &lt; 0) {alert('Sorry, but we can only accept donations in whole amounts.'); return false;}">
<!-- hidden data -->
<input type="hidden" name="business" value="donation@wikipedia.org" />
<input type="hidden" name="item_name" value="One-time donation" />
<input type="hidden" name="item_number" value="DONATE" />
<input type="hidden" name="no_note" value="0" />
<input type="hidden" name="amount" value="1" />
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="on1" value="Comment" />
<input type="hidden" name="lc" value="en" />
<input type="hidden" name="on0" value="Anonymity" />
<input type="hidden" name="notify_url" value="https://office2.wikimedia.org/payments/paypal/" />
<!-- amount field -->
<input type="text" name="quantity" id="don-amount-pp" maxlength="30" size="5" value="$encDefault" style="font-size: $fontSize" /> <!-- currency menu -->
<!-- -->
<select name="currency_code" size="1" style="font-size: $fontSize">
<option value="USD">USD&#160;–&#160;$</option>
<option value="GBP">GBP&#160;–&#160;£</option>
<option value="EUR">EUR&#160;–&#160;€</option>
<option value="USD">-------</option>
<option value="AUD">AUD&#160;–&#160;$&#160;</option>
<!-- -->
<option value="CAD">CAD&#160;–&#160;$</option>
<option value="CHF">CHF&#160;–&#160;</option>
<option value="CZK">CZK&#160;–&#160;Kč</option>
<option value="DKK">DKK&#160;–&#160;kr</option>
<option value="EUR">EUR&#160;–&#160;€</option>
<!-- -->
<option value="HKD">HKD&#160;–&#160;HK$</option>
<option value="HUF">HUF&#160;–&#160;Ft</option>
<option value="GBP">GBP&#160;–&#160;£</option>
<option value="JPY">JPY&#160;–&#160;¥</option>
<option value="NZD">NZD&#160;–&#160;NZ$</option>
<!-- -->
<option value="NOK">NOK&#160;–&#160;kr</option>
<option value="PLN">PLN&#160;–&#160;zł</option>
<option value="SGD">SGD&#160;–&#160;S$</option>
<option value="SEK">SEK&#160;–&#160;kr</option>
<option value="USD">USD&#160;–&#160;$</option>
</select>
<input type="hidden" name="os0" value="Don't mention my name" />
<input type="submit" value="$encDonate" style="font-size: $fontSize" />
</form></span>
EOT;
}
