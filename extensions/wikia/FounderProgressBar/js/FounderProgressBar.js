var FounderProgressList = {
	isHidden: true,
	hoverHandle: false,
	init: function() {
		FounderProgressList.d = $('#FounderProgressList');
		FounderProgressList.allActivities = FounderProgressList.d.find('.activity');
		
		FounderProgressList.allActivities.hover(function() {
			clearTimeout(FounderProgressList.hoverHandle);
			var el = $(this).find('.activity-description');
			FounderProgressList.hoverHandle = setTimeout(function() {
				el.show();
			}, 400);
		}, function() {
			clearTimeout(FounderProgressList.hoverHandle);
			$(this).find('.activity-description').fadeOut(200);
		});
		
		$('#FounderProgressListToggle').click(function(e) {
			e.preventDefault();
			if(FounderProgressList.isHidden) {
				FounderProgressList.d.show();
			} else {
				FounderProgressList.d.hide();
			}
			FounderProgressList.isHidden = !FounderProgressList.isHidden;
		});
	}
}

var FounderProgressWidget = {
	widget: false,
	init: function() {
		// pre-cache dom
		FounderProgressWidget.widget = $('#FounderProgressWidget');
		FounderProgressWidget.allActivityPreviews = FounderProgressWidget.widget.find('.preview .activities .activity');
		FounderProgressWidget.allActivityPreviewDescriptions = FounderProgressWidget.widget.find('.preview .activities .activity .description');
		
		// events
		FounderProgressWidget.allActivityPreviews.find('.label').click(FounderProgressWidget.handleActivityPreview);
	},
	handleActivityPreview: function() {
		var el = $(this);
		FounderProgressWidget.allActivityPreviews.removeClass('active');
		var desc = el.closest('.activity').addClass('active').find('.description');
		FounderProgressWidget.allActivityPreviewDescriptions.not(desc).slideUp(120, 'linear');//.animate({'height':'hide'}, 400);
		desc.slideDown(120, 'linear');//.animate({'height':'show'}, 400);
	}
};

var FounderProgressBar = {
	c: false,	// canvas 2d context
	innerRadius: 30,
	outerRadius: 45,
	separation: 5,
	init: function() {
		FounderProgressBar.canvas = document.getElementById('FounderProgressBar');
		FounderProgressBar.c = FounderProgressBar.canvas.getContext('2d');
		FounderProgressBar.drawAnimated(68);
		//FounderProgressBar.draw(90);
	},
	draw: function(score) {
		FounderProgressBar.score = score;
		FounderProgressBar.sections = FounderProgressBar.score / 25;
		FounderProgressBar.drawBackground();
	},
	drawBackground: function() {
		var c = FounderProgressBar.c;
		c.clearRect(0, 0, 95, 95);
		c.save();
		FounderProgressBar.drawSlice();
		c.restore();
		c.save();
		c.rotate(Math.PI/2);
		c.translate(0, -((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation));
		FounderProgressBar.drawSlice();
		c.restore();
		c.save();
		c.rotate(Math.PI);
		c.translate(-((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation), -((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation));
		FounderProgressBar.drawSlice();
		c.restore();
		c.save();
		c.rotate(Math.PI * 1.5);
		c.translate(-((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation), 0);
		FounderProgressBar.drawSlice();
		c.restore();
	},
	drawSlice: function() {
		var c = FounderProgressBar.c;
		var centerX = FounderProgressBar.outerRadius + FounderProgressBar.separation;
		var centerY = FounderProgressBar.outerRadius;
		c.fillStyle = FounderProgressBar.sections-- > 1 ? "#6aa8d1" : "#e6e6e6";
		c.moveTo(FounderProgressBar.outerRadius + FounderProgressBar.separation, FounderProgressBar.outerRadius - FounderProgressBar.innerRadius);
		c.beginPath();
		c.lineTo(FounderProgressBar.outerRadius + FounderProgressBar.separation, 0);
		c.arc(centerX, centerY, FounderProgressBar.outerRadius, Math.PI * 1.5, Math.PI * 2, false);
		c.lineTo(centerX - FounderProgressBar.innerRadius, centerY);
		c.arc(centerX, centerY, FounderProgressBar.innerRadius, Math.PI * 2, Math.PI * 1.5, true);
		c.closePath();
		c.fill();
		if (FounderProgressBar.sections > -1 && FounderProgressBar.sections <= 0) {
			FounderProgressBar.drawPercentage();
		}
	},
	drawPercentage: function() {
		var c = FounderProgressBar.c;
		var centerX = FounderProgressBar.outerRadius + FounderProgressBar.separation;
		var centerY = FounderProgressBar.outerRadius;
		var p = 1 + FounderProgressBar.sections;
		c.fillStyle = "#6aa8d1";
		c.moveTo(FounderProgressBar.outerRadius + FounderProgressBar.separation, FounderProgressBar.outerRadius - FounderProgressBar.innerRadius);
		c.beginPath();
		c.lineTo(FounderProgressBar.outerRadius + FounderProgressBar.separation, 0);
		var arc = (0.5 * p);
		c.arc(centerX, centerY, FounderProgressBar.outerRadius, Math.PI * 1.5, Math.PI * (1.5 + arc), false);
		var y = centerY - (Math.cos(Math.PI * arc) * FounderProgressBar.innerRadius);
		var x = centerX + (Math.sin(Math.PI * arc) * FounderProgressBar.innerRadius);
		c.lineTo(x, y);
		c.arc(centerX, centerY, FounderProgressBar.innerRadius, Math.PI * (1.5 + arc), Math.PI * 1.5, true);
		c.closePath();
		c.fill();
	},
	drawAnimated: function(finalScore) {
		var score = 0;
		var i = setInterval(function() {
			if(score > finalScore) {
				clearInterval(i);
			} else {
				FounderProgressBar.draw(score);
			}
			score++;
		}, 13);
	}
};
$(function() {
	FounderProgressList.init();
	FounderProgressWidget.init();
	FounderProgressBar.init();
});