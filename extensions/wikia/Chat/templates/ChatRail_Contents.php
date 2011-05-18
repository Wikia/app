<h1><?= $chatHeadline ?></h1>
<div class="chat-live"><?= wfMsg('chat-live') ?></div>

<? if ( !empty($totalInRoom) ) { ?>
<div class="chat-whos-here">
	<h2><?= wfMsg('chat-whos-here', $totalInRoom) ?></h2>
	<?php if(!empty($avatarsInRoom)){ ?>
	<ul>
		<? foreach($avatarsInRoom as $avatarInRoom) { 
			echo "<li><img src='$avatarInRoom' class='avatar'/></li>";
		} ?>
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
			showComboAjaxForPlaceHolder(false, "", function(){
				AjaxLogin.doSuccess = function() {
					<?= $chatClickAction ?>
				}
			}, false, message); // show the 'login required for this action' message.
		}
	} // end onChatButtonClick()
</script>
