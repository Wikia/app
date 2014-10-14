/*global d3:true*/
var WikiMapIndexContent = {
    init: function(colour, res, categories, ns){
        if (ns!= -1){
            this.modifier = 0.68;
        }
        else{
            this.modifier = 1;
        }
            this.buildMap(colour, res);
            this.buildCategoriesContainer(colour, categories);
            this.triggerAnimation(res.length, colour);
    },

    triggerAnimation: function(length, colour){
        this.actNumber = 0;
        var self = this;
        $("#animationCheckbox").click(function(){
            if($(this).attr('checked')){
                self.initAnimate(length, colour);
            }
            else
            {
                self.stopAnimation(colour);
            }
        });
    },

    initAnimate: function(length, colour){
        var self = this;

        self.interval = setInterval(function(){
            var labelName = "label" + self.actNumber;
            self.actObj = document.getElementById(labelName);
            self.onMouseOut(self.actObj, self.actNumber, colour);
            self.actNumber++;
            if (self.actNumber == length){
                self.actNumber = 0;
            }
            labelName = "label" + self.actNumber;
            self.actObj = document.getElementById(labelName);
            self.onMouseOver(self.actObj, self.actNumber);
        }, 750);
    },

    stopAnimation: function(colour){
        var self = this;
            clearInterval(self.interval);
            self.onMouseOut(self.actObj, self.actNumber, colour);
    },

    buildMap: function(colour, data){
        var self = this;
        this.nodes = data.nodes;
        var max = data.max;
        var svg = this.createSvgContainer(980 * this.modifier, 1000 * this.modifier, "#wikiMap");

        //Declaring variables needed to draw
        //rotationByOne - measured in degrees
        var rotationByOne = 360 / (data.length);
        var angleRadian;
        var rot = 270;
        var halfNodes = parseInt(data.length / 2);
        var points = [];
        this.transparencyByOne = 0.5/max;
        this.textColor = $.xcolor.darken(colour.labels);
        this.highlighted = $.xcolor.green(colour.line);
        this.chosen = $.xcolor.red(colour.line);

        //Drawing text labels
        $.each(this.nodes, function (index, value) {

                if (index == halfNodes) {
                    rot = 90;
                }
                //angleRadian - measured in radians
                var path = wgArticlePath;
                angleRadian = ((180 - rotationByOne * index) % 360) * Math.PI / 180;
                var attrX = 490 * self.modifier + 250 * self.modifier * Math.sin(angleRadian);
                var attrY = 500 * self.modifier + 250 * self.modifier * Math.cos(angleRadian);
                var svga = svg
                    .append("a")
                    .attr("xlink:href", function()
                    {
                        return path.replace('$1', value.title.replace(/ /g, '_'));
                    }
                );
                svga.append("svg:text").
                    text(value.title)
                    .attr("font-style", value.connections.length == 0 ? "italic" : "normal")
                    .attr("id", "label" + index)
                    .attr("font-size", 11)
                    .attr("text-anchor", rot == 90 ? "end" : "start")
                    .attr("x", attrX)
                    .attr("y", attrY)
                    .attr("fill", function(){
                        return $.xcolor.opacity(colour.body, self.textColor, 0.5 + self.transparencyByOne * value.connections.length);
                    })
                    .on("mouseover", function(){
                        self.onMouseOver(this, index);
                    })
                    .on("mouseout", function(){
                        self.onMouseOut(this, index, colour);
                    })
                    .attr("transform", function () {
                        return "rotate(" + (rotationByOne * index + rot) % 360 + ", " + attrX + "," + attrY + ")";
                    }
                );

                //Creating array of points, where text labels are placed
                //Attributes X and Y are the same as attrX and attrY, but are drawn based on different radius
                var point = {
                    x: 490 * self.modifier + 246 * self.modifier * Math.sin(angleRadian),
                    y: 500 * self.modifier + 246 * self.modifier * Math.cos(angleRadian)
                };
                points.push(point);
            }
        );

        //End of drawing text labels

        //Drawing connections between nodes
        this.drawConnections(points, colour, svg);
    },

    onMouseOver: function(object, index){
        var self = this;

        d3.selection.prototype.moveToFront = function() {
            return this.each(function() {
                this.parentNode.appendChild(this);
            });
        };

        var elements = d3.selectAll(".from" + index)
            .moveToFront()
            .style("stroke", this.highlighted)
            .style("stroke-width", "3px");
        $.each(this.nodes[index].connections, function (ind, pt2) {
            d3.select("#label" + pt2)
                .attr("fill", self.highlighted);
        });
        d3.select(object)
            .attr("fill", this.chosen);
    },

    onMouseOut: function(object, index, colour){
        var self = this;

        d3.selectAll(".from" + index)
            .style("stroke", colour.line)
            .style("stroke-width", "1px");

        $.each(this.nodes[index].connections, function (ind, pt2) {
            d3.select("#label" + pt2)
                .attr("fill", function(){
                    return $.xcolor.opacity(colour.body,
                        self.textColor,
                        0.5 + self.transparencyByOne * self.nodes[pt2].connections.length);
                });
        });
        d3.select(object)
            .attr("fill", function(){
                return $.xcolor.opacity(colour.body,
                    self.textColor,
                    0.5 + self.transparencyByOne * self.nodes[index].connections.length);
            });
    },

    drawConnections: function(points, colour, svg){
        var self = this;
        $.each(this.nodes, function (index, value) {
            $.each(value.connections, function (ind, pt2) {
                svg.append("path").
                    attr("class", function(){
                        return "from" + index;
                    })
                    .attr("d", function(){
                        var str = 'M ' + points[index].x +' ' + points[index].y +' q ';
                        str+= 490 * self.modifier - points[index].x;
                        str+= ' ';
                        str+= 500 * self.modifier - points[index].y;
                        str+= ' ';
                        str+= points[pt2].x - points[index].x;
                        str+= ' ';
                        str+= points[pt2].y - points[index].y;
                        return str;
                    })
                    .style("stroke", colour.line)
                    .style("stroke-width", "1px")
                    .attr("fill", "none");
            });
        });
    },

    buildCategoriesContainer: function(colour, categories){
        var catSvg = this.createSvgContainer(980 * this.modifier, 100, "#categoriesContainer");
        var data = categories.data;
        var move = 920 * this.modifier/(categories.length+3);
        var i = 0;
        $.each(data, function(index, value){
            var path = wgArticlePath;
            var svga = catSvg.
                append("a").
                attr("xlink:href", function()
                {
                    return path.replace('$1', function(){
                        return "Special:wikiMap/" + value.titleNoSpaces;
                    });
                }
            );
            var attrX = i * move;
            svga.append("sgv:text")
                .attr("x", attrX)
                .attr("y", 90)
                .text(value.title)
                .attr("font-size", 12)
                .attr("fill", colour.labels)
                .attr("transform", "rotate(340, " + attrX + ",5)");
            i++;
        });
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
