/*global d3:true*/
var VisualStatsCodeFrequency = {
    init: function(data, user){
        var self = this;
        this.wikiaData = data.wikiaFrequency;
        this.userData = data.userFrequency;
        this.user = user;

        svg = this.drawBackground();
        this.drawVisualisation(svg);
        if (this.user != "0"){
            this.triggerButtons();
        }
    },
    drawVisualisation: function(svg){
        var self = this;

        $("#addedChars").text(this.wikiaData.count.added);
        $("#delChars").text(this.wikiaData.count.deleted);
        $("#numberOfEdits").text(this.wikiaData.total);

        scaleX = d3.scale.linear()
            .domain([0, 14])
            .range([100, 880]);

        var max = VisualStatsCommon.roundUp(this.wikiaData.max);

        this.scaleUp.domain([0, max]);
        this.scaleDown.domain([0, max]);

        for (var i = 0; i <= 3; i++){
            d3.selectAll(".axisLabel" + i).text(function(){
                return parseInt(max / 3 * i);
            });
        }

        this.lineUp = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return self.scaleUp(d.added); });

        this.lineDown = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return self.scaleDown(d.deleted); });


        var i = 0;
        this.wikiaDataset= [];
        this.userDataset= [];
        $.each(this.wikiaData.data, function(date, value){
            svg.append("svg:text")
                .attr("x", scaleX(i))
                .attr("y", 645)
                .text(date)
                .attr("id", function(){return "date" + i;})
                .attr("font-size", 8)
                .attr("fill", "black")
                .attr("text-anchor", "start")
                .attr("transform", "rotate(20 " + scaleX(i) + " " + 630 + ")");
            self.wikiaDataset[i] = value;
            i++;
        });

        i = 0;
        $.each(this.userData.data, function(date, value){
            self.userDataset[i] = value;
            i++;
        });

        svg.append("path").attr("d", this.lineUp(self.wikiaDataset))
            .style("stroke", "#48C783")
            .style("fill", "#41FA97")
            .style("stroke-width", "1px")
            .attr("id", "greenLine");

        svg.append("path").attr("d", this.lineDown(self.wikiaDataset))
            .style("stroke", "#F53131")
            .style("fill", "#F75959")
            .style("stroke-width", "1px")
            .attr("id", "redLine");
    },

    triggerButtons: function(){
            var self = this;
            $("#buttons").css('visibility', 'visible');
            $("#wikiaButton").click(function(){
                $(this).removeClass("secondary");
                $("#userButton").addClass("secondary");
                $("#numberOfEdits").text(self.wikiaData.total);
                $("#addedChars").text(self.wikiaData.count.added);
                $("#delChars").text(self.wikiaData.count.deleted);
                self.updateVisualisation("wikia");
            });
            $("#userButton").click(function(){
                $(this).removeClass("secondary");
                $("#wikiaButton").addClass("secondary");
                $("#numberOfEdits").text(self.userData.total);
                $("#addedChars").text(self.userData.count.added);
                $("#delChars").text(self.userData.count.deleted);
                self.updateVisualisation("user");
            });
    },

    updateVisualisation: function (name){
        var self = this;
        if (name == "wikia"){
            var max = VisualStatsCommon.roundUp(this.wikiaData.max);
            for (var i = 0; i <= 3; i++){
                d3.selectAll(".axisLabel" + i).text(function(){
                    return parseInt(max / 3 * i);
                });
            }
            self.scaleDown.domain([0, max]);
            self.scaleUp.domain([0, max]);
            d3.select("#greenLine").transition().attr("d", self.lineUp(self.wikiaDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.wikiaDataset));

        }
        else{
            var max = VisualStatsCommon.roundUp(this.userData.max);
            for (var i = 0; i <= 3; i++){
                d3.selectAll(".axisLabel" + i).text(function(){
                    return parseInt(max / 3 * i);});
            }
            self.scaleDown.domain([0, max]);
            self.scaleUp.domain([0, max]);
            d3.select("#greenLine").transition().attr("d", self.lineUp(self.userDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.userDataset));
        }

    },

    drawBackground: function(){
        var self = this;
        svg = VisualStatsCommon.createSvgContainer(980, 690, "#Graph");
        svg.append("rect")
            .attr("x", 20)
            .attr("y", 0)
            .attr("width", 940)
            .attr("height", 670)
            .attr("fill", "#F0F5FA");

        svg.append("svg:line")
            .attr("x1", 60).attr("y1", 325)
            .attr("x2", 920).attr("y2", 325)
            .attr("stroke", "#41A4FA");

        this.scaleUp = d3.scale.linear()
            .domain([0, 3])
            .range([325, 20]);

        this.scaleDown = d3.scale.linear()
            .domain([0, 3])
            .range([325, 630]);

        for (var i = 0; i<=3; i++){
            svg.append("svg:line")
                .attr("x1", 60).attr("y1", self.scaleDown(i))
                .attr("x2", 920).attr("y2", self.scaleDown(i))
                .attr("stroke", "#41A4FA")
                .attr("stroke-width", "1px");
            svg.append("svg:text")
                .attr("text-anchor", "end")
                .attr("font-size", "9")
                .attr("class", "axisLabel" + i)
                .attr("fill", i == 0 ? "black":"#F53131")
                .attr("x", 57)
                .attr("y", self.scaleDown(i));
            svg.append("svg:line")
                .attr("x1", 60).attr("y1", self.scaleUp(i))
                .attr("x2", 920).attr("y2", self.scaleUp(i))
                .attr("stroke", "#41A4FA")
                .attr("stroke-width", "1px");
            if (i > 0){
                svg.append("svg:text")
                    .attr("text-anchor", "end")
                    .attr("font-size", "9")
                    .attr("class", "axisLabel" + i)
                    .attr("fill", "#48C783")
                    .attr("x", 57)
                    .attr("y", self.scaleUp(i));
            }
        }

        return svg;

    }

}