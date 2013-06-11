<h2 id='mw-version-license'><?= $versionLicenseMessage ?></h2>
<div>
	<?= $copyRightAndAuthorList ?>
	<?= $versionLicenseInfoMessage ?>
</div>
<h2 id='mw-version-software'><?= $versionSoftwareMessage ?></h2>
<table class="wikitable" id="sv-software">
	<tr>
		<th><?= $versionSoftwareProductMessage ?></th>
		<th><?= $versionSoftwareVersionMessage ?></th>
	</tr>
	<tr>
		<td><?= $wikiaCodeMessage ?></td>
		<td><?= $wikiaCodeVersion ?></td>
	</tr>
	<tr>
		<td><?= $wikiaConfigMessage ?></td>
		<td><?= $wikiaConfigVersion ?></td>
	</tr>
	<? foreach ( $versionSoftwareList as $name => $version ) : ?>
	<tr>
		<td><?= $name ?></td>
		<td dir="ltr"><?= $version ?></td>
	</tr>
	<? endforeach; ?>
</table>
<?= $extensionCredit ?>
<!-- visited from <?= $ip ?> -->
<span style='display:none'>visited from <?= $ip ?></span>
