<h1><?= $wf->MsgExt( 'skeleskin-page-header', array( 'parseinline' ), $headerText ); ?></h1>
<?= $afterBodyContent ?>
<section id="WikiaPage">
	<article id="WikiaMainContent"><?= $bodyContent ?></article>
	<footer id="WikiaMainContentFooter"><?= $afterContentHookText ;?></footer>
</section>