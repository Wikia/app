<?php if ( !empty($errors) ) { ?>
<div class="userrollback-errors errorbox"><ul>
<?php foreach ($errors as $error) { ?>
<li><?= $error ?></li>
<?php } ?>
</ul></div>
<?php } ?>