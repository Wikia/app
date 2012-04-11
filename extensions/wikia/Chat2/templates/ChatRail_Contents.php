<div class="chat-contents chat-room-<?=
		($totalInRoom ? 'active' : 'empty')
	?> chat-user-<?=
		(!empty($profileAvatar) ? 'logged-in' : 'anonymous')
	?>">
	<h1 class="chat-headline">
		<span class="chat-live"><?= wfMsg('chat-live2') ?></span>
		<span class="chat-total"><?= $totalInRoom ?></span>
	</h1>

	<p class="chat-name"><?= $wg->Sitename ?></p>

	<? if (!empty($wg->ReadOnly)): ?>
		<em><?= wfMsg('chat-read-only') ?></em>
	<? else: ?>
		<div class="chat-join">
			<button onclick="ChatEntryPoint.onClickChatButton(<?=
					($isLoggedIn ? 'true' : 'false')
				?>, '<?= $linkToSpecialChat ?>')"<?=
					($isLoggedIn ? '' : ' class="loginToChat"')
				?>>
				<img width="17" height="15" src="<?= $buttonIconUrl ?>" />
				<?= $buttonText ?>
			</button>
		</div>
		<div class="chat-whos-here">
			<span class="arrow-left"><img src="<?= $wg->BlankImgUrl ?>" /></span>
			<span class="arrow-right"><img src="<?= $wg->BlankImgUrl ?>" /></span>
			<ul class="slider">
				<? if (!empty($totalInRoom) && !empty($chatters)): ?>
					<li class="slide">
						<ul class="chatters">
							<? foreach($chatters as $i => $chatter): ?>
								<?
									$isLast = ($totalInRoom - $i == 1);
									$isLastInRow = !$isLast && ($i + 1) % 6 == 0;
								?>
								<li class="chatter<?= (($isLast || $isLastInRow) ? ' last' : '') ?>">
									<img src="<?= $chatter['avatarUrl'] ?>" class="avatar" />
									<div class="UserStatsMenu">
										<div class="info">
											<img src="<?= $chatter['avatarUrl'] ?>"/>
											<ul>
												<li class="username"><?= $chatter['username'] ?></li>
												<li class="edits"><?= wfMsgExt('chat-edit-count', array( 'parsemag' ), $chatter['editCount']) ?></li>
												<? if($chatter['showSince']): ?>
													<li class="since"><?= wfMsg('chat-member-since', $chatter['since']) ?></li>
												<? endif; ?>
											</ul>
										</div>
										<div class="actions">
											<ul class="regular-actions">
												<li class="<?= $profileType ?>">
													<a href="<?= $chatter['profileUrl'] ?>">
														<span class="icon">&nbsp;</span>
														<span class="label"><?= wfMsg('chat-user-menu-' . $profileType) ?></span>
													</a>
												</li>
												<li class="contribs">
													<a href="<?= $chatter['contribsUrl'] ?>">
														<span class="icon">&nbsp;</span>
														<span class="label"><?= wfMsg('chat-user-menu-contribs') ?></span>
													</a>
												</li>
											</ul>
										</div>
									</div>				
								</li>
								<? if ($isLastInRow): ?>
							</ul>
						</li>
						<li class="slide">
							<ul class="chatters">
								<? endif; ?>
							<? endforeach; ?>
						</ul>
					</li>
				<? else: ?>
					<li class="slide"><?= $profileAvatar ?></li>
				<? endif; ?>
			</ul>
		</div>
	<? endif; ?>
</div>