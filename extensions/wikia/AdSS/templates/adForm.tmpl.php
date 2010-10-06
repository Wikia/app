<section class="SponsoredLinkForm">
	<form method="post" action="<?php echo $action; ?>">
		<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
		<input name="wpType" type="hidden" value="site" />

		<fieldset>
			<label for="wpWiki">Which Wiki would you like to advertise on?</label>
			<input type="text" id="wpWiki" name="wpWiki" size="30" />
		</fieldset>


		<fieldset>
			<legend>Pick a plan:</legend>

			<section class="box item-1">
				<h3>Buy a share of the links across a wiki</h3>

				<p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>
				<p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>
				<p>Lorem ipsum lorem ipsum lorem</p>

				<input class="wikia-button" type="submit" name="wpSelect1" value="Select" />
			</section>

			<section class="box item-2">
				<h3>Buy a link on an individual page</h3>

				<p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>
				<p>Lorem ipsum lorem ipsum lorem</p>

				<input class="wikia-button" type="submit" name="wpSelect1" value="Select" />
			</section>
		</fieldset>

		<fieldset class="box item-1">
			<legend>Design your advert</legend>

			<label for="wpUrl"><?php echo wfMsgHtml( 'adss-form-url' ); ?></label>
			<?php $ad->error( 'wpUrl' ); ?>http://<input type="text" name="wpUrl" size="30" value="<?php $ad->output( 'wpUrl' ); ?>" />

			<label for="wpText"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label>
			<?php $ad->error( 'wpText' ); ?><input type="text" name="wpText" size="30" value="<?php $ad->output( 'wpText' ); ?>" />

			<label for="wpDesc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label>
			<?php $ad->error( 'wpDesc' ); ?><textarea name="wpDesc" cols="30"><?php $ad->output( 'wpDesc' ); ?></textarea>

			<label><?php echo wfMsgHtml( 'adss-form-price' ); ?></label>
			<td id="wpPrice"><?php echo $ad->formatPrice( $priceConf ); ?>

			<label for="wpEmail"><?php echo wfMsgHtml( 'adss-form-email' ); ?></label>
			<?php $ad->error( 'wpEmail' ); ?><input type="text" name="wpEmail" value="<?php $ad->output( 'wpEmail' ); ?>" />

			<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
		</fieldset>

		<fieldset class="box item-2">
			<legend>Preview</legend>

			<h2>External Sponsor Links</h2>
		</fieldset>
	</form>
</section>
