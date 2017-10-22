<?
/**
 * @var $link String
 * @var $img String
 * @var $title String
 */
?>
<a href=http://wikia.com id=wkLnk></a>
<a href='<?= $link ?>' id=wk404 style="background-image: url('<?= $img ?>')"></a>
<span><?= wfMessage( 'wikiamobile-page-not-found', $title )->text(); ?><br>
<?= wfMessage( 'wikiamobile-page-not-found-tap' )->escaped(); ?></span>
