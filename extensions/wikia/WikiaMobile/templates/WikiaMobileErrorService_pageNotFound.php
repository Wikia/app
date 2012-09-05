<?
/**
 * @var $link String
 * @var $img String
 * @var $wf WikiaFunctionWrapper
 * @var $title String
 */
?>
<a href='<?= $link ?>' id=wk404 style="background-image: url('<?= $img ?>')"></a>
<span><?= $wf->Msg('wikiamobile-page-not-found', $title) ?></span>