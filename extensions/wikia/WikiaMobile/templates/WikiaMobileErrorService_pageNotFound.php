<?
/**
 * @var $link String
 * @var $img String
 * @var $wf WikiaFunctionWrapper
 * @var $title String
 */
?>
<a href=http://wikia.com id=wkLnk></a>
<a href='<?= $link ?>' id=wk404 style="background-image: url('<?= $img ?>')"></a>
<span><?= wfMsg('wikiamobile-page-not-found', $title) ?><br>
<?= wfMsg('wikiamobile-page-not-found-tap') ?></span>