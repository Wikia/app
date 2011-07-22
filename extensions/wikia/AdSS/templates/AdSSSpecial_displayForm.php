<a name="form"></a>

<section class="SponsoredLinkDesc">
	<div id="paypay-error" class="error error-wpType"></div>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>
	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-site-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"></div>
			<div class="corner-right"></div>
		</div>
		<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
		<div class="price"><?= AdSS_Util::formatPrice( $sitePricing ) ?></div>
		<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?>
		<a class="wikia-button" id="wpSelectSite" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
	</section>

	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-site-premium-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"></div>
			<div class="corner-right"></div>
		</div>
		<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
		<div class="price"><?= AdSS_Util::formatPrice( $sitePricing, 3 ) ?></div>
		<?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?>
		<a class="wikia-button" id="wpSelectSitePremium" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
	</section>

	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-hub-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"></div>
			<div class="corner-right"></div>
		</div>
		<h3><?php echo wfMsgHtml( 'adss-form-hub-plan-header', $hubName ); ?></h3>
		<div class="price"><?= AdSS_Util::formatPrice( $hubPricing ) ?></div>
		<?php echo wfMsgWikiHtml( 'adss-form-hub-plan-description', $hubName, $wikiCount ); ?>
		<a class="wikia-button" id="wpSelectHub" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
	</section>
</section>

<section class="SponsoredLinkForm">
	<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
		<input name="wpToken" id="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" id="wpType" type="hidden" value="<?php echo $adForm->output( 'wpType' ); ?>" />

		<fieldset class="form">
			<h1><?php echo wfMsgHtml( 'adss-form-header' ); ?></h1>

			<label for="wpUrl">
				<?php echo wfMsgHtml( 'adss-form-url' ); ?>
				<span class="form-questionmark" data-tooltip="<?= wfMsgHtml( 'adss-form-tooltip-clickurl' ); ?>"></span>
			</label>
			<div id="paypay-error" class="error error-wpUrl"></div>
			<input type="text" name="wpUrl" id="wpUrl" value="<?php $adForm->output( 'wpUrl' ); ?>" />

			<div>
			<label for="wpText">
				<?php echo wfMsgHtml( 'adss-form-linktext' ); ?>
				<span class="form-questionmark" data-tooltip="<?= wfMsgHtml( 'adss-form-tooltip-adtitle' ); ?>"></span>
			</label>
			<div id="paypay-error" class="error error-wpText"></div>
			<input type="text" name="wpText" id="wpText" value="<?php $adForm->output( 'wpText' ); ?>" />

			<label for="wpDesc">
				<?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?>
				<span class="form-questionmark" data-tooltip="<?= wfMsgHtml( 'adss-form-tooltip-addesc' ); ?>"></span>
			</label>
			<div id="paypay-error" class="error error-wpDesc"></div>
			<textarea name="wpDesc" id="wpDesc"><?php $adForm->output( 'wpDesc' ); ?></textarea>
			</div>

			<label for="wpEmail">
				<?php echo wfMsgHtml( 'adss-form-email' ); ?>
				<span class="form-questionmark" data-tooltip="<?= wfMsgHtml( 'adss-form-tooltip-email' ); ?>"></span>
			</label>
			<div id="paypay-error" class="error error-wpEmail"></div>
			<input type="text" name="wpEmail" id="wpEmail" value="<?php $adForm->output( 'wpEmail' ); ?>" />

			<div>
			<label for="wpWeight"><?php echo wfMsgHtml( 'adss-form-shares' ); ?></label>
			<div id="paypay-error" class="error error-wpWeight"></div>
			<select name="wpWeight" id="wpWeight">
			  <?php for( $i=1; $i<=4; $i++): ?>
			  <option<?php if( $adForm->get('wpWeight')==$i ) echo " selected"; ?>><?php echo $i;?></option>
			  <?php endfor; ?>
			</select>
			</div>

			<?php if( !$isAdmin && !$isUser ): ?>
			<div style="display:none">
			<?php endif; ?>
			<label for="wpPassword"><?php echo wfMsgHtml( 'adss-form-password' ); ?></label>
			<input type="password" name="wpPassword" id="wpPassword" value="<?php $adForm->output( 'wpPassword' ); ?>" />
			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $login; ?>" />
			<?php if( !$isAdmin ): ?>
			<p><?php echo wfMsgHtml( 'adss-form-or' ); ?></p>
			<?php if( !$isUser ): ?>
			</div>
			<?php endif; ?>

			<div class="paypal-pay">
				<span class="paypal-logo"></span>
				<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
			</div>
			<?php endif; ?>
		</fieldset>

		<fieldset class="preview">
			<h1><?php echo wfMsgHtml( 'adss-preview-header' ); ?></h1>
			<?php echo wfMsgWikiHtml( 'adss-ad-header' ); ?>
			<div class="sponsormsg-preview">
			<ul>
			  <?php echo $ad ?>
			</ul>
			</div>
		</fieldset>
	</form>

