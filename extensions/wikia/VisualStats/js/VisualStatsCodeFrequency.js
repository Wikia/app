/*global d3:true*/
var VisualStatsCodeFrequency = {
    init: function(data, user, additions, totalChars){
        this.wikiaData = data.wikiaFrequency;
        this.userData = data.userFrequency;
        this.wikiaLine = data.wikiaLine;
        this.userLine = data.userLine;
        this.user = user;
        this.scaleDown = d3.scale.linear();
        this.scaleUp = d3.scale.linear();

        this.roundUpAll();

        var svg = this.drawBackground();
        this.drawVisualisation(svg);
        this.drawAxisXLabels(additions, totalChars, svg);
        if (this.user != "0"){
            this.triggerButtons();
        }
    },
    drawVisualisation: function(svg){
        var self = this;

        $("#addedChars").text(this.wikiaData.count.added);
        $("#delChars").text(this.wikiaData.count.deleted);
        $("#numberOfEdits").text(this.wikiaData.total);

        this.scaleX = d3.scale.linear()
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
            .x(function(d, i) { return self.scaleX(i); })
            .y(function(d) { return self.scaleUp(d.added); });

        this.lineDown = d3.svg.line()
            .x(function(d, i) { return self.scaleX(i); })
            .y(function(d) { return self.scaleDown(d.deleted); });


        var i = 0;
        this.wikiaDataset = [];
        this.userDataset = [];
        $.each(this.wikiaData.data, function(date, value){
            svg.append("svg:text")
                .attr("x", self.scaleX(i))
                .attr("y", 645)
                .text(date)
                .attr("id", function(){return "date" + i;})
                .attr("font-size", 8)
                .attr("fill", "black")
                .attr("text-anchor", "start")
                .attr("transform", "rotate(20 " + self.scaleX(i) + " " + 630 + ")");
            self.wikiaDataset[i] = value;
            i++;
        });


        if (this.user != "0"){
        i = 0;
            $.each(this.userData.data, function(date, value){
                self.userDataset[i] = value;
                i++;
            });
        }

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
        this.drawLine(this.wikiaLine, svg);
    },

    drawLine: function(lineDataset, svg){
        var self = this;

        this.scaleTotalChars = d3.scale.linear()
            .domain([lineDataset.min, lineDataset.max])
            .range([630, 20]);
        this.sumLine = d3.svg.line()
            .x(function(d, i) { return self.scaleX(i); })
            .y(function(d) { return self.scaleTotalChars(d); })
            .interpolate("basis");
        this.updateRightAxis(self.wikiaLine.min, self.wikiaLine.max);

        svg.append("svg:path")
            .attr("d", self.sumLine(lineDataset.nodes))
            .attr("stroke", "#54B7E8")
            .style("stroke-width", "3px")
            .attr("id", "totalCharsLine")
            .attr("fill", "none");

        svg.append("svg:line")
            .attr("x1", 100).attr("y1", self.scaleTotalChars(0))
            .attr("x2", 920).attr("y2", self.scaleTotalChars(0))
            .attr("stroke", "#54B7E8")
            .attr("stroke-width", "1px");
        svg.append("svg:text")
            .attr("text-anchor", "start")
            .attr("font-size", "9")
            .attr("id", "axisRightZero")
            .attr("fill", "#54B7E8")
            .attr("x", 921)
            .attr("y", self.scaleTotalChars(0))
            .text("0");
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
            self.setScales(self.wikiaData);
            self.updateAxis(self.wikiaData.min, self.wikiaData.max);

            self.scaleTotalChars.domain([self.wikiaLine.min, self.wikiaLine.max]);

            d3.select("#greenLine").transition().attr("d", self.lineUp(self.wikiaDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.wikiaDataset));
            d3.select("#totalCharsLine").transition().attr("d", self.sumLine(self.wikiaLine.nodes));
            self.updateRightAxis(self.wikiaLine.min, self.wikiaLine.max);
        }
        else
        {
            self.setScales(self.userData);
            self.updateAxis(self.userData.min, self.userData.max);

            self.scaleTotalChars.domain([self.userLine.min, self.userLine.max]);

            d3.select("#greenLine").transition().attr("d", self.lineUp(self.userDataset));
            d3.select("#redLine").transition().attr("d", self.lineDown(self.userDataset));
            d3.select("#totalCharsLine").transition().attr("d", self.sumLine(self.userLine.nodes));
            self.updateRightAxis(self.userLine.min, self.userLine.max);
        }

    },

    updateRightAxis: function(min, max){
        var self = this;
        this.scaleRightAxis = d3.scale.linear()
            .domain([0, 4])
            .range([min, max]);
        for (var i = 0; i <= 4; i++){
            d3.select("#axisRightLabel" + i)
                .text(function(){
                    return parseInt(self.scaleRightAxis(i));});
        }
    },

    updateAxis: function(min, max){
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
                    return parseInt(max / 3 * i);})
                .attr("y", yUp);
            d3.select("#axisUp" + i)
                .attr("y1", yUp)
                .attr("y2", yUp);
            d3.select("#axisDownLabel" + i)
                .text(function(){
                    return parseInt(min / 3 * i);})
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

        var sum = Math.abs(self.wikiaLine.min) + self.wikiaLine.max;
        self.wikiaLine.max+= 0.05 * sum;
        self.wikiaLine.min-= 0.05 * sum;
        self.wikiaLine.max = Math.ceil(self.wikiaLine.max / 10) * 10;
        self.wikiaLine.min = Math.floor(self.wikiaLine.min / 10) * 10;

        this.wikiaData.min = VisualStatsCommon.roundUp(self.wikiaData.min);
        this.wikiaData.max = VisualStatsCommon.roundUp(self.wikiaData.max);

        if(this.user != "0"){

            if (self.userData.min > self.userData.max){
                self.userData.min = self.userData.min * 1.05;
                self.userData.max+= self.userData.min * 0.05;
            }
            else{
                self.userData.min+= self.userData.max * 0.05;
                self.userData.max = self.userData.max * 1.05;
            }
            sum = Math.abs(self.userLine.min) + self.userLine.max;
            self.userLine.max+= 0.05 * sum;
            self.userLine.min-= 0.05 * sum;
            self.userLine.max = Math.ceil(self.userLine.max / 10) * 10;
            self.userLine.min = Math.floor(self.userLine.min / 10) * 10;

            this.userData.min = VisualStatsCommon.roundUp(self.userData.min);
            this.userData.max = VisualStatsCommon.roundUp(self.userData.max);
        }

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
            .attr("stroke", "#ECBDFF")
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
                .attr("stroke", "#ECBDFF")
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
                .attr("stroke", "#ECBDFF")
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

        this.scaleRightAxis = d3.scale.linear()
            .domain([4, 0])
            .range([20, 630]);

        for (var i = 0; i <= 4; i++){
            yUp = self.scaleRightAxis(i);
            svg.append("svg:line")
                .attr("x1", 900).attr("y1", yUp)
                .attr("x2", 920).attr("y2", yUp)
                .attr("stroke", "#54B7E8")
                .attr("stroke-width", "4px");
            svg.append("svg:text")
                .attr("text-anchor", "start")
                .attr("font-size", "9")
                .attr("id", "axisRightLabel" + i)
                .attr("fill", "#54B7E8")
                .attr("x", 921)
                .attr("y", yUp);
        }
        return svg;
    },

    drawAxisXLabels: function(additions, totalChars, svg){
        svg.append("svg:text")
            .attr("text-anchor", "middle")
            .attr("font-size", "11")
            .attr("font-weight", "bold")
            .attr("fill", "#54B7E8")
            .attr("x", 890)
            .attr("y", 325)
            .text(totalChars)
            .attr("transform", "rotate(90 890 325)");
        svg.append("svg:text")
            .attr("text-anchor", "middle")
            .attr("font-size", "11")
            .attr("font-weight", "bold")
            .attr("fill", "#5d0082")
            .attr("x", 70)
            .attr("y", 325)
            .text(additions)
            .attr("transform", "rotate(270 70 325)");

    }
}