<div id="customizewiki-tabview" class="yui-navset">
    <ul class="yui-nav">
<?php foreach ($names as $id => $name): ?>
        <li <?= ($id==0) ? 'class="selected"': ""; ?>><a href="#<?= $name ?>"><em><?= $labels[$id] ?></em></a></li>
<?php endforeach ?>
    </ul>
    <div class="yui-content" style="padding: 1em;">
<?php foreach ($pages as $id => $page): ?>
        <div id="<?= $labels[$id] ?>"><p><?= $page ?></p></div>
<?php endforeach ?>
    </div>
</div>
