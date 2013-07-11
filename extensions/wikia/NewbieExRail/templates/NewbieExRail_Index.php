<section class="UserProfileRail module">
	<h1><?= wfMsg('user-profile-rail-header'); ?></h1>
	<ul>
		<li>
		<span><?= wfMsg('user-profile-name-label'); ?></span>
		<a href="<?= $userPageUrl; ?>"><?= $userName; ?></a>
		</li>
		<li>
		<span><?= wfMsg('user-profile-email-label'); ?></span>
		<?= $userEmail; ?>
		</li>
		<li>
		<span><?= wfMsg('user-profile-edits-label'); ?></span>
		<?= $userEditCount; ?>
		</li>
		<li>
		<a href="<?= $userContributionsLink; ?>" target="_blank"><?= wfMsg('user-profile-contributions'); ?></a>
		</li>
	</ul>
</section>
