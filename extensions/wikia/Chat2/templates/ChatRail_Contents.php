<div class="chat-contents chat-room-<?=
($totalInRoom ? 'active' : 'empty')
?> chat-user-<?=
(!empty($profileAvatarUrl) ? 'logged-in' : 'anonymous')
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
			<button onclick="ChatEntryPoint.onClickChatButton('<?= $linkToSpecialChat ?>')"<?=
			($isLoggedIn ? '' : ' class="loginToChat"')
			?>>
				<?= wfMsg($totalInRoom ? 'chat-join-the-chat' : 'chat-start-a-chat'); ?>
			</button>
		</div>
		<div class="chat-whos-here">
			<span class="arrow-left"><img src="<?= $wg->BlankImgUrl ?>" /></span>
			<span class="arrow-right"><img src="<?= $wg->BlankImgUrl ?>" /></span>
			<div class="carousel-container">
				<div>
					<? if (!empty($totalInRoom) && !empty($chatters)): ?>
						<ul class="carousel">
							<? $rowSize = 6; ?>
							<? foreach($chatters as $i => $chatter): ?>
								<li class="chatter">
									<img src="<?= $wg->BlankImgUrl ?>" data-src="<?= $chatter['avatarUrl'] ?>" class="avatar" width="32" height="32" />

									<div class="UserStatsMenu">
										<div class="info">
											<img src="<?= $wg->BlankImgUrl ?>" data-src="<?= $chatter['avatarUrl'] ?>" class="avatar" width="24" height="24" />
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
							<? endforeach; ?>
						</ul>
					<? elseif (!empty($profileAvatarUrl)): ?>
						<img src="<?= $profileAvatarUrl ?>" class="avatar" width="32" height="32" />
					<? endif; ?>
				</div>
			</div>
		</div>
	<? endif; ?>
</div>