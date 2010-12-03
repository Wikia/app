<span id="<?php echo $ad->id; ?>">
<?php if( $ad->expires == null ): ?>
<a class="accept" href="#">Accept</a> | 
<?php endif; ?>
<a class="close" href="#">Close</a>
<?php if( $ad->type == 't' ): ?>
| <a class="edit" href="#">Edit</a>
<?php endif; ?>
</span>
