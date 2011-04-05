<style type="text/css">
.SponsoredLinkDesc { text-align: center; height: 320px; }
.SponsoredLinkDesc section.box { height: 170px; }
.SponsoredLinkDesc section.box.selected { height: 200px; }
.price { font-weight: bold; }
</style>
<a name="form"></a>
<section class="SponsoredLinkDesc" style="text-align: center">
	<?php echo $adForm->error( 'wpType' ); ?>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>
		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-reviews-page-day-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-reviews-page-day-plan-price', AdSS_Util::formatPrice( $pagePricing['page-day'] ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-reviews-page-day-plan-description', AdSS_Util::formatPrice( $pagePricing['page-day'] ) ); ?>
			<a class="wikia-button" id="wpSelectPageDay" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>
		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-reviews-page-month-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-reviews-page-month-plan-price', AdSS_Util::formatPrice( $pagePricing['page-month'] ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-reviews-page-month-plan-description', AdSS_Util::formatPrice( $pagePricing['page-month'] ) ); ?>
			<a class="wikia-button" id="wpSelectPageMonth" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>
		<section class="box">
			<h3><?php echo wfMsgHtml( 'adss-form-reviews-page-year-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-reviews-page-year-plan-price', AdSS_Util::formatPrice( $pagePricing['page-year'] ) ); ?></div>
			<?php echo wfMsgWikiHtml( 'adss-form-reviews-page-year-plan-description', AdSS_Util::formatPrice( $pagePricing['page-year'] ) ); ?>
			<a class="wikia-button" id="wpSelectPageYear" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
		</section>
</section>

<section class="SponsoredLinkForm">
	<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
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

			<div>
			<label for="wpText"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label>
			<?php echo $adForm->error( 'wpText' ); ?>
			<input type="text" name="wpText" id="wpText" value="<?php $adForm->output( 'wpText' ); ?>" />

			<label for="wpDesc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label>
			<?php echo $adForm->error( 'wpDesc' ); ?>
			<textarea name="wpDesc" id="wpDesc"><?php $adForm->output( 'wpDesc' ); ?></textarea>
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
	if( $("#wpType").val() == "page-day" ) {
		$("#wpSelectPageDay").parent().addClass("selected");
	}
	else if( $("#wpType").val() == "page-month" ) {
		$("#wpSelectPageMonth").parent().addClass("selected");
	}
	else if( $("#wpType").val() == "page-year" ) {
		$("#wpSelectPageYear").parent().addClass("selected");
	}
	if( location.href.indexOf("#") == -1 ) {
		location.href = location.href + "#form";
	}
} );
$("#wpSelectPageDay").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("page-day");
} );
$("#wpSelectPageMonth").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("page-month");
} );
$("#wpSelectPageYear").click( function() {
	$(".SponsoredLinkDesc section").removeClass("selected");
	$(this).parent().addClass("selected");
	$("#wpType").val("page-year");
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
