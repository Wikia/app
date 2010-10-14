<?php echo $adForm->error( 'wpType' ); ?>
<section class="SponsoredLinkForm">
	<form method="post" action="<?php echo $action; ?>">
		<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" id="wpType" type="hidden" value="<?php echo $adForm->output( 'wpType' ); ?>" />

		<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>

		<fieldset>
			<section class="box item-1">
				<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
				<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
				<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', 25 ); ?>
				<input class="wikia-button" type="button" id="wpSelectSite" name="wpSelect" value="<?php echo wfMsgHtml( 'adss-button-select' ); ?>" />
			</section>

			<section class="box item-2">
				<h3><?php echo wfMsgHtml( 'adss-form-page-plan-header' ); ?></h3>
				<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-page-plan-price', AdSS_Util::formatPrice( $pagePricing ) ); ?></div>
				<?php echo wfMsgWikiHtml( 'adss-form-page-plan-description' ); ?>
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
		$("section.item-1").css({opacity:0.2});
		$("#wpWeight").parent().hide();
	}
	if( $("#wpType").val() == "site" ) {
		$("section.item-2").css({opacity:0.2});
		$("#wpPage").parent().hide();
	}
} );
$("#wpSelectSite").click( function() {
	$("#wpType").val("site");
	$("section.item-1").animate({opacity:1});
	$("section.item-2").animate({opacity:0.2});
	$("#wpPage").parent().hide("slow");
	$("#wpWeight").parent().show("slow");
} );
$("#wpSelectPage").click( function() {
	$("#wpType").val("page");
	$("section.item-1").animate({opacity:0.2});
	$("section.item-2").animate({opacity:1});
	$("#wpPage").parent().show("slow");
	$("#wpWeight").parent().hide("slow");
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
