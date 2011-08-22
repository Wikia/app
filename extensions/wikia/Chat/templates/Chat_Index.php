<!doctype html>
<html lang="en">
<head>
	<title><?= $roomName ?>: <?= $roomTopic ?></title>
	<link rel="shortcut icon" href="<?= $wgFavicon ?>">

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/Chat/css/Chat.scss')?>">

	<!-- JS -->
	<?= $globalVariablesScript ?>
	<?php //TODO: use js var?>

</head>
<body class="<?= $bodyClasses ?>">

	<header id="ChatHeader" class="ChatHeader">
		<h1 class="public wordmark">
			<a href="<?= $mainPageURL ?>">
			<? if ($themeSettings['wordmark-type'] == 'graphic') { ?>
			<img src="<?= $themeSettings['wordmark-image-url'] ?>">
			<? } else { ?>
			<span class="font-<?= $themeSettings['wordmark-font']?>"><?= $themeSettings['wordmark-text'] ?></span>
			<? } ?>
			</a>
		</h1>
		<h1 class="private"></h1>
		<div class="User"></div>
	</header>

	<section id="WikiaPage" class="WikiaPage">

		<div id="Rail" class="Rail">
			<h1 class="public wordmark selected">
				<img src="<?= $wgBlankImgUrl ?>" class="chevron">
				<? if ($themeSettings['wordmark-type'] == 'graphic') { ?>
				<img src="<?= $themeSettings['wordmark-image-url'] ?>" class="wordmark">
				<? } else { ?>
				<span class="font-<?= $themeSettings['wordmark-font']?>"><?= $themeSettings['wordmark-text'] ?></span>
				<? } ?>
				<span id="MsgCount_<?php echo $roomId ?>" class="splotch">0</span>
			</h1>
			<ul id="WikiChatList" class="WikiChatList"></ul>
			<h1 class="private">Private Messages</h1>
			<ul id="PrivateChatList" class="PrivateChatList"></ul>
		</div>

		<form id="Write" class="Write" onsubmit="return false">
			<img src="<?= $avatarUrl ?>">
			<textarea name="message"></textarea>
			<input type="submit">
		</form>

	</section>

	<div id="UserStatsMenu" class="UserStatsMenu"></div>

	<!-- HTML Templates -->
	<script type='text/template' id='message-template'>
		<img class="avatar" src="<%= avatarSrc %>"/>
		<span class="time"><%= timeStamp %></span>
		<span class="username"><%= name %></span>
		<span class="message"><%= text %></span>
	</script>
	<script type='text/template' id='inline-alert-template'>
		<%= text %>
	</script>
	<script type='text/template' id='user-template'>
		<img src="<%= avatarSrc %>"/>
		<span class="username"><%= name %></span>
		<div class="details">
			<span class="status">Away</span>
		</div>
		<% if(isPrivate) { %>
			<span id="MsgCount_<%= roomId %>" class="splotch">0</span>
		<% } %>
		<div class="UserStatsMenu">
			<div class="info">
				<img src="<%= avatarSrc %>"/>
				<span class="username"><%= name %></span>
				<span class="edits"><?= $editCountStr ?></span>
				<span class="since"><?= $memberSinceStr ?></span>
			</div>
			<ul class="actions">

			</ul>
		</div>
	</script>
	<script type='text/template' id='user-action-template'><li class="<%= actionName %>"><a href="#"><%= actionDesc %></a></li></script>
	<?php //TODO: use AM ?>
	<!-- Load these after the DOM is built -->
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/socket.io.client.js?<?= $wgStyleVersion ?>"></script>

	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/jquery-1.5.1.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.wikia.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.json-2.2.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/JSMessages/js/JSMessages.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/underscore.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/backbone.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/models/models.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/controllers/controllers.js?<?= $wgStyleVersion ?>"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/views/views.js?<?= $wgStyleVersion ?>"></script>
</body>
</html>
