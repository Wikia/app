<?php

/**
  * @brief JSSnippets simplify loading and execution of on demand JS files
  * @details Allows to specify list of JS dependencies to be loaded and callback function to be executed
  *
  * @ingroup Extensions
  *
  * @author Maciej Brencz (macbre) <macbre at wikia-inc.com>
  * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
  */

$dir = dirname(__FILE__);

// WikiaApp
$app = F::build('App');

// classes
$app->registerClass('JSSnippets', $dir . '/JSSnippets.class.php');

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'JSSnippets', 'onMakeGlobalVariablesScript');
$app->registerHook('SkinAfterBottomScripts', 'JSSnippets', 'onSkinAfterBottomScripts');

// register instance of JSSnippets
F::setInstance('JSSnippets', new JSSnippets());