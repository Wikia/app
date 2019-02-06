EditDraftSaving
===============

This extension provides edit draft saving functionality. It acts as a "backup" of edited content in case your browser
crashes, network connection disappears or any other quantum event takes place.

## How to enable it?

**This extension is disabled by default** at the moment.
Please set [`wgEnableEditDraftSavingExt`](https://community.wikia.com/wiki/Special:WikiFactoryReporter?varid=1909) to true via WikiFactory.

## Supported editors

All three editors are supported:

* CKEditor (`editor-ck`)
* VisualEditor (`editor-ve`)
* MediaWiki's source editor (`editor-mw`)

JavaScript code for this feature is split into:

* `index.js` provides a generic AMD module used by draft saving in all three editors
* `rte.js` and `mediawiki.js` uses the above and is loaded for CKeditor and MediaWiki's source editor accordingly
* `ve.lazy.js` is a small piece of code that is used to load `ve.js` when VisualEditor is requested.

## How does it work?

JavaScript code is injected into the editor via `EditPage::showEditForm:initial` for CKeditor / source editor.
Every five seconds we store the content of the editor (along with some metadata) in local storage. In case
of a crash we restore it on your next visit to the editor.

For VisualEditor we use the following JavaScript hooks:

* `ve.activate` is fired when VisualEditor starts to load - we then load edit draft code on demand
* `ve.activationComplete` is fired when VisualEditor is fully loaded - edit draft code is set up then
* `ve.toolbarSaveButton.stateChanged` is fired when editing content changed - edit draft can be saved then
* `postEdit` is fired when VisualEditor save completes - edit draft can be invalidated then

> `window.mediaWiki.hook('hookName').add()` is used to bind to a specific hook

### Draft invalidation

On successful edits local storage entry is removed. To do that we need to pass local storage entry key name
to the page that shows after a successful edit:

* local storage entry name is passed as a hidden form field named `wpEditDraftKey`
* in `ArticleSaveComplete` hook we read this value from POST HTTP request and store it in PHP session
* `MakeGlobalVariablesScript` hook then reads the PHP session value and emits a small inline JS that invalidates local storage entry

## Events tracking

We send the following tracking events to both Google Analytics and our internal data warehouse.

#### The draft has been loaded

User's browser has crashed and we managed to restore the changes:

```
Wikia.Tracker:  trackingevent editor-ck/impression/draft-loaded/ [analytics track]
```

#### An edit has been published after draft restore

Draft has been restored and a user published an edit:

```
Wikia.Tracker:  trackingevent editor-ck/impression/draft-publish/ [analytics track]
```

> `editor-ck` part is replaced wth an appropriate editor identifier (see the first section of this README file).
