<!--<div class="tabs-container">
    <ul class="tabs">
        <li data-id="commitactivity">Commit Activity</li>
        <li class="selected" data-id="punchcard">Punchcard<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D">
        </li>
        <li data-id="histogram">Histogram</li>
    </ul>
</div>-->
<div class="tabs-container">
    <ul class="tabs">
        <li id="commit"><a href="/wiki/Special:VisualStats/commit" title="Commit Activity">Commit Activity</a></li>
        <li id="punchcard"><a href="/wiki/Special:VisualStats/punchcard" title="Punchcard">Punchcard</a>
        </li>
        <li id="histogram"><a href="/wiki/Special:VisualStats/histogram" title="Histogram">Histogram</a></li>
    </ul>
</div>

<script type="text/javascript">

    var parameter = <? echo json_encode($param); ?>;

    wgAfterContentAndJS.push(function(){
        $(function () {
            VisualStatsIndexContent.init(parameter);
        });
    });


</script>


