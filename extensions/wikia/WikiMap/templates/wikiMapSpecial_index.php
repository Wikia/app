<div id="header">
    <h1>
        <?echo $header;?>
    </h1>
</div>
<div id="wikiMap"></div>
<div id="categoriesContainer">
    <h2>
        <?=$categoriesHeader?>
    </h2>
</div>

<script type="text/javascript">

    var colour = <? echo json_encode($colourArray); ?>;
    var data = <? echo json_encode($res); ?>;
    var categories = <? echo json_encode($categories); ?>;
    $(function () {
        WikiMapIndexContent.init(colour, data, categories);
    });


</script>
