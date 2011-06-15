var FounderProgressBar = {
	c: false,	// canvas 2d context
	innerRadius: 30,
	outerRadius: 45,
	separation: 5,
	init: function() {
		FounderProgressBar.canvas = document.getElementById('FounderProgressBar');
		FounderProgressBar.c = FounderProgressBar.canvas.getContext('2d');
		FounderProgressBar.drawBackground();
	},
	drawBackground: function() {
		var c = FounderProgressBar.c;
		FounderProgressBar.drawSlice();
		c.rotate(Math.PI/2);
		c.translate(0, -((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation));
		FounderProgressBar.drawSlice();
		c.restore();
		c.rotate(Math.PI);
		c.translate(-((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation), -((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation));
		FounderProgressBar.drawSlice();
		c.restore();
		c.rotate(Math.PI * 1.5);
		c.translate(-((FounderProgressBar.outerRadius * 2) + FounderProgressBar.separation), 0);
		FounderProgressBar.drawSlice();
		c.restore();
	},
	drawSlice: function() {
		var c = FounderProgressBar.c;
		c.fillStyle = "#e6e6e6";
		c.moveTo(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius - FounderProgressBar.innerRadius);
		c.beginPath();
		c.lineTo(FounderProgressBar.outerRadius, 0);
		c.arc(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, Math.PI * 1.5, Math.PI, true);
		c.lineTo(FounderProgressBar.outerRadius - FounderProgressBar.innerRadius, FounderProgressBar.outerRadius);
		c.arc(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, FounderProgressBar.innerRadius, Math.PI, Math.PI * 1.5, false);
		c.closePath();
		c.fill();
	},
	drawPercentage: function(percentage) {
		var c = FounderProgressBar.c;
		c.restore();
		c.fillStyle = "#6aa8d1";
		c.moveTo(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius - FounderProgressBar.innerRadius);
		c.beginPath();
		c.lineTo(FounderProgressBar.outerRadius, 0);
		c.arc(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, 0, Math.PI * 0.3, false);
		var y = Math.cos(Math.PI * 0.3) * FounderProgressBar.innerRadius;
		var x = Math.sin(Math.PI * 0.3) * FounderProgressBar.innerRadius;
		c.lineTo(x, y);
		c.arc(FounderProgressBar.outerRadius, FounderProgressBar.outerRadius, FounderProgressBar.innerRadius, Math.PI * 0.3, 0, true);
		c.closePath();
		c.fill();
	}
};

$(function() {
	FounderProgressBar.init();
});