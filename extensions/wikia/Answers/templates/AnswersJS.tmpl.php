<?php
global $wgTitle, $wgArticle, $wgOut;

//if ($wgTitle->isContentPage()) {

if ( $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle() ) {

?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(".firstHeading").append('<span class="inline_move_link"><a href="Special%3AMovePage/<?=$wgTitle->getPartialURL()?>">Rephrase this question</a></span>');
if (jQuery("#mw-normal-catlinks").length > 0) {
	jQuery(".firstHeading").append('<div class="firstHeadingCats">' + jQuery("#mw-normal-catlinks").html() + '</div>');
}
</script>
<?
}
