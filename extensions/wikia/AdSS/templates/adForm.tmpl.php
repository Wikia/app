<section class="SponsoredLinkDesc">
	<?php echo $adForm->error( 'wpType' ); ?>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>
		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?>
			<input class="wikia-button" type="button" id="wpSelectSite" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
		</section>

		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-price', AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?>
			<input class="wikia-button" type="button" id="wpSelectSitePremium" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
		</section>

		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-page-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-page-plan-price', AdSS_Util::formatPrice( $pagePricing ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-page-plan-description', AdSS_Util::formatPrice( $pagePricing ) ); ?>
			<input class="wikia-button" type="button" id="wpSelectPage" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
		</section>
</section>

<section class="SponsoredLinkForm">
	<form method="post" action="<?php echo $action; ?>">
		<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" id="wpType" type="hidden" value="<?php echo $adForm->output( 'wpType' ); ?>" />

		<fieldset class="form">
			<legend><?php echo wfMsgHtml( 'adss-form-header' ); ?></legend>

			<div>
			<label for="wpPage"><?php echo wfMsgHtml( 'adss-form-page' ); ?></label>
			<?php echo $adForm->error( 'wpPage' ); ?>
			<input type="text" name="wpPage" id="wpPage" value="<?php $adForm->output( 'wpPage' ); ?>" />
			</div>

			<label for="wpUrl"><?php echo wfMsgHtml( 'adss-form-url' ); ?></label>
			<?php echo $adForm->error( 'wpUrl' ); ?>
			http:// <input type="text" name="wpUrl" id="wpUrl" value="<?php $adForm->output( 'wpUrl' ); ?>" />

			<label for="wpText"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label>
			<?php echo $adForm->error( 'wpText' ); ?>
			<input type="text" name="wpText" id="wpText" value="<?php $adForm->output( 'wpText' ); ?>" />

			<label for="wpDesc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label>
			<?php echo $adForm->error( 'wpDesc' ); ?>
			<textarea name="wpDesc" id="wpDesc"><?php $adForm->output( 'wpDesc' ); ?></textarea>

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

			<p id="adssLoginAction"><?php echo wfMsgHtml( 'adss-form-login-desc', '<a href="#">'.wfMsgHtml( 'adss-form-login-link' ).'</a>' ); ?></p>
			<div style="display:none">
			<label for="wpPassword"><?php echo wfMsgHtml( 'adss-form-password' ); ?></label>
			<input type="password" name="wpPassword" id="wpPassword" value="<?php $adForm->output( 'wpPassword' ); ?>" />
			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $login; ?>" />
			<p><?php echo wfMsgHtml( 'adss-form-or' ); ?></p>
			</div>

			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
		</fieldset>

		<fieldset class="preview">
			<legend><?php echo wfMsgHtml( 'adss-preview-header' ); ?></legend>
			<?php echo wfMsgWikiHtml( 'adss-ad-header' ); ?>
			<div class="sponsormsg">
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
		$("#wpPage").parent().hide();
		$("#wpWeight").val("4").attr("disabled", true);
	}
	else if( $("#wpType").val() == "page" ) {
		$("#wpSelectPage").parent().addClass("selected");
		$("#wpWeight").parent().hide();
	}
	else if( $("#wpType").val() == "site" ) {
		$("#wpSelectSite").parent().addClass("selected");
		$("#wpPage").parent().hide();
	}
} );
$("#wpSelectSite").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("site");
	$("#wpPage").parent().hide("slow");
	$("#wpWeight").val("1").removeAttr("disabled").parent().show("slow");
} );
$("#wpSelectSitePremium").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("site-premium");
	$("#wpPage").parent().hide("slow");
	$("#wpWeight").val("4").attr("disabled", true).parent().show("slow");
} );
$("#wpSelectPage").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("page");
	$("#wpPage").parent().show("slow");
	$("#wpWeight").parent().hide("slow");
} );
$("#adssLoginAction > a").click( function(e) {
	e.preventDefault();
	$("#adssLoginAction").hide("fast");
	$("#wpPassword").parent().show("fast");
} );
$("#wpUrl").keyup( function() {
	$("div.sponsormsg > ul > li > a").attr( "href", "http://"+$("#wpUrl").val() );
} );
$("#wpText").keyup( function() {
	$("div.sponsormsg > ul > li > a").html( $("#wpText").val() );
} );
$("#wpDesc").keyup( function() {
	$("div.sponsormsg > ul > li > p").html( $("#wpDesc").val() );
} );
</script>
