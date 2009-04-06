<!-- autocreated Wiki -->
{{maindescription|<?php echo "{$data["title"]}\n" ?>
}}
{{WikiTemplate|
| wiki title = <?php echo "{$data["title"]}\n" ?>
| request name = <?php echo "{$data["subdomain"]}\n" ?>
| wiki url = http://<?= $data["subdomain"] ?>.wikia.com
| wiki logo = http://images.wikia.com/<?= $data["dir_part"] ?>/images/b/bc/Wiki.png
| request description = <?php echo "{$data["title"]}\n" ?>
| request created = <?=  $timestamp."\n" ?>
| request category = <?php echo "{$category}\n" ?>
| request id = <?= $wikid."\n" ?>
| username = <?= $founder->getName()."\n" ?>
| language = <?= $data["language"]."\n" ?>
}}
