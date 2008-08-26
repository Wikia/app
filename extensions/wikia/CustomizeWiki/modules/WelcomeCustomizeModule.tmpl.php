<!-- s:<?= __FILE__ ?> -->
<div id="customwelcome">
<form id="logo-upload" method="post" enctype="multipart/form-data" action="<?= $title->getFullURL() ?>">
<p>
<?= wfMsgForContent( "customwelcome_welcomeinfo" ); ?>
</p>
<p>
    <ul>
        <li><?= wfMsg("customwelcome_yourwikiname") ?> <?= $wiki->city_title ?></li>
        <li><?= wfMsg("customwelcome_yourwikiurl") ?> <a href="<?= $wiki->city_url ?>"><?= $wiki->city_url ?></a></li>
    </ul>
</p>
</div>
    <label style="display: block;text-align: left;"><?= wfMsg("customwelcome_label") ?></label>
    <input type="hidden" name="wpWikiID" value="<?= $wiki->city_id ?>" />
    <textarea class="fullWidth" name="wpDescription" rows="4"><?= $customDescription ?></textarea>
    <div class="actionBar">
            <input type="hidden" name="wpModule" value="<?= $module->getName() ?>" />
            <a href="<?= $title->getFullURL("module={$next->getName()}") ?>"><?= wfMsgForContent("customizewiki_skipstep") ?></a>
            <input type="submit" name="wpSubmit" id="customize-wiki-form-submit" value="<?= wfMsg("customizewiki_savecontinue") ?>" class="button" />
    </div>
</form>
<!-- e:<?= __FILE__ ?> -->
