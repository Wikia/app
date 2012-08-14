<div class="tabs-container">
    <ul class="tabs">
        <li id="commit"><a href="<?=$urlCommit?>" title="<?=$commitActivity?>"><?=$commitActivity?></a></li>
        <li id="punchcard"><a href="<?=$urlPunchcard?>" title="<?=$punchcard?>"><?=$punchcard?></a>
        </li>
        <li id="histogram"><a href="<?=$urlHistogram?>" title="<?=$histogram?>"><?=$histogram?></a></li>
        <li id="codeFrequency"><a href="<?=$urlCodeFrequency?>" title="<?=$codeFrequency?>"><?=$codeFrequency?></a></li>
    </ul>
</div>
<div id="editsCount">
    <? if ($param=="codeFrequency") {
    echo '<div>' . $added . '<span id="addedChars"></span></div>';
    echo '<div>' . $deleted . '<span id="delChars"></span></div>';
}?>
    <? echo $shown; ?>
    <span id="numberOfEdits"></span>
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
            console.log(parameter);
            switch (parameter){
                case "commit":
                    VisualStatsCommitActivity.init(data, user);
                    break;
                case "punchcard":
                    var color = <? echo json_encode($link); ?>;
                    var edits = <? echo json_encode($edits); ?>;
                    var edit = <? echo json_encode($edit); ?>;
                    VisualStatsPunchcard.init(data, user, color, edits, edit);
                    break;
                case "histogram":
                    VisualStatsHistogram.init(data, user);
                    break;
                case "codeFrequency":
                    var addition = <? echo json_encode($addition); ?>;
                    var totalChars = <? echo json_encode($totalChars); ?>;
                    VisualStatsCodeFrequency.init(data, user, addition, totalChars);
                    break;
            }
        });
    });


</script>


