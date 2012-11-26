<li class="mytools menu">
    <span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-single"></span></span>
    <a href="#"><?= $data['caption'] ?></a>
    <ul id="my-tools-menu" class="tools-menu">
        <?= F::app()->renderView('Footer', 'Menu', array('format' => 'html', 'items' => $data['items'])) ?>
    </ul>
</li>
