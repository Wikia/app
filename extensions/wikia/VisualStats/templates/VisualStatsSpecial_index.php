<div class="tabs-container">
    <ul class="tabs">
        <li id="commit"><a href="<?=$urlCommit?>" title="Commit Activity">Commit Activity</a></li>
        <li id="punchcard"><a href="<?=$urlPunchcard?>" title="Punchcard">Punchcard</a>
        </li>
        <li id="histogram"><a href="<?=$urlHistogram?>" title="Histogram">Histogram</a></li>
    </ul>
</div>
<div id="Graph">
    <? if ($param=="punchcard") include 'VisualStatsPunchcardContent.php'?>
</div>
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
            $('#' + parameter).addClass("selected");
            if (user == "0"){
                $("#buttons").remove();
            }
            switch (parameter){
                case "commit":
                    VisualStatsCommitActivity.init(parameter, data, user)
                    break;
                case "punchcard":
                    VisualStatsPunchcard.init();
                    break;
                case "histogram":
                    //this.drawHistogram();
                    break;
            }
           // VisualStatsIndexContent.init(parameter, data, user);
        });
    });


</script>


