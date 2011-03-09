<!doctype html>
<html lang="en">
<head>
	<title><?= $chatName ?>: <?= $chatTopic ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?= wfGetSassUrl('/extensions/wikia/Chat/css/Chat.scss') ?>">
	
	<!-- JS -->
	<?= $globalVariablesScript ?>
	<script>
		var chatId = <?= $chatId ?>;
		var wgChatMod = <?= $isChatMod ?>;
	</script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.5.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/Chat.js"></script>		
	
</head>
<body>
	<section id="WikiaPage" class="WikiaPage">

		<div id="Chat" class="Chat">
			<ul>
				<li class="template" data-type="user">
					<span class="user"></span>
					<span class="message"></span>
				</li>
				<li class="template" data-type="inline-alert"></li>
				<?php
					if(!empty($messages)){
						foreach($messages as $message){
							$userName = key($message);
							?><li>
									<span class="user"><?= $userName ?></span>
									<span class="message"><?= $message[$userName] ?></span>
								</li><?php
						}
					}
				?>
			</ul>
		</div>
		
		<div id="Users" class="Users">
			<ul>
				<li data-user="" class="template">
					<a href="#" class="kickban">k/b</a>
				</li>
				<?php
					if(!empty($userList)){
						foreach($userList as $userData){
							$chatModClass = ($userData["chatmod"]) ? "chat-mod" : "";
				?>
							<li data-user="<?= $userData["user"] ?>" class="<?= $chatModClass ?>">
								<?= $userData["user"] ?>
								<a href="#" class="kickban">k/b</a>
							</li>
				<?php
						}
					}
				?>
			</ul>
		</div>
		
		<form id="Write" class="Write">
			<input type="text">
			<input type="submit" value="Submit" class="wikia-button">
		</form>
	
	</section>
</body>
</html>