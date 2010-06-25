<?php
/**
 * Moves edit link to the left, beside headline 
 *
 * @author Christian Williams <christian@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'SectionEditLeftAligned',
	'description' => 'Moves the section edit links to the left',
	'version' => '1.0',
	'author' => array('Christian Williams')
);

$wgHooks['SpecialFooterAfterWikia'][] = 'SectionEditLeftAlignedJS';

function SectionEditLeftAlignedJS() {
	global $wgUser, $wgJsMimeType;

	$script = '
function SectionEditLeftAlign() {
	if (skin == "monaco") {
		$(".editsection").each(function(i) {
			//add elements and styling
			var headline = $(this).parent();
			headline.css({"margin-bottom": ".3em", "padding-top": ".7em"});
			$(this).remove().appendTo(headline).css({
				"float": "none",
				"position": "relative",
				"top": "-3px"
			});
		});
	}
}';

	if (is_object($wgUser) && $wgUser->isLoggedIn()) {
		$script .= 'SectionEditLeftAlign();';
	}

	echo "<script type=\"$wgJsMimeType\">/*<![CDATA[*/$script\n/*]]>*/</script>";
	return true;
}
