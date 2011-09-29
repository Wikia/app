<html<? if ( !empty( $appCacheManifestPath ) ) :?> manifest="<?= $appCacheManifestPath ;?>"<? endif ;?>>
	<head>
		<meta name='viewport' content = 'width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no' />
		<link rel=stylesheet href="<?= $cssLink ;?>">
		<title>Photo Pop - Wikia</title>
		<? foreach($scripts as $item) :?>
			<script src="<?= $item ;?>"></script>
		<? endforeach ;?>
	</head>
	<body>
		<div id="PhotoPopWrapper">
		</div>
	</body>
</html>