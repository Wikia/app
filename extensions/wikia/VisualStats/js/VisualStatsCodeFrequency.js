/*global d3:true*/
var VisualStatsCodeFrequency = {
    init: function(data, user){
        this.wikiaData = data.wikiaFrequency;
        this.userData = data.userFrequency;
        this.user = user;
        this.scaleDown = d3.scale.linear();
        this.scaleUp = d3.scale.linear();

        this.roundUpAll();

        var svg = this.drawBackground();
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

        var scaleX = d3.scale.linear()
            .domain([0, 14])
            .range([100, 880]);

        this.setScales(self.wikiaData);

        for (var i = 1; i <= 3; i++){
            d3.select("#axisUpLabel" + i)
                .text(function(){
                    return parseInt(self.wikiaData.max / 3 * i);})
                .attr("y", self.scaleUpAxis(i));
            d3.select("#axisDownLabel" + i)
                .text(function(){
                    return parseInt(self.wikiaData.min / 3 * i);})
                .attr("y", self.scaleDownAxis(i));
        }

        this.lineUp = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return self.scaleUp(d.added); });

        this.lineDown = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return self.scaleDown(d.deleted); });


        var i = 0;
        this.wikiaDataset = [];
        this.userDataset = [];
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
        var yUp;
        var yDown;
        if (name == "wikia"){
            self.setScales(self.wikiaData);
            self.updateAxis(self.wikiaData);

            d3.select("#greenLine").transition().attr("d", self.lineUp(self.wikiaDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.wikiaDataset));
        }
        else
        {
            self.setScales(self.userData);
            self.updateAxis(self.userData);

            d3.select("#greenLine").transition().attr("d", self.lineUp(self.userDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.userDataset));
        }

    },

    updateAxis: function(data){
        var yUp;
        var yDown;
        var self = this;

        d3.select("#axisZero")
            .attr("y1", self.scaleUpAxis(0))
            .attr("y2", self.scaleUpAxis(0));

        for (var i = 1; i <= 3; i++){
            yUp = self.scaleUpAxis(i);
            yDown = self.scaleDownAxis(i);

            d3.select("#axisUpLabel" + i)
                .text(function(){
                    return parseInt(data.max / 3 * i);})
                .attr("y", yUp);
            d3.select("#axisUp" + i)
                .attr("y1", yUp)
                .attr("y2", yUp);
            d3.select("#axisDownLabel" + i)
                .text(function(){
                    return parseInt(data.min / 3 * i);})
                .attr("y", yDown);
            d3.select("#axisDown" + i)
                .attr("y1", yDown)
                .attr("y2", yDown);
        }
    },

    setScales: function(data){
        var self = this;
        var domainSum = data.max + data.min;
        self.AllScale.domain([0, domainSum]);
        var zero = self.AllScale(data.max);

        self.scaleDown.domain([0, data.min]).range([zero, 630]);
        self.scaleUp.domain([0, data.max]).range([zero, 20]);
        self.scaleDownAxis.range([zero, 630]);
        self.scaleUpAxis.range([zero, 20]);

    },

    roundUpAll: function(){
        var self = this;

        if (self.wikiaData.min > self.wikiaData.max){
            self.wikiaData.min = self.wikiaData.min * 1.05;
            self.wikiaData.max+= self.wikiaData.min * 0.05;
        }
        else{
            self.wikiaData.min+= self.wikiaData.max * 0.05;
            self.wikiaData.max = self.wikiaData.max * 1.05;
        }

        if (self.userData.min > self.userData.max){
            self.userData.min = self.userData.min * 1.05;
            self.userData.max+= self.userData.min * 0.05;
        }
        else{
            self.userData.min+= self.userData.max * 0.05;
            self.userData.max = self.userData.max * 1.05;
        }

        this.wikiaData.min = VisualStatsCommon.roundUp(this.wikiaData.min);
        this.wikiaData.max = VisualStatsCommon.roundUp(this.wikiaData.max);
        this.userData.min = VisualStatsCommon.roundUp(this.userData.min);
        this.userData.max = VisualStatsCommon.roundUp(this.userData.max);

    },

    drawBackground: function(){
        var self = this;
        var svg = VisualStatsCommon.createSvgContainer(980, 690, "#Graph");

        var domainSum = this.wikiaData.max + this.wikiaData.min;

        this.AllScale = d3.scale.linear()
            .domain([0, domainSum])
            .range([20, 630]);

        var zero = self.AllScale(self.wikiaData.max);

        svg.append("rect")
            .attr("x", 20)
            .attr("y", 0)
            .attr("width", 940)
            .attr("height", 670)
            .attr("fill", "#F0F5FA");

        this.scaleUpAxis = d3.scale.linear()
            .domain([0, 3])
            .range([zero, 20]);

        this.scaleDownAxis = d3.scale.linear()
            .domain([0, 3])
            .range([zero, 630]);

        svg.append("svg:line")
            .attr("x1", 60).attr("y1", self.scaleDownAxis(0))
            .attr("x2", 920).attr("y2", self.scaleDownAxis(0))
            .attr("stroke", "#41A4FA")
            .attr("stroke-width", "1px")
            .attr("id", "axisZero");

        var yUp;
        var yDown;
        for (var i = 1; i <= 3; i++){
            yUp = self.scaleUpAxis(i);
            yDown = self.scaleDownAxis(i);
            svg.append("svg:line")
                .attr("x1", 60).attr("y1", yDown)
                .attr("x2", 920).attr("y2", yDown)
                .attr("stroke", "#41A4FA")
                .attr("stroke-width", "1px")
                .attr("id", "axisDown" + i);
            svg.append("svg:text")
                .attr("text-anchor", "end")
                .attr("font-size", "9")
                .attr("id", "axisDownLabel" + i)
                .attr("fill", i == 0 ? "black":"#F53131")
                .attr("x", 57)
                .attr("y", yDown);
            svg.append("svg:line")
                .attr("x1", 60).attr("y1", yUp)
                .attr("x2", 920).attr("y2", yUp)
                .attr("stroke", "#41A4FA")
                .attr("stroke-width", "1px")
                .attr("id", "axisUp" + i);
            svg.append("svg:text")
                .attr("text-anchor", "end")
                .attr("font-size", "9")
                .attr("id", "axisUpLabel" + i)
                .attr("fill", "#48C783")
                .attr("x", 57)
                .attr("y", yUp);

        }
        return svg;
    }
}