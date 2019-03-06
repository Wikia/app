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

## How does it work?

JavaScript code is injected into the editor via `EditPage::showEditForm:initial` for CKeditor / source editor.
Every five seconds we store the content of the editor (along with some metadata) in local storage. In case
of a crash we restore it on your next visit to the editor.

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

#### Draft conflicts

We detected that someone edited the the page after your draft has been saved:

```
Wikia.Tracker:  trackingevent editor-ck/impression/draft-conflict/ [analytics track]
```

#### Draft discarded

When a user rejects a draft and restores the original content:

```
Wikia.Tracker:  trackingevent editor-ck/impression/draft-discard/ [analytics track]
```

> `editor-ck` part is replaced wth an appropriate editor identifier (see the first section of this README file).
