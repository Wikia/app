<!-- s:<?= __FILE__ ?> -->
<?php
/*
 * some additional code for EasyTemplate class
 *
 * */
?>
<?
/*
 * print some additional CSS - if available
 */
?>
<? if (!empty($formatCssPath) && file_exists( dirname(__FILE__)."/".$formatCssPath )) { ?>
<style type='text/css'>
@import '<?= dirname(__FILE__) ?>/<?= $formatCssPath ?>?<?= $style_version ?>';
</style>
<? } ?>
<?
/*
 * print some additional JS scrips - if available
 */
?>
<? if (!empty($formatJsPath) && file_exists( dirname(__FILE__)."/".$formatJsPath )) { ?>
<script type="text/javascript" src="<?= dirname(__FILE__) ?>/<? $formatJsPath ?>?<?= $style_version ?>"><!-- <? $formatJsPath ?> --></script>
<? } ?>
<?
/*
 * print result
 */
?>
<? if ( is_array($resultData) ) { ?>
<pre><?= print_r($resultData, true) ?></pre>
<? } else { ?>
<pre><? $resultData ?></pre>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
