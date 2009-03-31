<?php
/**
 * @defgroup Templates Templates
 * @file
 * @ingroup Templates
 */
if( !defined( 'MEDIAWIKI' ) ) die( -1 );

/**
 * HTML template for Special:Collection
 * @ingroup Templates
 */
class CollectionPageTemplate extends QuickTemplate {
	function execute() {		
		$mediapath = $GLOBALS['wgScriptPath'] . '/extensions/Collection/collection/';
?>

<div style="width: 47%; float: left; margin-right: 5%">
<?php $this->msgWiki('coll-intro_text') ?>

<h2><span class="mw-headline"><?php $this->msg('coll-your_book') ?></span></h2>

<form action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'set_titles/')) ?>" method="post" id="mw-collection-title-form">
	<table id="mw-collection-title-table" style="width: 80%" align="center">
		<tbody>
			<tr>
				<td class="mw-label"><label for="titleInput"><?php $this->msg('coll-title') ?></label></td>
				<td class="mw-input"><input id="titleInput" type="text" name="collectionTitle" value="<?php echo htmlspecialchars($this->data['collection']['title']) ?>" /></td>
			</tr>
			<tr>
				<td class="mw-label"><label for="subtitleInput"><?php $this->msg('coll-subtitle') ?></label></td>
				<td class="mw-input"><input id="subtitleInput" type="text" name="collectionSubtitle" value="<?php echo htmlspecialchars($this->data['collection']['subtitle']) ?>" /></td>
			</tr>
		</tbody>
	</table>
	<noscript>
		<input type="submit" value="<?php $this->msg('coll-update') ?>" />
	</noscript>
</form>

<div id="collectionListContainer">
<?php
$listTemplate = new CollectionListTemplate();
$listTemplate->set( 'collection', $this->data['collection'] );
$listTemplate->execute();
?>
</div>
<div style="display:none">
	<span id="newChapterText"><?php $this->msg('coll-new_chapter') ?></span>
	<span id="renameChapterText"><?php $this->msg('coll-rename_chapter') ?></span>
	<span id="clearCollectionConfirmText"><?php $this->msg('coll-clear_collection_confirm') ?></span>
</div>

</div>

