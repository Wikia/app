<div id="header">
    <h1>
        <?echo $header;?>
    </h1>
    <h3>
        <?echo $artCount;?>
    </h3>
</div>
<div id="wikiMap"></div>
<label id="checkBoxContainer">
    <input type="checkbox" id="animationCheckbox">
    <?echo $animation;?>
</label>
<div id="categoriesContainer">
    <h2>
        <?=$categoriesHeader?>
    </h2>
</div>

<script type="text/javascript">

    var colour = <? echo json_encode($colourArray); ?>;
    var data = <? echo json_encode($res); ?>;
    var categories = <? echo json_encode($categories); ?>;
    var ns = <? echo json_encode($namespace); ?>;

    wgAfterContentAndJS.push(function(){
        $(function () {
            WikiMapIndexContent.init(colour, data, categories, ns);
        });
    });

</script>


