<h1><?=$header?></h1>


<script type="text/javascript">


    $(function () {

        //Preparing SVG container

        var svg = d3.select("#WikiaArticle")
            .append("svg")
            .attr("width", 900)
            .attr("height", 1000)
            .attr("xmlns", "http://www.w3.org/2000/svg")
            .attr("version", "1.1");

        var bundle = d3.layout.bundle();

        //Importing data from wikiMap.Class.php

        var colour = <? echo json_encode($colourArray); ?>;
        var data = <? echo json_encode($res); ?>;
        var nodes = data.nodes;
        var max = data.max;

        //Declaring variables needed to draw
        //rotationByOne - measured in degrees
        var rotationByOne = 360 / (data.length);
        var angleRadian;
        var rot = 270;
        var modifier = 0;
        var halfNodes = parseInt(data.length / 2);
        var points = [];
        var currentTitle;
        var transparencyByOne = 0.5/max;
        console.log(transparencyByOne);

        //Drawing text labels
        $.each(nodes, function (index, value) {
            if (index == halfNodes) {
                rot = 90;
            }
              //  var colorLinks = saasParams.color-links;
                //console.log(saasParams);
            //angleRadian - measured in radians
            var path = wgArticlePath;
            angleRadian = ((180 - rotationByOne * index) % 360) * Math.PI / 180;
            var attrX = 450 + 250 * Math.sin(angleRadian);
            var attrY = 500 + 250 * Math.cos(angleRadian);
              //  console.log(wgArticlePath);
                var svga = svg.
                    append("a").
                    attr("xlink:href", function()
                    {
                        currentTitle =  value.title;
                        currentTitle = currentTitle.replace(/ /g,'_');
                        return path.replace('$1',currentTitle);
                    }
                );
            //    console.log(colour.labels);
                var textColor = $.xcolor.darken(colour.labels);
            svga.append("svg:text").
                text(value.title).
                attr("font-size", 11).
                attr("text-anchor", rot == 90 ? "end" : "start").
                attr("x", attrX).
                attr("y", attrY).
                attr("fill", function(){
                    return $.xcolor.opacity(colour.body, textColor, 0.5+transparencyByOne*value.connections.length);
                }).
                on("mouseover", function(){

                    var elements = d3.selectAll(".from" + index).style("stroke", $.xcolor.green(colour.line)).style("stroke-width", "3px");
                  /*  $.each(elements, function (index, value) {
                        value.parentNode.appendChild(value);
                    })*/
                }).
                on("mouseout", function(){

                    d3.selectAll(".from" + index).style("stroke", colour.line).style("stroke-width", "1px");
                    //el.parentNode.appendChild(el)
                }).
                attr("transform", function () {
                    return "rotate(" + (rotationByOne * index + rot) % 360 + ", " + attrX + "," + attrY + ")"
                    }
                );

            //Creating array of points, where text labels are placed
            //Attributes X and Y are the same as attrX and attrY, but are drawn based on different radius
            var point = new Object();
            point.x = 450 + 246 * Math.sin(angleRadian);
            point.y = 500 + 246 * Math.cos(angleRadian);
            points[index] = point;

        }
        );

        //End of drawing text labels

        //Drawing connections between nodes

        $.each(nodes, function (index, value) {
            $.each(value.connections, function (ind, pt2) {
                //var actColor = $.xcolor.random();
                svg.append("path").
                    attr("class", function(){
                       /* currentTitle =  "from" + value.title;
                        return currentTitle.replace(/ :/g,'_');*/
                        return "from" + index;
                    }).
                    attr("d", function(){
                        var str = 'M ' + points[index].x +' ' + points[index].y +' q ';
                        str+= 450-points[index].x;
                        str+= ' ';
                        str+= 500-points[index].y;
                        str+= ' ';
                        str+= points[pt2].x-points[index].x;
                        str+= ' ';
                        str+= points[pt2].y-points[index].y;

                        return str;
                    })
                    .style("stroke", colour.line)
                    .style("stroke-width", "1px")
                    .attr("fill", "none")
                ;
                   // } );
               /* svg.append("line")
                    .attr("x1", points[index].x)
                    .attr("y1", points[index].y)
                    .attr("x2", points[pt2].x)
                    .attr("y2", points[pt2].y)
                    .style("stroke", colour.line)
                    .style("stroke-width", "1px");*/
            })
        });


    });


</script>