<div style="width: 47%; float: left">

	<div style="margin-bottom: 10px; padding: 10px; border: 1px solid #aaa; background-color: #f9f9f9;">
		<h2><span class="mw-headline"><?php $this->msg('coll-book_title') ?></span></h2>
		<?php $this->msgWiki('coll-book_text') ?>
		<div id="ppList">
			<?php foreach ($this->data['podpartners'] as $partner => $partnerData) { ?>
			<form action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'post_zip/')) ?>" method="get">
				<input type="hidden" name="partner" value="<?php echo htmlspecialchars($partner) ?>"/>
				<input type="submit" value="<?php echo wfMsgHtml('coll-order_from_pp', htmlspecialchars($partnerData['name'])) ?>" class="order" <?php if (count($this->data['collection']['items']) == 0) { ?> disabled="disabled"<?php } ?> />
				<a href="<?php echo htmlspecialchars($partnerData['url']) ?>" target="_blank"><?php echo wfMsgHtml('coll-about_pp', htmlspecialchars($partnerData['name'])) ?>&nbsp;<img src="<?php echo htmlspecialchars($partnerData['logourl']) ?>" alt="<?php echo htmlspecialchars($partnerData['name']) ?>"/></a>
			</form>
			<?php } ?>
		</div>
	</div>

	<div style="margin-bottom: 10px; padding: 10px; border: 1px solid #aaa; background-color: #f9f9f9;">
		<h2><span class="mw-headline"><?php $this->msg('coll-download_title') ?></span></h2>
		<?php $this->msgWiki('coll-download_text') ?>
		<form id="downloadForm" action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'render/')) ?>" method="post">
			<?php if (count($this->data['formats']) == 1) {
				$writer = array_rand($this->data['formats']);
				$buttonLabel = wfMsgHtml('coll-download_as', htmlspecialchars($this->data['formats'][$writer]));
			?>
				<input type="hidden" name="writer" value="<?php echo htmlspecialchars($writer) ?>" />
			<?php } else {
				$buttonLabel = wfMsgHtml('coll-download');
			?>
			<label for="formatSelect"><?php $this->msg('coll-format_label') ?></label>
			<select id="formatSelect" name="writer">
				<?php foreach ($this->data['formats'] as $writer => $name) { ?>
				<option value="<?php echo htmlspecialchars($writer) ?>"><?php echo htmlspecialchars($name) ?></option>
				<?php	} ?>
			</select>
			<?php } ?>
			<input id="downloadButton" type="submit" value="<?php echo $buttonLabel ?>"<?php if (count($this->data['collection']['items']) == 0) { ?> disabled="disabled"<?php } ?> />
		</form>
	</div>

	<div style="margin-bottom: 10px; padding: 10px; border: 1px solid #aaa; background-color: #f9f9f9;">
		<h2><span class="mw-headline"><?php $this->msg('coll-save_collection_title') ?></span></h2>
		<?php if ($GLOBALS['wgUser']->isLoggedIn()) { ?>
		<?php $this->msgWiki('coll-save_collection_text') ?>
			<form id="saveForm" action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'save_collection/')) ?>" method="post">
				<input id="personalCollType" type="radio" name="colltype" value="personal" checked="checked" />
				<label for="personalCollType"><?php $this->msg('coll-personal_collection_label') ?></label>
				<label for="personalCollTitle"><?php echo htmlspecialchars($GLOBALS['wgUser']->getUserPage()->getPrefixedText() . '/' . wfMsgForContent('coll-collections') . '/') ?></label>
				<input id="personalCollTitle" type="text" name="pcollname" /><br />
				<input id="communityCollType" type="radio" name="colltype" value="community" />
				<label for="communityCollType"><?php $this->msg('coll-community_collection_label') ?></label>
				<label for="communityCollTitle"><?php echo htmlspecialchars(Title::makeTitle($GLOBALS['wgCommunityCollectionNamespace'], wfMsgForContent('coll-collections'))->getPrefixedText() . '/') ?></label>
				<input id="communityCollTitle" type="text" name="ccollname" disabled="disabled" /><br />
				<input id="saveButton" type="submit" value="<?php $this->msg('coll-save_collection') ?>"<?php if (count($this->data['collection']['items']) == 0) { ?> disabled="disabled"<?php } ?> />
			</form>

		<?php } else {
			$this->msgWiki('coll-login_to_save');
		}
		$this->msgWiki('coll-save_category');
		?>
	</div>

</div>



<?php
	}
}

/**
 * HTML template for Special:Collection collection item list
 * @ingroup Templates
 */
class CollectionListTemplate extends QuickTemplate {
	function execute() {		
		$mediapath = $GLOBALS['wgScriptPath'] . '/extensions/Collection/collection/';
?>

<div style="text-align: center; padding: 2px; margin-top: 20px; margin-bottom: 2px; border: 1px solid #aaa; background-color: #f9f9f9;">
<div>
<a class="makeVisible" style="margin-right: 3em;<?php if (!isset($this->data['is_ajax'])) { echo ' display:none;'; } ?>" onclick="return coll_create_chapter()" href="javascript:void(0);"><?php $this->msg('coll-create_chapter') ?></a>
<?php if (count($this->data['collection']['items']) > 0) { ?>
<a style="margin-right: 3em" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'sort_items/')) ?>"><?php $this->msg('coll-sort_alphabetically') ?></a>
<a onclick="return coll_clear_collection()" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'clear_collection/')) ?>"><?php $this->msg('coll-clear_collection') ?></a>
<?php } ?>
</div>
</div>


<div style="padding: 10px 20px; border: 1px solid rgb(170, 170, 170)">

<?php
if (count($this->data['collection']['items']) == 0) { ?>
<em id="emptyCollection"><?php $this->msg('coll-empty_collection'); ?></em>
<?php } else { ?>
<div style="text-align: center; margin-bottom: 10px">
<em class="makeVisible" style="display:none; font-size: 95%"><?php $this->msg('coll-drag_and_drop') ?></em>
</div>
<?php }?>

<ul id="collectionList" style="list-style: none; margin-left: 0;">

