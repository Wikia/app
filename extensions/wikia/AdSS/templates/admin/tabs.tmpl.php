<ul class="tabs">
  <?php foreach( $tabs as $tab ): ?>
  <li<?php if( $tab == $selectedTab ) echo ' class="selected"'; ?>>
    <a href="<?php echo $selfUrl . '/' . $tab; ?>"><?php echo wfMsgHtml( 'adss-admin-tab-'.$tab ); ?></a>
  </li>
  <?php endforeach; ?>
</ul>
