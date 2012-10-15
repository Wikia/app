<style type="text/css">
section {
	display: body;
}
</style>

<section style="float: left; width: 50%; height: 600px; margin-right: 1em">

<h2 style="margin-top: 0">Activity info</h2>

<dl>
	<dt>Edit Count</dt>
	<dd><?= $editCount ?></dd>

	<dt>Wikis edited</dt>
	<dd><?= $wikisEdited ?></dd>

	<dt>Last Edit</dt>
	<dd><?= $lastEdit ?></dd>

	<dt>First Edit</dt>
	<dd><?= $firstEdit ?></dd>

	<dt>Other accounts</dt>
	<dd><a href="<?= $checkUserUrl ?>" class="wikia-button secondary">Check for other accounts</a></dd>
</dl>

</section>

<section>

<h2>Email</h2>

<dl>
	<dt>Email</dt>
	<dd><a href="mailto:<?= $email ?>"><?= $email ?></a> <a href="<?= $emailChangeUrl ?>" class="wikia-button secondary">change email</a></dd>

	<dt>Email confirmation date</dt>
	<dd><?= $emailConfirmationDate ?></dd>

	<dt>Subscription status</dt>
	<dd>
		<?= ( $emailSubscriptionStatus ) ? Wikia::successmsg( 'subscribed' ) : Wikia::errormsg( 'not subscribed' ); ?>
		<?php if ( !$emailSubscriptionStatus ) { ?><a href="<?= $emailChangeSubscriptionUrl ?>" class="wikia-button secondary">re-subscribe</a><?php } ?>
	</dd>

	<dt>Last email delivery</dt>
	<dd><?= $emailLastDelivery ?>, status: <?= $emailLastDeliveryStatus ?></dd>
</dl>

</section>

<section>

<h2>Rights &amp; groups</h2>

<fieldset>
	<legend>Block user</legend>

	<label for="blockReason">Reason</label>
	<select name="blockReason">
		<option>vandalism</option>
		<option>spam</span>
		<option>other</span>
	</select>
	<button class="secondary">Block locally</button>

	or

	<button class="secondary">disable account</button>
</fieldset>

<fieldset>
	<legend>Manage groups</legend>

	<button class="secondary">Make admin</button>
	<button class="secondary">make bureacrat</button>
</fieldset>

</section>
