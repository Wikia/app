<!-- s:<?= __FILE__ ?> -->
<h2>
    Google Webmaster Tools
</h2>
<div id="wf-webmaster-tools">

	<form id="wf-wt-update" method="POST">
	<?php if ($google['info']['updated']): ?>
		<?php if ($google['info']['verified']): ?>
		<div id="wf-wt-verified">
			This site is in Webmaster tools and has been verified<br />
			<ul>
				<li>Account: <?= $google['info']['account_name'] ?> (<a href="https://www.google.com/webmasters/tools/dashboard?siteUrl=<?= $google['info']['site'] ?>">Site Dashboard</a>)</li>
				<li>Last updated: <?= $google['info']['updated'] ?></li>
				<li>Verification Code: <?= $google['info']['verification_code'] ?></li>
			</ul>
			<input type="submit" name="wt-rem-site" value="Remove Site" />
		</div>
		<?php else: ?>
		<div id="wf-wt-managed">
			This site is in Webmaster tools but has not been verified<br />
			<ul>
				<li>Account: <?= $google['info']['account_name'] ?> (<a href="https://www.google.com/webmasters/tools/dashboard?siteUrl=<?= $google['info']['site'] ?>">Site Dashboard</a>)</li>
				<li>Last updated: <?= $google['info']['updated'] ?></li>
			</ul>
			<input type="submit" name="wt-verify-site" value="Verify Site" />
			<input type="submit" name="wt-rem-site" value="Remove Site" />
		<?php endif; ?>
		</div>
	<?php else: ?>
		<div id="wf-wt-unmanaged">
			This site is unmanaged by Webmaster Tools<br />
			Available accounts: 
			<select name="wt-account-name">
		<?php foreach ($google['accounts'] as $name => $info): ?>
				<option value="<?= $name ?>"<?= $info['preferred'] ? ' selected="selected"' : '' ?>><?= $name ?></option>
		<?php endforeach; ?>
			</select>
			<input type="submit" name="wt-add-site" value="Add Site" />
			<input type="submit" name="wt-add-verify-site" value="Add & Verify Site" />
		</div>		
	<?php endif; ?>
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->
