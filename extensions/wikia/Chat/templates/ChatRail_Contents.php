<div class="chat-live"><?= wfMsg('chat-live') ?></div>
<h1><?= $chatHeadline ?></h1>
<?php

if(!empty($wgReadOnly)){
	// For a variety of reasons, we don't display the entry point when in read-only mode.  See BugzId 11047 for more info.
	print "<em>".wfMsg('chat-read-only')."</em>";
} else { ?>
	<? //print_r($chatters) ?>

	<? if ( !empty($totalInRoom) ) { ?>
	<div class="chat-whos-here">
		<h2><?= wfMsg('chat-whos-here', $totalInRoom) ?></h2>
		<?php if(!empty($chatters)){ ?>
		<ul>
			<? foreach($chatters as $chatter) { ?>
				<li>
					<img src='<?= $chatter['avatarUrl'] ?>' class='avatar'/>
					<div class="UserStatsMenu">
						<div class="info">
							<img src="<?= $chatter['avatarUrl'] ?>">
							<span class="username"><?= $chatter['username'] ?></span>
							<span class="edits"><?= wfMsgExt('chat-edit-count', array( 'parsemag' ), $chatter['editCount']) ?></span>
							<?php if($chatter['showSince']): ?>
								<span class="since"><?= wfMsg('chat-member-since', $chatter['since']) ?></span>
							<?php endif; ?>
						</div>
						<ul class="actions">
							<li class="profile"><a href="<?= $chatter['profileUrl'] ?>">User Profile</a></li>
							<li class="contribs"><a href="<?= $chatter['contribsUrl'] ?>">Contributions</a></li>
						</ul>
					</div>				
				</li>
			<? } ?>
		</ul>
		<?php } ?>
	</div>
	<? } ?>

	<div class="chat-join">
		<?= $profileAvatar ?>
		<button onclick="onChatButtonClick()"<?= ($isLoggedIn?"":" class='loginToChat'"); ?>>
			<img src="<?= $buttonIconUrl ?>">
			<?= $buttonText ?>
		</button>
	</div>

	<script>
		function onChatButtonClick(){
			var isLoggedIn = <?= ($isLoggedIn ? "true" : "false") ?>;
			var message = 'protected'; // gives the 'login required to perform this action' message at the top of the login box
			if(isLoggedIn){
				<?= $chatClickAction ?>
			} else {
				showComboAjaxForPlaceHolder(false, "", function() {
					AjaxLogin.doSuccess = function() {
						$('.modalWrapper').children().not('.close').not('.modalContent').not('h1').remove();
						$('.modalContent').load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=AnonLoginSuccess&outputType=html');
					}
				}, false, message); // show the 'login required for this action' message.
			}
		} // end onChatButtonClick()
	</script>
<?php
}
?>
