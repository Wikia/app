<div class="tabs-container">
    <ul class="tabs">
        <li id="commit"><a href="/wiki/Special:VisualStats/commit?user=<? echo $user;?>" title="Commit Activity">Commit Activity</a></li>
        <li id="punchcard"><a href="/wiki/Special:VisualStats/punchcard?user=<?=$user?>" title="Punchcard">Punchcard</a>
        </li>
        <li id="histogram"><a href="/wiki/Special:VisualStats/histogram?user=<?=$user?>" title="Histogram">Histogram</a></li>
    </ul>
</div>
<div id="Graph"></div>
    <div id="buttons">
        <button id="wikiaButton"><?=$wikiButtonLabel?></button>
        <button id="userButton" class="secondary"><?=$userButtonLabel?></button>
    </div>


<script type="text/javascript">

    var parameter = <? echo json_encode($param); ?>;
    var data = <? echo json_encode($data); ?>;
    var user = <? echo json_encode($user); ?>;

    wgAfterContentAndJS.push(function(){
        $(function () {
            VisualStatsIndexContent.init(parameter, data, user);
        });
    });


</script>


