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
* MediaWiki's source editor (`source`)

## How does it work?

JavaScript code is injected into the editor via `EditPage::showEditForm:initial` for CKeditor / source editor.
Every five seconds we store the content of the editor (along with some metadata) in local storage. In case
of a crash we restore it on your next visit to the editor.

On successful edits local storage entry is removed.

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
