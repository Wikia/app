var VisualStatsCommon = {
    createSvgContainer: function(width, height, div){
        return d3.select(div)
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .attr("xmlns", "http://www.w3.org/2000/svg")
            .attr("version", "1.1");
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
    }

}