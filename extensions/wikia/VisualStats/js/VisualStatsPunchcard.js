/*global d3:true*/
var VisualStatsPunchcard = {
    init: function(data, user, color){

        this.wikiaPunchcardData = data.wikiaPunchcard.data;
        this.wikiaPunchcardMax = data.wikiaPunchcard.max;
        this.userPunchcardData = data.userPunchcard.data;
        this.userPunchcardMax = data.userPunchcard.max;
        this.user = user;
        this.color = color;

        this.scale = d3.scale.linear()
            .range([5, 30]);
        $("#Graph").css('padding', '20px');

        this.setDates();
        this.setWikiaData();
        this.triggerButtons();

    },

    setWikiaData: function(){
        var dateIndex = 1;
        var self = this;
        this.scale.domain([0, self.wikiaPunchcardMax]);

        $.each(this.wikiaPunchcardData, function(date, hourset){
            $.each(hourset, function(hour, value){
                var object = $("#day" + dateIndex + "hour" + hour);
                var strDate = "#day" + dateIndex;
                var strHour = "#hour" + hour;
                if (value > 0){
                    self.setRadius(value, object);
                    object.mouseover(function(){
                        $(strDate).css('font-weight', 'bold').css('color', self.color).css('font-size', '13px');
                        $(strHour).css('font-weight', 'bold').css('color', self.color);
                    })
                    object.mouseout(function(){
                        $(strDate).css('font-weight', 'normal').css('color', 'black').css('font-size', '10px');
                        $(strHour).css('font-weight', 'normal').css('color', 'black');
                    })
                    object.attr("title", value);
                }
                else{
                    object.css('display', 'none');
                    object.mouseout(function(){});
                    object.mouseover(function(){});
                    object.removeAttr("title");
                }
            })
            dateIndex++;
        })
    },

    setUserData: function(){
        var dateIndex=1;
        var self = this;
        this.scale.domain([0, self.userPunchcardMax]);

        $.each(this.userPunchcardData, function(date, hourset){
            $.each(hourset, function(hour, value){
                var object = $("#day" + dateIndex + "hour" + hour);
                var strDate = "#day" + dateIndex;
                var strHour = "#hour" + hour;
                if (value > 0){
                    self.setRadius(value, object);
                    object.mouseover(function(){
                        $(strDate).css('font-weight', 'bold').css('color', self.color).css('font-size', '13px');
                        $(strHour).css('font-weight', 'bold').css('color', self.color);
                    })
                    object.mouseout(function(){
                        $(strDate).css('font-weight', 'normal').css('color', 'black').css('font-size', '10px');
                        $(strHour).css('font-weight', 'normal').css('color', 'black');
                    })
                    object.attr("title", value);
                }
                else{
                    object.css('display', 'none');
                    object.mouseout(function(){});
                    object.mouseover(function(){});
                    object.removeAttr("title");
                }
            })
            dateIndex++;
        })
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
                    self.setWikiaData();
                }, 1100);
            });
            $("#userButton").click(function(){
                $(this).removeClass("secondary");
                $("#wikiaButton").addClass("secondary");
                $(".circle").hide(1000);
                setTimeout(function(){
                    self.setUserData();
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