<?php
global $wgHooks;
$wgHooks[ 'SkinTemplateTabs' ][] = 'sffFormEditTab';

/**
 * Adds an "action" (i.e., a tab) to edit the current article with a form
 */
function sffFormEditTab($obj, $content_actions) {
  $fname = 'SFFormEditTab';
  // make sure that this is not itself a category page, and that the user
  // is allowed to edit it
  if (isset($obj->mTitle) && ($obj->mTitle->getNamespace() != NS_CATEGORY)) {
    $form_name = sffGetFormForArticle($obj);
    if ($form_name) {  
      global $wgRequest, $wgUser;
      global $sfgRenameEditTabs;

      $user_can_edit = $wgUser->isAllowed('edit') && $obj->mTitle->userCanEdit();
      // create the form edit tab, and apply whatever changes are specified
      // by the edit-tab global variables
      if ($sfgRenameEditTabs) {
        $form_edit_tab_text = $user_can_edit ? wfMsg('edit') : wfMsg('sf_viewform');
        if (array_key_exists('edit', $content_actions)) {
          $content_actions['edit']['text'] = $user_can_edit ? wfMsg('sf_editsource') : wfMsg('viewsource');
        }
      } else {
        $form_edit_tab_text = $user_can_edit ? wfMsg('sf_formedit') : wfMsg('sf_viewform');
      }

      $class_name = ($wgRequest->getVal('action') == 'formedit') ? 'selected' : '';
      $form_edit_tab = array(
        'class' => $class_name,
        'text' => $form_edit_tab_text,
        'href' => $obj->mTitle->getLocalURL('action=formedit')
      );

      // find the location of the 'edit' tab, and add 'edit with form'
      // right before it.
      // this is a "key-safe" splice - it preserves both the keys and
      // the values of the array, by editing them separately and then
      // rebuilding the array.
      // based on the example at http://us2.php.net/manual/en/function.array-splice.php#31234
      $tab_keys = array_keys($content_actions);
      $tab_values = array_values($content_actions);
      $edit_tab_location = array_search('edit', $tab_keys);
      // if there's no 'edit' tab, look for the 'view source' tab instead
      if ($edit_tab_location == NULL)
        $edit_tab_location = array_search('viewsource', $tab_keys);
      // this should rarely happen, but if there was no edit *or* view source
      // tab, set the location index to -1, so the tab shows up near the end
      if ($edit_tab_location == NULL)
        $edit_tab_location = -1;
      array_splice($tab_keys, $edit_tab_location, 0, 'form_edit');
      array_splice($tab_values, $edit_tab_location, 0, array($form_edit_tab));
      $content_actions = array();
      for ($i = 0; $i < count($tab_keys); $i++)
        $content_actions[$tab_keys[$i]] = $tab_values[$i];

      global $wgUser;
      if (! $wgUser->isAllowed('viewedittab')) {
        // the tab can have either of those two actions
        unset($content_actions['edit']);
        unset($content_actions['viewsource']);
      }

      return true;
    }
  }
  return true; // always return true, in order not to stop MW's hook processing!
}

?>
