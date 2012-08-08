/*global d3:true*/
var VisualStatsCommitActivity = {
    init: function(data, user){
        this.wikiaCommit = data.wikiaCommit;
        this.userCommit = data.userCommit;
        this.user = user;

        this.drawCommitActivity();

    },

    roundUp: function(number){
        number+= 12;
        number = Math.ceil(number / 10) * 10;
        return number;
    },

    drawAxis: function(svg){
        svg.append("svg:line")
            .attr("x1", 60).attr("y1", 600)
            .attr("x2", 920).attr("y2", 600)
            .attr("stroke", "green");
        svg.append("svg:line")
            .attr("x1", 60).attr("y1", 600)
            .attr("x2", 60).attr("y2", 50)
            .attr("stroke", "green");
        svg.append("svg:line")
            .attr("x1", 60).attr("y1", 350)
            .attr("x2", 920).attr("y2", 350)
            .style("stroke-width", "0.5px")
            .attr("stroke", "green");
        svg.append("svg:line")
            .attr("x1", 60).attr("y1", 100)
            .attr("x2", 920).attr("y2", 100)
            .style("stroke-width", "0.5px")
            .attr("stroke", "green");
    },

    drawCommitActivity: function(){
        var svg = VisualStatsCommon.createSvgContainer(980, 650, "#Graph");
        var self = this;
        var wikiaMax = this.roundUp(this.wikiaCommit.max);
        var userMax = this.roundUp(this.userCommit.max);

        svg.append("rect")
            .attr("x", 20)
            .attr("y", 45)
            .attr("width", 940)
            .attr("height", 600)
            .attr("fill", "#E4EDD3");

        this.drawAxis(svg);

        this.scaleY = d3.scale.linear()
            .domain([0, wikiaMax])
            .range([600, 100]);

        var scaleX = d3.scale.linear()
            .domain([0, 14])
            .range([120, 860]);
        var i = 0;
        var wikiaDataset= [];
        var userDataset= [];
        $.each(this.wikiaCommit.data, function(date, value){
            svg.append("svg:text")
                .attr("x", scaleX(i))
                .attr("y", 620)
                .text(date)
                .attr("id", function(){return "date" + i;})
                .attr("font-size", 8)
                .attr("fill", "black")
                .attr("text-anchor", "middle");
            wikiaDataset[i] = value;
            i++;
        });

        i = 0;
        $.each(this.userCommit.data, function(date, value){
            userDataset[i] = value;
            i++;
        });

        if (this.user != "0"){
            $("#buttons").css('visibility', 'visible');
            $("#wikiaButton").click(function(){
                $(this).removeClass("secondary");
                $("#userButton").addClass("secondary");
                self.updateCommitActivity(svg, wikiaDataset, wikiaMax);
            });
            $("#userButton").click(function(){
                $(this).removeClass("secondary");
                $("#wikiaButton").addClass("secondary");
                self.updateCommitActivity(svg, userDataset, userMax);
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
                d3.select("#date" + i).attr("font-size", 10).attr("fill", "red").attr("font-weight", "bold");
            })
            .on("mouseout", function(d,i){
                d3.select(this).attr("fill", "#42C5E3").attr("r", 4);
                d3.select("#label" + i).attr("font-size", 9).attr("font-weight", "normal");
                d3.select("#date" + i).attr("font-size", 8).attr("fill", "black").attr("font-weight", "normal");
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

    updateCommitActivity: function(svg, dataToUpdate, max){
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
