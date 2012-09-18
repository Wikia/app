<?
/**
 * @var $globals String
 * @var $messages String
 * @var $title String
 */
?>
<html>
<head>
<meta name=viewport content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<style><?= $css ?></style>
</head>
<body>
<?= $globals; ?>
<script>
    wgMessages = <?= json_encode( $messages ); ?>;
</script>
<h2><?= $title ?></h2>
<section id=wkPage>
    <div id=mw-content-text>
		<?= $html; ?>
    </div>
</section>
<div id=wkMdlWrp>
    <div id=wkMdlTB>
        <div id=wkMdlTlBar></div>
        <div id=wkMdlClo class=clsIco></div>
    </div>
    <div id=wkMdlCnt></div>
    <div id=wkMdlFtr></div>
</div>
<script><?= $js ?></script>
</body>
</html>