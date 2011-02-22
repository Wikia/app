<section class="SpecialOffer">
<h3><?php echo wfMsgHtml('adss-upsell-header'); ?></h3>
<?php echo wfMsgWikiHtml('adss-upsell-text', $promoPrice, $regularPrice); ?>
<div id="SpecialOfferButtons"><a class="wikia-button" id="wpSpecialOfferYes" href="#"><?php echo wfMsgHtml('adss-upsell-yes'); ?></a> <a id="wpSpecialOfferNo" href="#"><?php echo wfMsgHtml('adss-upsell-no'); ?></a></div>
<div id="SpecialOfferConfirmation" style="display:none"><b><?php echo wfMsgHtml('adss-upsell-thanks'); ?></b></div>
<div id="SpecialOfferError" style="display:none"><b><?php echo wfMsgHtml('adss-upsell-error'); ?></b></div>
<div id="SpecialOfferThrobber" style="display:none"><img src="<?php echo $GLOBALS['wgStylePath']; ?>/common/images/ajax.gif" class="throbber" /></div>
</section>

<p><?php echo wfMsgWikiHtml('adss-form-buy-another'); ?></p>

<script type="text/javascript">/*<![CDATA[*/
var adId = <?php echo Xml::encodeJsVar( $adId ); ?>;
var token = <?php echo Xml::encodeJsVar( $token ); ?>;
$("#wpSpecialOfferYes").click( function(e) {
	e.preventDefault();
	$("#SpecialOfferButtons").hide();
	$("#SpecialOfferThrobber").show();
	$.post( wgScript, {
		'action': 'ajax',
		'rs': 'AdSS_Controller::upsellAjax',
		'rsargs[0]': adId,
		'rsargs[1]': token,
		}, function(response) {
			$("#SpecialOfferThrobber").hide();
			if( response.result == "success" ) {
				$("#SpecialOfferConfirmation").show();
			} else {
				$("#SpecialOfferError").show();
			}
		}, "json" );
} );
$("#wpSpecialOfferNo").click( function(e) {
	e.preventDefault();
	$("section.SpecialOffer").hide();
} );
/*]]>*/</script>
