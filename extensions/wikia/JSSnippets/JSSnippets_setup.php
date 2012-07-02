<?php

/**
  * @brief JSSnippets simplify loading and execution of on demand JS files
  * @details Allows to specify list of JS dependencies to be loaded and callback function to be executed
  *
  * MW1.19 ResourceLoader provides an interface for defining list of modules to be loaded for a given article
  * TODO: use ResourceLoader instead of JSSnippets
  *
  * @ingroup Extensions
  *
  * @author Maciej Brencz (macbre) <macbre at wikia-inc.com>
  * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
  */

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

// classes
$app->registerClass('JSSnippets', $dir . '/JSSnippets.class.php');

// hooks
$app->registerHook('EditPageLayoutModifyPreview', 'JSSnippets', 'onEditPageLayoutModifyPreview');
$app->registerHook('WikiaSkinTopScripts', 'JSSnippets', 'onMakeGlobalVariablesScript');
$app->registerHook('SkinAfterBottomScripts', 'JSSnippets', 'onSkinAfterBottomScripts');

// register instance of JSSnippets
F::setInstance('JSSnippets', new JSSnippets());
