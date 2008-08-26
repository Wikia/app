<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
.TablePager {width: 100%;}
.TablePager, .TablePager th, .TablePager td {border: 1px solid #777777;}
td.tablepager-col-2 {background: rgb(173, 216, 230); }
td.tablepager-col-3 {background: rgb(180, 230, 164); }
td.tablepager-col-4 {background: rgb(230, 166, 166); }
td.tablepager-col-5 {background: rgb(180, 163, 226); }
/*]]>*/
</style>
<div>
    <?= $limit ?>
    <div style="text-align: center;width: 100%;">
        <?= $body ?>
    </div>
    <?= $nav ?>
</div>
<table>
    <td class="tablepager-col-2">run</td>
    <td class="tablepager-col-3">finished ok</td>
    <td class="tablepager-col-4">finished error</td>
    <td class="tablepager-col-5">finished undo</td>
</table>

<!-- e:<?= __FILE__ ?> -->