<?php
foreach($this->data['collection']['items'] as $index => $item) {
	if ($item['type'] == 'article') { ?>
	<li id="item-<?php echo $index ?>" class="article">
		<a onclick="return coll_remove_item(<?php echo $index ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'remove_item/', 'index=' . $index)) ?>" title="<?php $this->msg('coll-remove') ?>"><img src="<?php echo htmlspecialchars($mediapath . "remove.png") ?>" width="10" height="10" alt="<?php $this->msg('remove') ?>" /></a><a>
		<noscript>
		<?php if ($index == 0) { ?>
			<img src="<?php echo htmlspecialchars($mediapath . "trans.png") ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo $index . ', -1' ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'move_item/', 'delta=-1&index=' . $index)) ?>" title="<?php $this->msg('coll-move_up') ?>"><img src="<?php echo htmlspecialchars($mediapath . "up.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-move_up') ?>" /></a>
		<?php }
		if ($index == count($this->data['collection']['items']) - 1) { ?>
			<img src="<?php echo htmlspecialchars($mediapath . "trans.png") ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo $index . ', 1' ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'move_item/', 'delta=1&index=' . $index)) ?>" title="<?php $this->msg('coll-move_down') ?>"><img src="<?php echo htmlspecialchars($mediapath . "down.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-move_down') ?>" /></a>
		<?php } ?>
		</noscript>
		<?php if ($item['currentVersion'] == 0) { //($item['revision'] && $item['revision'] != $item['latest']) ||
			$revision = '('. htmlspecialchars(wfMsg('coll-revision', $item['revision'])) . ')';
			$url = $item['url'] . '?oldid=' . $item['revision'];
		} else {
			$revision = '';
			$url = $item['url'];
		}
		?>
		<a href="<?php echo $url ?>" title="<?php $this->msg('coll-show') ?>"><img src="<?php echo htmlspecialchars($mediapath . "show.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-show') ?>" /></a>
		<span class="title sortableitem" style="margin-left: 1em;">
		<?php if (isset($item['displaytitle']) && $item['displaytitle'] != '') {
			echo htmlspecialchars($item['displaytitle']);
		} else {
			echo htmlspecialchars($item['title']);
		}
		echo ' ' . $revision; ?>
		</span>
	</li>
	<?php } else if ($item['type'] == 'chapter') { ?>
	<li id="item-<?php echo $index ?>" class="chapter" style="margin-top:0.3em;">
		<a onclick="return coll_remove_item(<?php echo $index ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'remove_item/', 'index=' . $index)) ?>" title="<?php $this->msg('coll-remove') ?>"><img src="<?php echo htmlspecialchars($mediapath . "remove.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-remove') ?>" /></a>
		<noscript>
		<?php if ($index == 0) { ?>
			<img src="<?php echo htmlspecialchars($mediapath . "trans.png") ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo $index . ', -1' ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'move_item/', 'delta=-1&index=' . $index)) ?>" title="<?php $this->msg('coll-move_up') ?>"><img src="<?php echo htmlspecialchars($mediapath . "up.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-move_up') ?>" /></a>
		<?php }
		if ($index == count($this->data['collection']['items']) - 1) { ?>
			<img src="<?php echo htmlspecialchars($mediapath . "trans.png") ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo $index . ', 1' ?>)" href="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'move_item/', 'delta=1&index=' . $index)) ?>" title="<?php $this->msg('coll-move_down') ?>"><img src="<?php echo htmlspecialchars($mediapath . "down.png") ?>" width="10" height="10" alt="<?php $this->msg('coll-move_down') ?>" /></a>
		<?php } ?>
		</noscript>
		<img src="<?php echo htmlspecialchars($mediapath . "trans.png") ?>" width="10" height="10" alt="" />
		<strong class="title sortableitem" style="margin-left: 0.2em;"><?php echo htmlspecialchars($item['title']) ?></strong>
		<a class="makeVisible" <?php if (!isset($this->data['is_ajax'])) { echo 'style="display:none"'; } ?> onclick="return coll_rename_chapter(<?php echo $index . ', \'' . $item['title'] . '\''; ?>)" href="javascript:void(0)">[<?php $this->msg('coll-rename') ?>]</a>
	</li>
	<?php }
} ?>
</ul>

</div>

<?php
	}
}

/**
 * HTML template for Special:Collection/load_collection/ when overwriting an exisiting collection
 * @ingroup Templates
 */
