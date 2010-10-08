<?php echo $adForm->error( 'wpType' ); ?>
<section class="SponsoredLinkForm">
	<form method="post" action="<?php echo $action; ?>">
		<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" id="wpType" type="hidden" value="<?php echo $adForm->output( 'wpType' ); ?>" />

		<fieldset>
			<legend><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></legend>

			<section class="box item-1">
				<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
				<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description' ); ?>
				<?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?>
				<input class="wikia-button" type="button" id="wpSelectSite" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
			</section>

			<section class="box item-2">
				<h3><?php echo wfMsgHtml( 'adss-form-page-plan-header' ); ?></h3>
				<?php echo wfMsgWikiHtml( 'adss-form-page-plan-description' ); ?>
				<?php echo wfMsgWikiHtml( 'adss-form-page-plan-price', AdSS_Util::formatPrice( $pagePricing ) ); ?>
				<input class="wikia-button" type="button" id="wpSelectPage" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
			</section>
		</fieldset>

		<fieldset class="box item-1">
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

			<label for="wpEmail"><?php echo wfMsgHtml( 'adss-form-email' ); ?></label>
			<?php echo $adForm->error( 'wpEmail' ); ?>
			<input type="text" name="wpEmail" value="<?php $adForm->output( 'wpEmail' ); ?>" />

			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
		</fieldset>

		<fieldset class="box item-2">
			<legend><?php echo wfMsgHtml( 'adss-preview-header' ); ?></legend>
			<?php echo wfMsgWikiHtml( 'adss-ad-header' ); ?>
			<div class="sponsormsg">
			<ul>
			  <?php echo $ad->render(); ?>
			</ul>
			</div>
		</fieldset>
	</form>
</section>

<script type="text/javascript">/*<![CDATA[*/
$(function() {
	if( $("#wpType").val() == "page" ) {
		$("section.item-1").css({opacity:0.2, height:"110px"});
	}
	if( $("#wpType").val() == "site" ) {
		$("section.item-2").css({opacity:0.2, height:"110px"});
		$("#wpPage").parent().hide();
	}
} );
$("#wpSelectSite").click( function() {
	$("#wpType").val("site");
	$("section.item-1").animate({opacity:1, height:"160px"});
	$("section.item-2").animate({opacity:0.2, height:"110px"});
	$("#wpPage").parent().hide("slow");
} );
$("#wpSelectPage").click( function() {
	$("#wpType").val("page");
	$("section.item-1").animate({opacity:0.2, height:"110px"});
	$("section.item-2").animate({opacity:1, height:"160px"});
	$("#wpPage").parent().show("slow");
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
