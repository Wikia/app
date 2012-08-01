/*global d3:true*/
var VisualStatsIndexContent = {
    init: function(parameter, data, dates){
        $('#' + parameter).addClass("selected");
        switch (parameter){
            case "commit":
                this.drawCommitActivity(data,dates);
                break;

        }
    },
    drawCommitActivity: function(data, dates){
        this.createSvgContainer(1000,1000,"#Graphic");



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
