<section class="ChatModule <?=( $isEntryPoint ) ? 'ChatEntryPoint':'module'?> ChatModuleUninitialized">
	<div class="chat-contents">
		<h2 class="chat-headline">
			<span class="chat-live" data-msg-id="chat-live2"> </span>
			<span class="chat-total"> </span>
		</h2>
		<p class="chat-name"> </p>
		<div class="chat-join">
			<button type="button" onclick="ChatEntryPoint.onClickChatButton('<?= $linkToSpecialChat ?>')"> </button>
		</div>
		<div class="chat-whos-here">
			<span class="arrow-left"><img src="<?= $blankImgUrl ?>" /></span>
			<span class="arrow-right"><img src="<?= $blankImgUrl ?>" /></span>
			<div class="carousel-container">
				<div>
					<ul class="carousel">
						<li class="chatter">
							<img src="<?= $blankImgUrl ?>" data-user-attr="data-src" data-user-prop="avatarUrl" class="avatar" width="32" height="32" />
							<div class="UserStatsMenu">
								<div class="info">
									<img src="<?= $blankImgUrl ?>" data-user-attr="data-src" data-user-prop="avatarUrl" class="avatar" width="24" height="24" />
									<ul>
										<li class="username" data-user-prop="username"> </li>
										<li class="edits" data-msg-id="chat-edit-count" data-user-attr="data-msg-param" data-user-prop="editCount"> </li>
										<li class="since" data-msg-id="chat-member-since" data-user-attr="data-msg-param" data-user-prop="since"> </li>
									</ul>
								</div>
								<div class="actions">
									<ul class="regular-actions">
										<li class="profilepage <?= $profileType ?>">
											<a data-user-attr="href" data-user-prop="profileUrl">
												<span class="icon">&nbsp;</span>
												<span class="label" data-msg-id="<?= 'chat-user-menu-' . $profileType ?>"></span>
											</a>
										</li>
										<li class="contribs">
											<a data-user-attr="href" data-user-prop="contribsUrl">
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
	<? if ( wfMessage( 'chat-entry-point-guidelines' )->exists() ): ?>
		<span class="more"><?= wfMessage( 'chat-entry-point-guidelines' )->parse() ?></span>
	<? endif ?>
</section>
<?php if ( $isEntryPoint ): ?>
	<script language="javascript" type="text/javascript">if ( typeof ChatEntryPoint!=="undefined" ) ChatEntryPoint.init();</script>
	<a class="ChatMonobookEntryPoint" href="<?= $linkToSpecialChat ?>"><?= wfMsg( 'chat-join-the-chat' )?></a>
<?php endif; ?>
