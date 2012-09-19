<?= $globals; ?>
<script>
wgMessages = <?= json_encode( $messages ); ?>;
</script>
<h2><?= $title; ?></h2>
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