<a name="form"></a>
<section class="SponsoredLinkDesc">
	<?php echo $adForm->error( 'wpType' ); ?>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>
		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?>
			<a class="wikia-button" id="wpSelectSite" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>

		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-price', AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?>
			<a class="wikia-button" id="wpSelectSitePremium" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>

		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-hub-plan-header', $hubName ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-hub-plan-price', AdSS_Util::formatPrice( $hubPricing ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-hub-plan-description', $hubName, $wikiCount ); ?>
			<a class="wikia-button" id="wpSelectHub" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>
</section>

<section class="SponsoredLinkForm">
	<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
		<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" id="wpType" type="hidden" value="<?php echo $adForm->output( 'wpType' ); ?>" />

		<fieldset class="form">
			<legend><?php echo wfMsgHtml( 'adss-form-header' ); ?></legend>

			<label for="wpUrl"><?php echo wfMsgHtml( 'adss-form-url' ); ?></label>
			<?php echo $adForm->error( 'wpUrl' ); ?>
			http:// <input type="text" name="wpUrl" id="wpUrl" value="<?php $adForm->output( 'wpUrl' ); ?>" />

			<div>
			<label for="wpText"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label>
			<?php echo $adForm->error( 'wpText' ); ?>
			<input type="text" name="wpText" id="wpText" value="<?php $adForm->output( 'wpText' ); ?>" />

			<label for="wpDesc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label>
			<?php echo $adForm->error( 'wpDesc' ); ?>
			<textarea name="wpDesc" id="wpDesc"><?php $adForm->output( 'wpDesc' ); ?></textarea>
			</div>

			<div>
			<label for="wpWeight"><?php echo wfMsgHtml( 'adss-form-shares' ); ?></label>
			<?php echo $adForm->error( 'wpWeight' ); ?>
			<select name="wpWeight" id="wpWeight">
			  <?php for( $i=1; $i<=4; $i++): ?>
			  <option<?php if( $adForm->get('wpWeight')==$i ) echo " selected"; ?>><?php echo $i;?></option>
			  <?php endfor; ?>
			</select>
			</div>

			<label for="wpEmail"><?php echo wfMsgHtml( 'adss-form-email' ); ?></label>
			<?php echo $adForm->error( 'wpEmail' ); ?>
			<input type="text" name="wpEmail" value="<?php $adForm->output( 'wpEmail' ); ?>" />

			<?php if( !$isAdmin && !$isUser ): ?>
			<p id="adssLoginAction"><?php echo wfMsgHtml( 'adss-form-login-desc', '<a href="#">'.wfMsgHtml( 'adss-form-login-link' ).'</a>' ); ?></p>
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

			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
			<?php endif; ?>
		</fieldset>

		<fieldset class="preview">
			<legend><?php echo wfMsgHtml( 'adss-preview-header' ); ?></legend>
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
} );
$("#wpSelectSitePremium").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("site-premium");
	$("#wpWeight").val("4").attr("disabled", true).parent().show();
} );
$("#wpSelectHub").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("hub");
	$("#wpWeight").val("1").removeAttr("disabled").parent().show();
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
/*]]>*/
</script>
