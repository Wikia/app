<!doctype html>
<html lang="en">
<head>
	<title><?= $roomName ?>: <?= $roomTopic ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/Chat/css/Chat.scss')?>">
	
	<!-- JS -->
	<?= $globalVariablesScript ?>
	<script>
		var roomId = <?= $roomId ?>;
		var wgChatMod = <?= $isChatMod ?>;
		var WIKIA_NODE_HOST = '<?= $nodeHostname ?>'; // used in controllers.js to set up the socket connection.
		var WIKIA_NODE_PORT = '<?= $nodePort ?>';
		var pathToProfilePage = '<?= $pathToProfilePage ?>'; 
		var pathToContribsPage = '<?= $pathToContribsPage ?>'; 
	</script>
</head>
<body class="<?= $bodyClasses ?>">

	<header id="ChatHeader" class="ChatHeader">
		<div class="wordmark">
			<? if ($themeSettings['wordmark-type'] == 'graphic') { ?>
			<img src="<?= $themeSettings['wordmark-image-url'] ?>">
			<? } else { ?>
			<span class="font-<?= $themeSettings['wordmark-font']?>"><?= $themeSettings['wordmark-text'] ?></span>
			<? } ?>
		</div>
		<div class="User"></div>
	</header>

	<section id="WikiaPage" class="WikiaPage">

		<div id="Chat" class="Chat">
			<ul></ul>
		</div>

		<div id="Users" class="Users">
			<ul></ul>
		</div>

		<form id="Write" class="Write" onsubmit="return false">
			<img src="<?= $avatarUrl ?>">
			<input type="text" name="message" autocomplete="off">
			<input type="submit" value="Send" class="wikia-button"/>
		</form>

	</section>

	<div id="UserStatsMenu" class="UserStatsMenu"></div>

	<!-- HTML Templates -->
	<script type='text/template' id='message-template'>
		<img class="avatar" src="<%= avatarSrc %>"/>
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
		<div class="UserStatsMenu">
			<div class="info">
				<img src="<%= avatarSrc %>"/>
				<span class="username"><%= name %></span>
				<span class="edits"><?= $editCountStr ?></span>
				<span class="since"><?= $memberSinceStr ?></span>
			</div>
			<ul class="actions">
				<li class="profile"><a href="#">User Profile</a></li>
				<li class="contribs"><a href="#">Contributions</a></li>
				<li class="kickban"><a href="#">Kickban</a></li>
			</ul>
		</div>
	</script>


	<!-- Load these after the DOM is built -->
	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.5.js"></script>
	<!--<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/Chat.js"></script>-->
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/underscore.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/backbone.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/socket.io/socket.io.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/models/models.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/controllers/controllers.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/views/views.js"></script>
</body>
</html>
