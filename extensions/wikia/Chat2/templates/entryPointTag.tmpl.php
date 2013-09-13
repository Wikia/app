<section class="ChatModule <?=($isEntryPoint)?'ChatEntryPoint':'module'?> ChatModuleUninitialized">
	<div class="chat-contents">
		<h1 class="chat-headline">
			<span class="chat-live" data-msg-id="chat-live2"> </span>
			<span class="chat-total"> </span>
		</h1>
		<p class="chat-name"> </p>
		<div class="chat-join">
			<button onclick="ChatEntryPoint.onClickChatButton('<?= $linkToSpecialChat ?>')"> </button>
		</div>
		<div class="chat-whos-here">
			<span class="arrow-left"><img src="<?= $blankImgUrl ?>" /></span>
			<span class="arrow-right"><img src="<?= $blankImgUrl ?>" /></span>
			<div class="carousel-container">
				<div>
					<ul class="carousel">
						<li class="chatter">
							<img src="<?= $blankImgUrl ?>" data-src="todo_avatar_url" class="avatar" width="32" height="32" />
							<div class="UserStatsMenu">
								<div class="info">
									<img src="<?= $blankImgUrl ?>" data-src="todo_avatar_url" class="avatar" width="24" height="24" />
									<ul>
										<li class="username"> </li>
										<li class="edits"> </li>
										<li class="since"> </li>
									</ul>
								</div>
								<div class="actions">
									<ul class="regular-actions">
										<li class="profilepage <?= $profileType ?>">
											<a href="">
												<span class="icon">&nbsp;</span>
												<span class="label" data-msg-id="<?= 'chat-user-menu-' . $profileType ?>"></span>
											</a>
										</li>
										<li class="contribs">
											<a href="">
												<span class="icon">&nbsp;</span>
												<span class="label" data-msg-id="chat-user-menu-contribs"> </span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
					<img src="" class="avatar currentUser" width="32" height="32" />
				</div>
			</div>
		</div>
	</div>
</section>
<?php if ($isEntryPoint): ?>
	<script language="javascript" type="text/javascript">if ( typeof ChatEntryPoint!=="undefined" ) ChatEntryPoint.init();</script>
	<a class="ChatMonobookEntryPoint" href="<?= $linkToSpecialChat ?>"><?= wfMsg('chat-join-the-chat')?></a>
<?php endif; ?>