</section>

<script type="text/javascript">/*<![CDATA[*/
$(function() {
	// tracking code
	$.tracker.byStr("adss/form/view");

	if( $("#wpType").val() == "site-premium" ) {
		$("#wpSelectSitePremium").parent().addClass("selected");
		$("#wpWeight").val("4").attr("disabled", true);
	}
	else if( $("#wpType").val() == "site" ) {
		$("#wpSelectSite").parent().addClass("selected");
	}
	else if( $("#wpType").val() == "hub" ) {
		$("#wpSelectHub").parent().addClass("selected");
	}
	if( location.href.indexOf("#") == -1 ) {
		location.href = location.href + "#form";
	}
} );
$("#wpSelectSite").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("site");
	$("#wpWeight").val("1").removeAttr("disabled").parent().show();
	$('.box .corner-right, .box .corner-left').show();
	$('#wpSelectHub').parents('.box').find('.corner-left').hide()
} );
$("#wpSelectSitePremium").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("site-premium");
	$("#wpWeight").val("4").attr("disabled", true).parent().show();
	$('.box .corner-right, .box .corner-left').show();
} );
$("#wpSelectHub").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("hub");
	$("#wpWeight").val("1").removeAttr("disabled").parent().show();
	$('.box .corner-right, .box .corner-left').show();
	$('#wpSelectSitePremium').parents('.box').find('.corner-left').hide()
} );
$("#adssLoginAction > a").click( function(e) {
	e.preventDefault();
	$("#adssLoginAction").hide();
	$("#wpPassword").parent().show();
} );
$("#wpUrl").keyup( function() {
	$("div.sponsormsg-preview > ul > li > a").attr( "href", "http://"+$("#wpUrl").val() );
} );
$("#wpText").keyup( function() {
	$("div.sponsormsg-preview > ul > li > a").html( $("#wpText").val() );
} );
$("#wpDesc").keyup( function() {
	$("div.sponsormsg-preview > ul > li > p").html( $("#wpDesc").val() );
} );

var tooltipNode;
$(".form-questionmark").mouseover(function() {
	tooltipNode = $('<div id="sponsoredlink-tooltip">'+$(this).attr('data-tooltip')+'</div>')
		.appendTo('.SponsoredLinkForm')
		.css('top', $(this).offset().top-250-$("#sponsoredlink-tooltip").height()+'px')
		.css('left', '81px');
}).mouseout(function(){
	tooltipNode.remove();
});

var animationEnabled = false;
var modalHtml = '<div id="loading-modal"><h2><?= wfMsgHtml('adss-form-modal-title'); ?></h2><div id="indicator"><div id="green-dot"></div></div></div>';
var dotSpeed = 300;
function dotMove(leftPosition) {
	$('div#green-dot').fadeOut(dotSpeed, function() {
		$(this).css('left', leftPosition+'px');
		$('div#green-dot').fadeIn(dotSpeed, function() {
			leftPosition = leftPosition + 24;
			if (leftPosition == 249) leftPosition = 129;
			dotMove(leftPosition);
		});
	});
}
$('.paypal-pay .wikia-button').click(function(event) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: window.wgScriptPath  + "/index.php?title=Special:AdSS&method=process&format=json",
		data: 'wpUrl='+$('.SponsoredLinkForm #wpUrl').val()
			+'&wpText='+$('.SponsoredLinkForm #wpText').val()
			+'&wpDesc='+$('.SponsoredLinkForm #wpDesc').val()
			+'&wpToken='+$('.SponsoredLinkForm #wpToken').val()
			+'&wpType='+$('.SponsoredLinkForm #wpType').val()
			+'&wpEmail='+$('.SponsoredLinkForm #wpEmail').val()
			+'&wpWeight='+$('.SponsoredLinkForm #wpWeight').val(),
		beforeSend: function(){
			$.showModal(
				'',
				modalHtml,
				{
					id: 'paypalModal',
					width: 434,
					showCloseButton: false,
					callback: function() {
						$('#paypay-error').text();
						if (!animationEnabled) {
							animationEnabled = true;
							dotMove(153);
						}
					}
				}
			)
		},
		success: function(data) {
			if (data.status == 'error') {
				for(property in data.form.errors) {
					$('#paypay-error.error-'+property).text(data.form.errors[property]);
				}
				$('#paypalModal').closeModal();
				$('#wpToken').val(data.formToken);
				$.tracker.byStr("adss/form/view/errors");
			}
			else if (data.status == 'ok') {
				window.location = data.paypalUrl;
			}
		}
	});
	event.preventDefault();
});

/*]]>*/
</script>