class CollectionLoadOverwriteTemplate extends QuickTemplate {
	function execute() {
?>

<?php $this->msgWiki('coll-load_overwrite_text'); ?>

<form action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'load_collection/')) ?>" method="post">
	<input name="overwrite" type="submit" value="<?php $this->msg('coll-overwrite') ?>" />
	<input name="append" type="submit" value="<?php $this->msg('coll-append') ?>" />
	<input name="cancel" type="submit" value="<?php $this->msg('coll-cancel') ?>" />
	<input name="colltitle" type="hidden" value="<?php echo htmlspecialchars($this->data['title']->getPrefixedText()) ?>" />
</form>

<?php
	}
}

/**
 * HTML template for Special:Collection/save_collection/ when overwriting an exisiting collection
 * @ingroup Templates
 */
class CollectionSaveOverwriteTemplate extends QuickTemplate {
	function execute() {
?>

<h2><span class="mw-headline"><?php $this->msg('coll-overwrite_title') ?></span></h2>

<p><?php echo $GLOBALS['wgParser']->parse(wfMsgNoTrans('coll-overwrite_text', $this->data['title']->getPrefixedText()), $GLOBALS['wgTitle'], $GLOBALS['wgOut']->parserOptions(), true)->getText() ?></p>

<form action="<?php echo htmlspecialchars(SkinTemplate::makeSpecialUrlSubpage('Collection', 'save_collection/')) ?>" method="post">
	<input name="overwrite" type="submit" value="<?php $this->msg('coll-yes') ?>" />
	<input name="abort" type="submit" value="<?php $this->msg('coll-no') ?>" />
	<input name="colltitle" type="hidden" value="<?php echo htmlspecialchars($this->data['title']->getPrefixedText()) ?>" />
</form>

<?php
	}
}

/**
 * HTML template for Special:Collection/rendering/ (in progress)
 * @ingroup Templates
 */
class CollectionRenderingTemplate extends QuickTemplate {
	function execute() {
?>


<span style="display:none" id="renderingStatusText"><?php echo wfMsg('coll-rendering_status', '%PARAM%') ?></span>
<span style="display:none" id="renderingArticle"><?php echo wfMsg('coll-rendering_article', '%PARAM%') ?></span>
<span style="display:none" id="renderingPage"><?php echo wfMsg('coll-rendering_page', '%PARAM%') ?></span>

<?php echo wfMsg('coll-rendering_text',	$GLOBALS['wgLang']->formatNum($this->data['progress']), $this->data['status']) ?>

<?php
	}
}

/**
 * HTML template for Special:Collection/rendering/ (finished)
 * @ingroup Templates
 */
class CollectionFinishedTemplate extends QuickTemplate {
	function execute() {

echo $GLOBALS['wgParser']->parse(
	wfMsgNoTrans('coll-rendering_finished_text', $this->data['download_url']),
	$GLOBALS['wgTitle'],
	$GLOBALS['wgOut']->parserOptions(),
	true
)->getText();

if ($this->data['is_cached']) {
	$forceRenderURL = SkinTemplate::makeSpecialUrlSubpage('Collection', 'forcerender/', $this->data['query']);
	echo wfMsg('coll-is_cached', htmlspecialchars($forceRenderURL));
}
echo $GLOBALS['wgParser']->parse(
	wfMsgNoTrans('coll-excluded-templates', wfMsgForContent('coll-exclusion_category_title')),
	$GLOBALS['wgTitle'],
	$GLOBALS['wgOut']->parserOptions(),
	true
)->getText();
echo $GLOBALS['wgParser']->parse(
	wfMsgNoTrans('coll-blacklisted-templates', wfMsgForContent('coll-template_blacklist_title')),
	$GLOBALS['wgTitle'],
	$GLOBALS['wgOut']->parserOptions(),
	true
)->getText();
if ($this->data['return_to']) {
	// We are doing this the hard way (i.e. via the HTML detour), to prevent
	// the parser from replacing [[:Special:Collection]] with a selflink.
	$t = Title::newFromText($this->data['return_to']);
	echo wfMsg(
		'coll-return_to_collection',
		htmlspecialchars($t->getFullURL()),
		htmlspecialchars($this->data['return_to'])
	);
}
?>

<?php
	}
}

?>
