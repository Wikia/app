<style type="text/css">
.WikiaPageHeader h2 {
	display: none;
}

.SponsoredLinkDesc .chooseheader {
	font-size: 150%;
	font-weight: bold;
	padding: 0px 0px 10px;
}

.SponsoredLinkDesc table {
	border-spacing: 0;
}
	
.SponsoredLinkDesc .desc div {
	padding: 0px 1em 1em;
}

.SponsoredLinkDesc td.radio {
	width: 30px;
}

.SponsoredLinkDesc td.header {
	vertical-align: top;
	width: 460px;
}

.SponsoredLinkDesc td.desc {
	vertical-align: top;
	width: 460px;
}

.SponsoredLinkForm fieldset {
	float: left;
	width: 460px;
}

.SponsoredLinkForm fieldset.preview {
	float: right;
}

.SponsoredLinkForm legend {
	font-size: 150%;
	font-weight: bold;
}

.SponsoredLinkForm label {
	display: block;
}

.SponsoredLinkForm input[type="text"], input[type="password"], textarea {
	width: 375px;
}

.SponsoredLinkForm input#wpUrl {
	width: 337px;
}
</style>

<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />

<section class="SponsoredLinkDesc">
	<?php echo $adForm->error( 'wpType' ); ?>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>

	<table>
	<tr>
		<td class="radio">
			<input type="radio" name="wpType" value="site" />
		</td>
		<td class="header">
			<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
		</td>
		<td rowspan="3" class="accent desc">
			<div id="adss-form-site-plan-description" class="desc" style="display:none"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
			<div id="adss-form-site-premium-plan-description" class="desc"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
			<div id="adss-form-banner-plan-description" class="desc" style="display:none"><?php echo wfMsgWikiHtml( 'adss-form-banner-plan-description', AdSS_Util::formatPrice( $bannerPricing ) ); ?></div>
		</td>
	</tr>
	<tr class="accent">
		<td>
			<input type="radio" name="wpType" value="site-premium" checked />
		</td>
		<td>
			<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-price', AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="wpType" value="banner" />
		</td>
		<td>
			<h3><?php echo wfMsgHtml( 'adss-form-banner-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-banner-plan-price', AdSS_Util::formatPrice( $bannerPricing ) ); ?></div>
		</td>
	</tr>
	</table>
</section>
<a name="form"></a>
<section class="SponsoredLinkForm">
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
			<label for="wpBanner"><?php echo wfMsgHtml( 'adss-form-banner' ); ?></label>
			<?php echo $adForm->error( 'wpBanner' ); ?>
			<input type="file" name="wpBanner" id="wpBanner" value="<?php $adForm->output( 'wpBanner' ); ?>" />
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
</section>

</form>

<script type="text/javascript">/*<![CDATA[*/
$(".SponsoredLinkDesc input[type='radio']").click( function() {
	$(".SponsoredLinkDesc tr").removeClass("accent");
	$(".SponsoredLinkDesc tr > td > div.desc").hide();
	$(this).closest("tr").addClass("accent");
	switch ($(this).val()) {
		case 'site':
			$("#adss-form-site-plan-description").show();
			$("#wpBanner").parent().hide();
			$("#wpText").parent().show();
			$("#wpWeight").val("1").removeAttr("disabled").parent().show();
			$("fieldset.preview").show();
			break;
		case 'site-premium':
			$("#adss-form-site-premium-plan-description").show();
			$("#wpBanner").parent().hide();
			$("#wpText").parent().show();
			$("#wpWeight").val("4").attr("disabled", true).parent().show();
			$("fieldset.preview").show();
			break;
		case 'banner':
			$("#adss-form-banner-plan-description").show();
			$("#wpBanner").parent().show();
			$("#wpText").parent().hide();
			$("#wpWeight").parent().hide();
			$("fieldset.preview").hide();
			break;
	}
} );
$("#adssLoginAction > a").click( function(e) {
	e.preventDefault();
	$("#adssLoginAction").hide();
	$("#wpPassword").parent().show();
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
