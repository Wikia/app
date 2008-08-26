<!-- s:<?= __FILE__ ?> -->
<br/><b><?=wfMsg('regexblock_form_header')?>:</b>
<p><?=$pager?></p>
<form name="regexlist" method="get" action="<?=$action?>">
<?=wfMsg('regexblock_view_blocked')?>: <select name="filter">
<option value="">All</option>
<? 
if (is_array($blockers)) {
    foreach ($blockers as $id => $blocker) { ?>
<option <?= ($sel_blocker == $blocker) ? "selected=\"selected\"" : ""?> value="<?=$blocker?>"><?=$blocker?></option>	
<?  } 
} 
?>    
</select>&nbsp;<?=wfMsg('regexblock_regex_filter')?><input type="text" name="rfilter" id="regex_filter" value="<?=$regex_filter?>" /><input type="submit" value="Go">
</form>
<br/><br/>
<? if (!empty($blockers)) { ?>
<ul>
<? $loop = 0; $coma = "<b>&#183;</b>";
   foreach($blocker_list as $id => $row) { 
       $loop++;
       $color_expire = "%s";
       if ('infinite' == $row['expiry']) {
           $row['expiry'] = wfMsg('regexblock_permament_block');
       } else {
           if ( wfTimestampNow() > $row['expiry'] ) {
               $color_expire = "<span style=\"color:#DC143C\">%s</span>";
           }
           $row['expiry'] = sprintf($color_expire, $lang->timeanddate( wfTimestamp( TS_MW, $row['expiry'] ), true ));
       }
   
       $exact_match = "(". (($row['exact_match']) ? wfMsg('regexblock_exact_match') : wfMsg('regexblock_regex_match')) . ")";
       $create_block = ($row['create_block']) ? "(".wfMsg('regexblock_create_account').")" : ""; 
       $reason = "<i>".$row['reason']."</i>";
       $stats_link = $skin->makeKnownLinkObj( $titleObj, wfMsg('regexblock_statistics'), 'action=stats&blckid=' . urlencode($row['blckid']) . '&' . $urls) ;

?>   
<li style="border-bottom:1px dashed #778899; padding-bottom:2px;font-size:11px">
   <b><font style="color:#3B7F07; font-size:12px"><?=$row['blckby_name']?></font> <?=$coma?> <?=$exact_match?> <?=$create_block?></b> <?=$coma?> 
   (<?=wfMsg('regexblock_blocker_name')?>: <b><?=$row['blocker']?></b>, <?=$reason?>) <?=wfMsg('regexblock_on_time')?> <?=$row['time']?> <?=$coma?> 
   (<a href="<?=$action_unblock?>&ip=<?=$row['ublock_ip']?>&blocker=<?=$row['ublock_blocker']?>"><?=wfMsg('regexblock_unblock')?></a>) <?=$coma?> <?=$row['expiry']?> <?=$coma?> (<?=$stats_link?>)
</li>
<? } ?>
</ul>
<br/><br/>
<p><?=$pager?></p>
<? } else { ?>
<?= wfMsg('regexblock_empty_list'); ?>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
