/*global d3:true*/
var VisualStatsIndexContent = {
    init: function(parameter, data, dates){
        this.wikiaCommit = data.wikiaCommit;
        this.userCommit = data.userCommit;
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
    roundUp: function(number){
        number+=12;
        number=Math.ceil(number/10)*10;
        return number;
    },
    drawCommitActivity: function(){
        var svg = this.createSvgContainer(1000,1000,"#Graph");
        var self = this;
        svg.append("svg:line")
            .attr("x1", 60)
            .attr("y1",600)
            .attr("x2", 900)
            .attr("y2",600)
            .attr("stroke", "green");
        svg.append("svg:line")
            .attr("x1", 60)
            .attr("y1",600)
            .attr("x2", 60)
            .attr("y2",100)
            .attr("stroke", "green");

        var wikiaMax = this.roundUp(this.wikiaCommit.max);
        var userMax = this.roundUp(this.userCommit.max);

        this.scaleY = d3.scale.linear()
            .domain([0, wikiaMax])
            .range([600, 100]);

        var scaleX = d3.scale.linear()
            .domain([0, 14])
            .range([120, 840]);
        var i = 0;
        var wikiaDataset= [];
        var userDataset= [];
        console.log(this.wikiaCommit.data);
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
        })
        i=0;
        $.each(this.userCommit.data, function(date, value){
            userDataset[i] = value;
            i++;
        })


        this.line = d3.svg.line()
            .x(function(d, i) { return scaleX(i); })
            .y(function(d) { return this.scaleY(d); })
            .interpolate("monotone");

        svg.append("path").attr("d", this.line(wikiaDataset))
            .style("stroke", "#248EA6")
            .style("fill", "none")
            .style("stroke-width", "3px");
        var curLabel;
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
                d3.select("#label" + i).attr("font-size", 13);
                d3.select("#date" + i).attr("font-size", 10).attr("fill", "red");
            })
            .on("mouseout", function(d,i){
                d3.select(this).attr("fill", "#42C5E3").attr("r", 4);
                d3.select("#label" + i).attr("font-size", 9);
                d3.select("#date" + i).attr("font-size", 8).attr("fill", "black");
            });

        svg.selectAll(".labels")
            .data(wikiaDataset)
            .enter()
            .append("svg:text")
            .attr("class", "labels")
            .attr("id", function(d,i){ return 'label' + i;})
            .attr("x", function(d, i) { return scaleX(i)-5; })
            .attr("y", function(d) { return self.scaleY(d)-5; })
            .text(function(d) { return d; })
            .attr("font-size", 9)
            .attr("text-anchor", "end");

        /*setTimeout(
        function(){self.updateCommitActivity(svg,[20,76,20,0,20,20,80,20,20,20,20,20,20,90,20], 100)}, 3000);
        setTimeout(
            function(){self.updateCommitActivity(svg,userDataset, userMax)}, 6000);
        setTimeout(
            function(){self.updateCommitActivity(svg,wikiaDataset, wikiaMax)}, 9000);*/
        svg.append("rect")
            .attr("id", "wikiaButton")
            .attr("x", 60)
            .attr("y", 650)
            .attr("width", 400)
            .attr("height", 60)
            .attr("fill", "#35F098")
            .on("click", function(){
                d3.select(this).attr("fill", "#35F098");
                d3.select("#userButton").attr("fill", "#C9D4CF");
                self.updateCommitActivity(svg,wikiaDataset, wikiaMax)
            });

        svg.append("rect")
            .attr("id", "userButton")
            .attr("x", 500)
            .attr("y", 650)
            .attr("width", 400)
            .attr("height", 60)
            .attr("fill", "#C9D4CF")
            .on("click", function(){
                d3.select(this).attr("fill", "#35F098");
                d3.select("#wikiaButton").attr("fill", "#C9D4CF");
                self.updateCommitActivity(svg,userDataset, userMax)
            });

    },
    updateCommitActivity: function(svg, dataToUpdate, max){
        //[20,20,20,20,20,20,20,20,20,20,20,20,20,20,20]
        this.scaleY.domain([0, max]);
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
