/*global d3:true*/
var VisualStatsPunchcard = {
    init: function(data, user, color, edits, edit){

        this.wikiaPunchcardData = data.wikiaPunchcard.data;
        this.wikiaPunchcardMax = data.wikiaPunchcard.max;
        this.wikiaPunchcardAll = data.wikiaPunchcard.all;

        this.userPunchcardData = data.userPunchcard.data;
        this.userPunchcardMax = data.userPunchcard.max;
        this.userPunchcardAll = data.userPunchcard.all;

        this.user = user;
        this.color = color;
        this.edits = edits;
        this.edit = edit;

        this.scale = d3.scale.linear()
            .range([5, 30]);
        $("#Graph").css('padding', '10px');

        this.setDates();
        this.setData("wikia");
        this.triggerButtons();

    },

    setData: function(attr){
        var dateIndex = 1;
        var self = this;
        var data;
        var max;

        if (attr=="wikia"){
            data = self.wikiaPunchcardData;
            max = self.wikiaPunchcardMax;
            $("#numberOfEdits").text(self.wikiaPunchcardAll);
        }
        else{
            data = self.userPunchcardData;
            max = self.userPunchcardMax;
            $("#numberOfEdits").text(self.userPunchcardAll);
        }

        this.scale.domain([0, max]);

        $.each(data, function(date, hourset){
            $.each(hourset, function(hour, value){
                var object = $("#day" + dateIndex + "hour" + hour);
                var strDate = "#day" + dateIndex;
                var strHour = "#hour" + hour;
                if (value > 0){
                    self.setRadius(value, object);
                    object.mouseover(function(){
                        $(strDate).css('font-weight', 'bold').css('color', self.color).css('font-size', '11px');
                        $(strHour).css('font-weight', 'bold').css('color', self.color);
                    });
                    object.mouseout(function(){
                        $(strDate).css('font-weight', 'normal').css('color', 'black').css('font-size', '10px');
                        $(strHour).css('font-weight', 'normal').css('color', 'black');
                    });
                    object.attr("title", function(){
                        if (value != 1){
                            return value + " " + self.edits;
                        }
                        else
                        {
                            return value + " " + self.edit;
                        }
                    });
                }
                else{
                    object.css('display', 'none');
                    object.mouseout(function(){});
                    object.mouseover(function(){});
                    object.removeAttr("title");
                }
            });
            dateIndex++;
        });
    },

    triggerButtons: function(){
        var self = this;
        if (this.user != "0"){
            $("#buttons").css('visibility', 'visible');
            $("#wikiaButton").click(function(){
                $(this).removeClass("secondary");
                $("#userButton").addClass("secondary");
                $(".circle").hide(1000);
                setTimeout(function(){
                    self.setData("wikia");
                }, 1100);
            });
            $("#userButton").click(function(){
                $(this).removeClass("secondary");
                $("#wikiaButton").addClass("secondary");
                $(".circle").hide(1000);
                setTimeout(function(){
                    self.setData("user");
                }, 1100);
            });
        }
    },

    setDates: function(){
            var i = 1;
            $.each(this.wikiaPunchcardData, function(date, hourset){
                $("#day" + i).text(date);
                i++;
            });
    },

    setRadius: function(count, object){
        var self = this;
        var result = Math.ceil(self.scale(count));
        object.css('width', result + 'px').css('height', result + 'px').css('display', 'inline-block');
    }

}