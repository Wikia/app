<?php
if(!defined('MEDIAWIKI')) {
	die();
}

/**
 * Check if graphical edit button should be visible on processed ($wgArticle) page
 * @return bool
 */
function isCorrectArticle() {
    global $wgArticle, $wgOut;

    if ($wgOut->mIsarticle != '1') {
        return false;
    }

    if ($wgArticle == null)  {
            return false;
    }

    $page_id = $wgArticle->getID();
    if ($page_id <= 0) {
        return false;
    }

    return true;
}

/**
 * Extension main function
 * @return bool
 */
function wfEditButton() {
	global $wgEditButtonIcon;
    if(isCorrectArticle() && $wgEditButtonIcon)
    {
    	global $wgTitle;
		echo '<a href="'. $wgTitle->getEditUrl() .'"><img src="'.$wgEditButtonIcon.'"></a>';
    }
    return true;
}

/** Set function to initialize extension */
$wgExtensionFunctions[] = 'EditButton_Setup';

/**
 * Initialize extension, add extension main function as hook AfterTitleDisplayed handler
 */
function EditButton_Setup() {
	global $wgHooks;
	$wgHooks['AfterTitleDisplayed'][] = 'wfEditButton';
}

?>
