<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />

<a name="form"></a>
<section class="SponsoredLinkDesc">
	<?php echo $adForm->error( 'wpType' ); ?>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>

	<table>
	<tr>
		<td class="radio">
			<input type="radio" name="wpType" value="page" <?php if($adForm->get('wpType')=='page') echo 'checked'; ?>/>
		</td>
		<td class="header">
			<h3><?php echo wfMsgHtml( 'adss-form-page-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-page-plan-price', AdSS_Util::formatPrice( $pagePricing ) ); ?></div>
		</td>
		<td rowspan="4" class="accent desc">
			<div id="adss-form-page-plan-description" class="desc"><?php echo wfMsgWikiHtml( 'adss-form-page-plan-description', $currentShare, AdSS_Util::formatPrice( $pagePricing ) ); ?></div>
			<div id="adss-form-site-plan-description" class="desc"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
			<div id="adss-form-site-premium-plan-description" class="desc"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
			<div id="adss-form-banner-plan-description" class="desc"><?php echo wfMsgWikiHtml( 'adss-form-banner-plan-description', AdSS_Util::formatPrice( $bannerPricing ) ); ?></div>
		</td>
	</tr>
	<tr>
		<td class="radio">
			<input type="radio" name="wpType" value="site" <?php if($adForm->get('wpType')=='site') echo 'checked'; ?>/>
		</td>
		<td class="header">
			<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-plan-price', AdSS_Util::formatPrice( $sitePricing ) ); ?></div>
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="wpType" value="site-premium" <?php if($adForm->get('wpType')=='site-premium') echo 'checked'; ?>/>
		</td>
		<td>
			<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-price', AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?></div>
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="wpType" value="banner" <?php if($adForm->get('wpType')=='banner') echo 'checked'; ?>/>
		</td>
		<td>
			<h3><?php echo wfMsgHtml( 'adss-form-banner-plan-header' ); ?></h3>
			<div class="price"><?php echo wfMsgWikiHtml( 'adss-form-banner-plan-price', AdSS_Util::formatPrice( $bannerPricing ) ); ?></div>
		</td>
	</tr>
	</table>
</section>

<section class="SponsoredLinkForm">
		<fieldset class="form">
			<legend><?php echo wfMsgHtml( 'adss-form-header' ); ?></legend>

			<div id="wpPageContainer">
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
</section>

</form>

<script type="text/javascript">/*<![CDATA[*/
$(function() {
	if( location.href.indexOf("#") == -1 ) {
		location.href = location.href + "#form";
	}
});

$(".SponsoredLinkDesc input:radio[name='wpType']").click(function() {
	$(".SponsoredLinkDesc tr").removeClass("accent");
	$(".SponsoredLinkDesc tr > td > div.desc").hide();
	$(this).closest("tr").addClass("accent");
	switch ($(this).val()) {
		case 'page':
			$("#adss-form-page-plan-description").show();
			$("#wpPage").parent().show("slow");
			$("#wpBanner").parent().hide("slow");
			$("#wpText").parent().show("slow");
			$("#wpWeight").parent().hide("slow");
			$("fieldset.preview").show();
			break;
		case 'site':
			$("#adss-form-site-plan-description").show();
			$("#wpPage").parent().hide("slow");
			$("#wpBanner").parent().hide("slow");
			$("#wpText").parent().show("slow");
			$("#wpWeight").val("1").removeAttr("disabled").parent().show("slow");
			$("fieldset.preview").show();
			break;
		case 'site-premium':
			$("#adss-form-site-premium-plan-description").show();
			$("#wpPage").parent().hide("slow");
			$("#wpBanner").parent().hide("slow");
			$("#wpText").parent().show("slow");
			$("#wpWeight").val("4").attr("disabled", true).parent().show("slow");
			$("fieldset.preview").show();
			break;
		case 'banner':
			$("#adss-form-banner-plan-description").show();
			$("#wpPage").parent().hide("slow");
			$("#wpBanner").parent().show("slow");
			$("#wpText").parent().hide("slow");
			$("#wpWeight").val("1").removeAttr("disabled").parent().show("slow");
			$("fieldset.preview").hide();
			break;
	}
});

$(".SponsoredLinkDesc input:radio[name='wpType'][checked]").click();


$("#wpPage").one('focus', function() {
	$.loadJQueryAutocomplete(function() {
		$("#wpPage").autocomplete({
			serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
			deferRequestBy: 250,
			maxHeight: 1000,
			width: 375,
			appendTo: '#wpPageContainer'
		});
	});
});

$("#wpUrl").keyup(function() {
	$("div.sponsormsg-preview > ul > li > a").attr( "href", "http://"+$("#wpUrl").val() );
});

$("#wpText").keyup(function() {
	$("div.sponsormsg-preview > ul > li > a").text( $("#wpText").val() );
});

$("#wpDesc").keyup(function() {
	$("div.sponsormsg-preview > ul > li > p").text( $("#wpDesc").val() );
});

$("#adssLoginAction > a").click(function(e) {
	e.preventDefault();
	$("#adssLoginAction").hide();
	$("#wpPassword").parent().show();
});

/*]]>*/
</script>
