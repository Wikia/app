<?php global $wgAdSSBillingThreshold; ?>
<img style="float:right" width="<?php echo $w; ?>" height="<?php echo $h; ?>" src="http://chart.apis.google.com/chart?chxt=x,y&chbh=a&chs=<?php echo $w; ?>x<?php echo $h; ?>&cht=bvg&chco=A2C180&chd=t:<?php echo $d; ?>&chds=0,<?php echo $maxY; ?>&chm=N*cUSD0*,000000,0,-1,12&chxr=1,0,<?php echo $maxY; ?>&chxl=0:|<?php echo $xl0; ?>|&chtt=Daily+Income+(last+7+days)" />
<table border="1" class="TablePager">
  <thead>
    <tr><th>User</th><th>Balance</th><th>Last billed</th></tr>
  </thead>
  <tbody>
    <?php foreach( $lines as $l ): ?>
    <tr>
      <td><?php echo $l['user']; ?></td>
      <?php if( $l['amount'] > $wgAdSSBillingThreshold ): ?>
      <td style="text-align: right; color: red;"><?php echo $l['amount']; ?> USD</td>
      <?php else: ?>
      <td style="text-align: right"><?php echo $l['amount']; ?> USD</td>
      <?php endif; ?>
      <?php if( strtotime( '+1 month', wfTimestampOrNull( TS_UNIX, $l['lastBilled'] )) < time() ): ?>
      <td style="color: red;"><?php echo $l['lastBilled']; ?></td>
      <?php else: ?>
      <td><?php echo $l['lastBilled']; ?></td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
