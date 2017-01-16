<? /** @var $am AssetsManager */ ?>
<!doctype html>
<html lang="<?= Sanitizer::encodeAttribute( $skinVars['lang'] ) ?>" dir="<?= Sanitizer::encodeAttribute( $skinVars['dir'] ) ?>">

<head>
	<title><?= htmlspecialchars( $skinVars['pagetitle'] ); ?></title>
	<meta charset="<?= Sanitizer::encodeAttribute( $skinVars['charset'] ) ?>">

	<? // $headLinks ?>
	<? // $headItems ?>

<? // CSS ?>
	<link rel="stylesheet" href="<?= Sanitizer::encodeAttribute( $am->getSassCommonURL( 'extensions/wikia/OasisLight/styles/oasislight.scss') ) ?>">
	<style>
		body {
			background-color: <?= Sanitizer::normalizeCss( $theme['bodyColor'] ) ?>;
		}
		.WikiaPage {
			background-color: <?= Sanitizer::normalizeCss( $theme['pageColor'] ) ?>;
		}
	</style>

</head>

<body class="skin-oasis">

<? // Early scripts ?>

	<script><?= file_get_contents( __DIR__ . '/../scripts/top.js' ) ?></script>
	<script async src="<?= Sanitizer::encodeAttribute( $am->getGroupCommonURL( 'oasislight_top_js' )[0] ); ?>" onload="Wikia.queue.init()"></script>

	<section id="WikiaPage" class="WikiaPage V2">

<? // Wiki header ?>

	<?= $app->renderView( 'WikiHeader', 'Index' ) ?>

<? // Article content ?>

	<article id="WikiaMainContent" class="WikiaMainContent">
		<?= $app->renderView( 'PageHeader', 'index' ) ?>
		<div id="WikiaArticle" class="WikiaArticle">
			<?= $skinVars['bodytext'] ?>
		</div>
	</article>

<? // Right rail ?>

	<aside>
		<div id="WikiaRailWrapper" class="WikiaRail">
			<div id="WikiaRail">
				<?= F::app()->renderView( 'LatestActivity', 'index' ) ?>
			</div>
		</div>
	</aside>

	</section>

<? // Fandom header and footer ?>

	<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'index' ) ?>
	<?= $app->renderView( 'DesignSystemGlobalFooterService', 'index' ); ?>

<? // Bottom scripts ?>

	<script>
		Wikia.queue.late.push(function () {
			<? if ( $theme['backgroundImage'] ): ?>
				$('body').css('background-image', 'url("' + encodeURI(
						<?= json_encode( rawurldecode( $theme['backgroundImage'] ) ) ?>
					) + '")');
			<? endif; ?>
			$.getScript(<?= json_encode( $am->getGroupCommonURL( 'oasislight_bottom_js' )[0] ); ?>);
			$('body').append( <?= json_encode( $siteCssLink ); ?> );
		});
	</script>

</body>
</html>
