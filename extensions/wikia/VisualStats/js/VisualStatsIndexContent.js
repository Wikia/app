/*global d3:true*/
var VisualStatsIndexContent = {
    init: function(parameter, data, dates){
        this.wikiaCommit = data.wikiaCommit;
        //this.userData = data.user;
        this.dates = dates;

        $('#' + parameter).addClass("selected");
        switch (parameter){
            case "commit":
                this.drawCommitActivity();
                break;
            case "punchcard":
                this.drawPunchcard();
                break;
            case "histogram":
                this.drawHistogram();
                break;

        }
    },
    drawCommitActivity: function(){
        var svg = this.createSvgContainer(1000,1000,"#Graph");
        svg.append("svg:line").
            attr("x1", 60).
            attr("y1",600).
            attr("x2", 900).
            attr("y2",600).
            attr("stroke", "green");
        svg.append("svg:line").
            attr("x1", 60).
            attr("y1",600).
            attr("x2", 60).
            attr("y2",100).
            attr("stroke", "green");

        var max = this.wikiaCommit.max;
        max+=12;
        max=Math.ceil(max/10)*10;
        var scaleY = d3.scale.linear()
            .domain([0, max])
            .range([600, 100]);

        var scaleX = d3.scale.linear()
            .domain([0, 14])
            .range([120, 840]);
        var i = 0;
        var dataset= [];
        console.log(this.wikiaCommit.data);
        $.each(this.wikiaCommit.data, function(date, value){
            svg.append("svg:text").
                attr("x", scaleX(i)).
                attr("y", 620).
                text(date).
                attr("font-size", 8).
                attr("text-anchor", "middle");

           /* svg.append("circle").
                attr("cx", scaleX(i)).
                attr("cy", scaleY(value)).
                attr("r", 3).
                attr("stroke", "pink").
                attr("fill", "#42C5E3").
                on("mouseover", function(){
                    d3.select(this).attr("fill", "#A1D9E6");
                }).
                on("mouseout", function(){
                    d3.select(this).attr("fill", "#42C5E3");
                });*/
           /* svg.append("svg:text").
                attr("class", "labels").
                attr("x", scaleX(i)-5).
                attr("y", scaleY(value)-5).
                text(value).
                attr("font-size", 9).
                attr("text-anchor", "end");*/
            dataset[i] = value;
            i++;
        })


        var line = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return scaleY(d); })
            .interpolate("monotone");

        svg.append("path").attr("d", line(dataset))
            .style("stroke", "#248EA6")
            .style("fill", "none")
            .style("stroke-width", "3px");

        svg.selectAll("circle")
            .data(dataset)
            .enter().append("circle")
            .attr("cx", function(d, i) { return scaleX(i); })
            .attr("cy", function(d) { return scaleY(d); })
            .attr("r", 4).
            attr("stroke", "pink").
            attr("fill", "#42C5E3").
            on("mouseover", function(){
                d3.select(this).attr("fill", "#72D6BF").attr("r", 6);
            }).
            on("mouseout", function(){
                d3.select(this).attr("fill", "#42C5E3").attr("r", 4);
            });

        svg.selectAll(".labels").
            data(dataset).
            enter().
            append("svg:text").
            attr("x", function(d, i) { return scaleX(i)-5; }).
            attr("y", function(d) { return scaleY(d)-5; }).
            text(function(d) { return d; }).
            attr("font-size", 9).
            attr("text-anchor", "end");



    },
    drawPunchcard: function(){
        this.createSvgContainer(1000,1000,"#Graph");

    },
    drawHistogram: function(){
        this.createSvgContainer(1000,1000,"#Graph");

    },
    createSvgContainer: function(width, height, div){
        return d3.select(div)
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .attr("xmlns", "http://www.w3.org/2000/svg")
            .attr("version", "1.1");
    }


}
