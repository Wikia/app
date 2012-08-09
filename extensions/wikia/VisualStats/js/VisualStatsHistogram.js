/*global d3:true*/
var VisualStatsHistogram = {
    init: function(data, user){
        this.wikiaHistogram = data.wikiaHistogram;
        this.userHistogram = data.userHistogram;
        this.user = user;

        this.wikiaAll = data.wikiaHistogram.all;
        this.userAll = data.userHistogram.all;

        this.drawHistogram();

    },

    drawHistogram: function(){
        var svg = VisualStatsCommon.createSvgContainer(980, 650, "#Graph");
        var self = this;
        var wikiaMax = VisualStatsCommon.roundUp(this.wikiaHistogram.max);
        var userMax = VisualStatsCommon.roundUp(this.userHistogram.max);

        $("#numberOfEdits").text(self.wikiaAll);

        svg.append("rect")
            .attr("x", 20)
            .attr("y", 45)
            .attr("width", 940)
            .attr("height", 600)
            .attr("fill", "#E4EDD3");

        VisualStatsCommon.drawAxis(svg);

        this.scaleY = d3.scale.linear()
            .domain([0, wikiaMax])
            .range([600, 100]);

        var scaleX = d3.scale.linear()
            .domain([0, 23])
            .range([100, 880]);
        var wikiaDataset= [];
        var userDataset= [];
        $.each(this.wikiaHistogram.data, function(hour, value){
            svg.append("svg:text")
                .attr("x", scaleX(hour))
                .attr("y", 620)
                .text(hour + ":00")
                .attr("id", function(){return "hour" + hour;})
                .attr("font-size", 9)
                .attr("fill", "black")
                .attr("text-anchor", "middle");
            wikiaDataset[hour] = value;
        });

        $.each(this.userHistogram.data, function(hour, value){
            userDataset[hour] = value;
        });

        if (this.user != "0"){
            $("#buttons").css('visibility', 'visible');
            $("#wikiaButton").click(function(){
                $(this).removeClass("secondary");
                $("#userButton").addClass("secondary");
                $("#numberOfEdits").text(self.wikiaAll);
                self.updateHistogram(svg, wikiaDataset, wikiaMax);
            });
            $("#userButton").click(function(){
                $(this).removeClass("secondary");
                $("#wikiaButton").addClass("secondary");
                $("#numberOfEdits").text(self.userAll);
                self.updateHistogram(svg, userDataset, userMax);
            });
        }

        svg.append("svg:text")
            .text(parseInt(wikiaMax / 2))
            .attr("id", "halfLabel")
            .attr("x", 55)
            .attr("y", 352)
            .attr("text-anchor", "end");
        svg.append("svg:text")
            .text(wikiaMax)
            .attr("id", "maxLabel")
            .attr("x", 55)
            .attr("y", 102)
            .attr("text-anchor", "end");

        this.line = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return this.scaleY(d); })
            .interpolate("monotone");

        svg.append("path").attr("d", this.line(wikiaDataset))
            .style("stroke", "#248EA6")
            .style("fill", "none")
            .style("stroke-width", "3px");

        svg.selectAll("circle")
            .data(wikiaDataset)
            .enter()
            .append("circle")
            .attr("cx", function(d, i) { return scaleX(i); })
            .attr("cy", function(d) { return self.scaleY(d); })
            .attr("r", 4)
            .attr("stroke", "pink")
            .attr("fill", "#42C5E3")
            .on("mouseover", function(d,i){
                d3.select(this).attr("fill", "#72D6BF").attr("r", 6);
                d3.select("#label" + i).attr("font-size", 13).attr("font-weight", "bold");
                d3.select("#hour" + i).attr("font-size", 11).attr("fill", "red").attr("font-weight", "bold");
            })
            .on("mouseout", function(d,i){
                d3.select(this).attr("fill", "#42C5E3").attr("r", 4);
                d3.select("#label" + i).attr("font-size", 9).attr("font-weight", "normal");
                d3.select("#hour" + i).attr("font-size", 9).attr("fill", "black").attr("font-weight", "normal");
            });

        svg.selectAll(".labels")
            .data(wikiaDataset)
            .enter()
            .append("svg:text")
            .attr("class", "labels")
            .attr("id", function(d,i){ return 'label' + i;})
            .attr("x", function(d, i) { return scaleX(i) - 5; })
            .attr("y", function(d) { return self.scaleY(d) - 5; })
            .text(function(d) { return d; })
            .attr("font-size", 9)
            .attr("text-anchor", "end");

    },

    updateHistogram: function(svg, dataToUpdate, max){
        this.scaleY.domain([0, max]);
        svg.select("#halfLabel").text(parseInt(max / 2));
        svg.select("#maxLabel").text(max);

        var self = this;
        svg.selectAll("circle")
            .data(dataToUpdate)
            .transition()
            .attr("cy", function(d) { return self.scaleY(d); });
        svg.selectAll(".labels")
            .data(dataToUpdate)
            .transition()
            .attr("y", function(d) { return self.scaleY(d)-5; })
            .text(function(d) { return d; });
        svg.select("path")
            .transition()
            .attr("d", this.line(dataToUpdate));

    }
}
