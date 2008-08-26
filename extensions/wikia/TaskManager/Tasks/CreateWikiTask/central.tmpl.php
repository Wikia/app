<!-- added by bot -->
{{WikiTemplate|
| wiki title = <?php echo "{$data["title"]}\n" ?>
| request name = <?php echo "{$data["subdomain"]}\n" ?>
| wiki url = http://<?= $data["subdomain"] ?>.wikia.com
| wiki logo = http://images.wikia.com/<?= $data["dir_part"] ?>/images/b/bc/Wiki.png
| request description = <?php echo "{$param["wpCreateWikiDesc"]}\n" ?>
| request created = <?=  $timestamp."\n" ?>
| request category = <?php echo "{$param["wpCreateWikiCategory"]}\n" ?>
<?php
    if( is_array($categories) ):
        foreach( $categories as $id => $cat ):
            echo "| category{$id} = {$cat}\n";
        endforeach;
    endif
?>
| request id = <?= $wikid."\n" ?>
| username = <?= $founder->getName()."\n" ?>
| language = <?= $data["language"]."\n" ?>
}}
