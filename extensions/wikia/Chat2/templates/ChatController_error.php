<!doctype html>
<html>
<head>
	<title><?= $pageTitle ?></title>
	<link rel="shortcut icon" href="<?= $wg->Favicon ?>">

	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL( '/extensions/wikia/Chat2/css/Chat.scss' )?>">
</head>
<body>
	<section id="WikiaPage" class="WikiaPage">
		<h1><?= htmlspecialchars( $errorMsg) ?></h1>
	</section>
</body>