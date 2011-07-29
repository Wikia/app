<a name="form"></a>

<section class="SponsoredLinkDesc">
	<div id="paypay-error" class="error error-wpType"></div>
	<div class="chooseheader"><?php echo wfMsgHtml( 'adss-form-pick-plan' ); ?></div>
	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-site-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
			<div class="corner-right"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
		</div>
		<h3><?php echo wfMsgHtml( 'adss-form-site-plan-header' ); ?></h3>
		<div class="price"><?= AdSS_Util::formatPrice( $sitePricing ) ?></div>
		<?php echo wfMsgWikiHtml( 'adss-form-site-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing ) ); ?>
		<a class="wikia-button" id="wpSelectSite" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
	</section>

	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-site-premium-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
			<div class="corner-right"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
		</div>
		<h3><?php echo wfMsgHtml( 'adss-form-site-premium-plan-header' ); ?></h3>
		<div class="price"><?= AdSS_Util::formatPrice( $sitePricing, 3 ) ?></div>
		<?php echo wfMsgWikiHtml( 'adss-form-site-premium-plan-description', $currentShare, AdSS_Util::formatPrice( $sitePricing, 3 ) ); ?>
		<a class="wikia-button" id="wpSelectSitePremium" href="#form"><?php echo wfMsgHtml( 'adss-button-select' ); ?></a>
	</section>

	<section class="box">
		<div class="ribbon"><h2><?= wfMsgHtml( 'adss-form-hub-plan-header-ribbon' ); ?></h2></div>
		<div class="ribbon-corner">
			<div class="corner-left"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
			<div class="corner-right"><img class="chevron" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" /></div>
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
AdSS.displayForm();
/*]]>*/</script>
