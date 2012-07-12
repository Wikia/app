<? if(!empty($users)) { ?>
	<div class="user-grouping <?= $userType ?>">
		<h2><?= wfMsg('wikiahome-preview-'.$userType.'-heading') ?></h2>
		<ul class="users">
			<?
				global $wgLang; 
				$maxUsers = min(count($users), $limit);
				$userKeys = array_keys($users);
				for ($i = 0; $i < $maxUsers; $i++):
					$user = $users[$userKeys[$i]];
			?>
				<li class="user">
					<a href="<?= $user['userPageUrl'] ?>">
						<img alt="<?= $user['name'] ?>" src="<?= $user['avatarUrl'] ?>" class="avatar">
					</a>
					<div class="details">
						<div class="info">
							<a href="<?= $user['userPageUrl'] ?>">
								<img alt="<?= $user['name'] ?>" src="<?= $user['avatarUrl'] ?>" class="avatar">
							</a>
							<strong>
								<a href="<?= $user['userPageUrl'] ?>">
									<?= $user['name'] ?>
								</a>
							</strong>
							<?= wfMsgExt('wikiahome-preview-user-edits', 'parseinline', $wgLang->formatNum( $user['edits'] ) ) ?>
							<br /><?= wfMsg('wikiahome-preview-user-member-since', $user['since']) ?>
						</div>
						<ul>
							<li class="user-page">
								<a href="<?= $user['userPageUrl'] ?>"><?= wfMsg('wikiahome-preview-user-profile-link-label') ?></a>
							</li>
							<li class="user-contributions">
								<a href="<?= $user['userContributionsUrl'] ?>"><?= wfMsg('wikiahome-preview-user-contributions-link-label') ?></a>
							</li>
						</ul>
					</div>
				</li>
			<? endfor; ?>
		</ul>
	</div>
<? } ?>
