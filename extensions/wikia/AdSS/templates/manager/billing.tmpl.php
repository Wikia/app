<fieldset class="panel">
<p><b><? echo wfMsgHtml( 'adss-your-balance' ); ?></b> <?php echo wfMsgHtml( 'adss-amount', $balance ); ?><br />
<b><? echo wfMsgHtml( 'adss-your-billing-agreement' ); ?></b> <?php echo $baid; ?></p>

<?php echo $billing; ?>
<?php echo $navigationBar; ?>
</fieldset>

<script type="text/javascript">/*<![CDATA[*/
$('td.TablePager_col_description').mouseover( function() { $(this).find('div').show(); } );
$('td.TablePager_col_description').mouseout( function() { $(this).find('div').hide(); } );
</script>
