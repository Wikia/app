var FounderProgressList = {
	isHidden: true,
	hoverHandle: false,
	init: function() {
		FounderProgressList.d = $('#FounderProgressList');
		FounderProgressList.article = $('#WikiaArticle');
		FounderProgressList.skippedTaskGroup = FounderProgressList.d.find('.tasks .task.skipped');
		FounderProgressList.bonusTaskGroup = FounderProgressList.d.find('.tasks .task.bonus');
		FounderProgressList.article.after(FounderProgressList.d);
		FounderProgressList.allActivities = FounderProgressList.d.find('.activity');
		FounderProgressList.seeFullList = $('#FounderProgressListToggle .see-full-list');
		FounderProgressList.hideFullList = $('#FounderProgressListToggle .hide-full-list');
		FounderProgressList.trackedActivities = FounderProgressList.d.find('.clickevent');
		FounderProgressList.tailColorMain = FounderProgressList.d.find('>header').css('backgroundColor');
		FounderProgressList.tailColorActivity = FounderProgressList.allActivities.find('.actions').css('backgroundColor');
		FounderProgressList.tailColorShadow = FounderProgressList.d.find('.shadowColorContainer').css('backgroundColor');

		FounderProgressList.allActivities.hover(FounderProgressList.showActivity, FounderProgressList.hideActivity);

		$('#FounderProgressListToggle, #FounderProgressListClickArea').click(function(e) {
			e.preventDefault();
			if(FounderProgressList.isHidden) {
				FounderProgressList.showListModal();
			} else {
				FounderProgressList.hideListModal();
			}
		});

		FounderProgressList.d.find('nav .back-to-dash').click(FounderProgressList.hideListModal);

		FounderProgressList.d.find(".task .task-label").click(function() {
			var el = $(this).closest(".task");
			var group = el.find('.task-group');
			if(group.is(':visible')) {
				FounderProgressList.collapseTask(el);
			} else {
				FounderProgressList.expandTask(el);
			}
		});

		FounderProgressList.trackedActivities.find('.actions .wikia-button').click(FounderProgressList.trackActivity);
		FounderProgressList.allActivities.find('.actions .skip').click(FounderProgressList.skipActivity);
	},
	showListModal: function() {
		FounderProgressList.isHidden = false;
		FounderProgressList.seeFullList.hide();
		FounderProgressList.hideFullList.show();
		FounderProgressList.d.show();
		FounderProgressList.article.hide();
		FounderProgressList.drawMainTail();
	},
	hideListModal: function() {
		FounderProgressList.isHidden = true;
		FounderProgressList.seeFullList.show();
		FounderProgressList.hideFullList.hide();
		FounderProgressList.d.hide();
		FounderProgressList.article.show();
	},
	collapseTask: function(task) {
		var group = task.find('.task-group');
		task.removeClass('expanded').addClass('collapsed');
		group.slideUp(200);
	},
	expandTask: function(task) {
		var group = task.find('.task-group');
		task.removeClass('collapsed').addClass('expanded');
		group.slideDown(200);
	},
	trackActivity: function(e) {
		e.preventDefault();
		var el = $(this);
		var url = el.attr('href');
		var taskId = el.closest('.activity').data('task-id');
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'FounderProgressBar',
			method: 'doTask',
			format: 'json',
			task_id: taskId
		}, function(res) {
			window.location.href = url;
		});
	},
	skipActivity: function(e) {
		e.preventDefault();
		var el = $(this);
		var activity = el.closest('.activity');
		var taskId = activity.data('task-id');
		activity.find('.activity-description').hide();
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'FounderProgressBar',
			method: 'skipTask',
			format: 'json',
			task_id: taskId
		}, function(res) {
			if(res['result'] && res.result == 'OK') {
				var activityInPreview = $('#FounderProgressWidget .preview .activity[data-task-id=' + taskId + ']');
				FounderProgressList.moveToSkipped(activity);
				if(activityInPreview.length) {
					FounderProgressWidget.hideActivity(activityInPreview, function() {
						FounderProgressWidget.getNextTask(activityInPreview);
					});
				}
				if(res['bonus_tasks_unlocked']) {
					FounderProgressList.showBonusActivities();
				}
			}
		});
	},
	moveToSkipped: function(activity) {
		FounderProgressList.skippedTaskGroup.slideDown(200);
		var skippedActivities = FounderProgressList.skippedTaskGroup.find('.activity');
		var columnIndex = (skippedActivities.length % 3) + 1;
		activity.hide(600, function() {
			FounderProgressList.expandTask(FounderProgressList.skippedTaskGroup);
			activity.appendTo(FounderProgressList.skippedTaskGroup.find('ul:nth-child('+columnIndex+')')).hide().show(600);
		});
	},
	showBonusActivities: function() {
		FounderProgressList.bonusTaskGroup.find('.activity').removeClass('locked');
		FounderProgressList.expandTask(FounderProgressList.bonusTaskGroup);
	},
	showActivity: function(e) {
		clearTimeout(FounderProgressList.hoverHandle);
		var el = $(this).find('.activity-description');
		FounderProgressList.hoverHandle = setTimeout(function() {
			el.show();
			FounderProgressList.drawActivityTail(el);
		}, 400);
	},
	hideActivity: function(e) {
		clearTimeout(FounderProgressList.hoverHandle);
		$(this).find('.activity-description').fadeOut(200);
	},
	drawMainTail: function() {
		var el = FounderProgressList.d.find('>.tail');
		if(!el.data('drawn')){
			var c = (el[0]).getContext('2d');
			c.fillStyle = FounderProgressList.tailColorMain;
			c.shadowOffsetX = 2;
			c.shadowOffsetY = 0;
			c.shadowBlur = 5;
			c.shadowColor = FounderProgressList.tailColorShadow;
			c.moveTo(0, 0);
			c.lineTo(20, 20);
			c.lineTo(0, 40);
			c.lineTo(0, 0);
			c.fill();
			c.closePath();
			el.data('drawn', true);
		}
	},
	drawActivityTail: function(activity) {
		var el = activity.find('.tail');
		if(!el.data('drawn')){
			var c = (el[0]).getContext('2d');
			c.fillStyle = FounderProgressList.tailColorActivity;
			c.shadowOffsetX = 0;
			c.shadowOffsetY = 2;
			c.shadowBlur = 5;
			c.shadowColor = FounderProgressList.tailColorShadow;
			c.moveTo(0, 0);
			c.lineTo(10, 10);
			c.lineTo(20, 0);
			c.lineTo(0, 0);
			c.fill();
			c.closePath();
			el.data('drawn', true);
		}
	}
}

var FounderProgressWidget = {
	widget: false,
	init: function() {
		// pre-cache dom
		FounderProgressWidget.widget = $('#FounderProgressWidget');
		FounderProgressWidget.preview = FounderProgressWidget.widget.find('.preview');

		// events
		FounderProgressWidget.preview.on('click', '.label', FounderProgressWidget.handleActivityPreview);
		FounderProgressWidget.preview.on('click', '.clickevent .actions .wikia-button', FounderProgressList.trackActivity);
		FounderProgressWidget.preview.on('click', '.actions .skip', FounderProgressWidget.skipActivity);
		FounderProgressWidget.preview.find('.completion-message .close').click(function() {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'FounderProgressBar',
				method: 'skipTask',
				format: 'json',
				task_id: 1000
			}, function(res) {
				if(res['result'] && res.result == 'OK') {
					FounderProgressWidget.preview.find('.completion-message').slideUp(400);
				}
			});
		});
	},
	handleActivityPreview: function() {
		var el = $(this);
		$('#FounderProgressWidget .preview .activity').removeClass('active');
		var desc = el.closest('.activity').addClass('active').find('.description');
		$('#FounderProgressWidget .preview .description').not(desc).slideUp(120, 'linear');//.animate({'height':'hide'}, 400);
		desc.slideDown(120, 'linear');
	},
	skipActivity: function(e) {
		e.preventDefault();

		var el = $(this);
		var activity = el.closest('.activity');
		var taskId = activity.data('task-id');
		var activityInList = $('#FounderProgressList .activity[data-task-id=' + taskId + ']');
		FounderProgressWidget.hideActivity(activity, function() {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'FounderProgressBar',
				method: 'skipTask',
				format: 'json',
				task_id: taskId
			}, function(res) {
				FounderProgressList.moveToSkipped(activityInList);
				if(res['result'] && res.result == 'OK') {
					FounderProgressWidget.getNextTask(activity);
				}
				if(res['bonus_tasks_unlocked']) {
					FounderProgressList.showBonusActivities();
				}
			});
		});

	},
	hideActivity: function(activity, callback) {
		activity.slideUp(400, callback);
	},
	getNextTask: function(activity) {
		var excludedTaskId = $('#FounderProgressWidget .preview .activity').not(activity).data('task-id');
		$().log('excluded:' + excludedTaskId);
		activity.remove();
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'FounderProgressBar',
			method: 'getNextTask',
			format: 'json',
			excluded_task_id: excludedTaskId
		}, function(res) {
			var html = '';
			var existingActivity = FounderProgressWidget.preview.find('.activity');
			if(res && res.html) {
				html = $(res.html);
				FounderProgressWidget.preview.find('.activities').append(html);
			}
			existingActivity.addClass('active').find('.description').slideDown(120, 'linear');
			if(html) {
				html.slideDown();
			}

		});
	}
};

var FounderProgressBar = {
	c: false,	// canvas 2d context
	innerRadius: 30,
	outerRadius: 45,
	separation: 5,
	score: 0,
	init: function() {
		FounderProgressBar.score = parseInt($('#FounderProgressWidget .numeric-progress .score').text());
		if(Modernizr.canvas) {
			FounderProgressBar.c = document.getElementById('FounderProgressBar').getContext('2d');
			FounderProgressBar.drawAnimated(FounderProgressBar.score);
		} else {
			var retry = 0;
			var iHook = setInterval(function() {
				try {
					FounderProgressBar.c = document.getElementById('FounderProgressBar').getContext('2d');
					FounderProgressBar.draw(FounderProgressBar.score);
					clearInterval(iHook);
				} catch (e) {
					if(retry > 20) {
						clearInterval(iHook);
					}
				}
				retry++;
			}, 500);
		}
	},
	draw: function(score) {
		FounderProgressBar.score = score;
		FounderProgressBar.sections = FounderProgressBar.score / 25;
		FounderProgressBar.drawBackground();
	},
	drawBackground: function() {
		var c = FounderProgressBar.c;
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
		c.fillStyle = FounderProgressBar.sections-- > 1 ? sassParams['color-buttons'] : "rgba(0,0,0,.1)";
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
		c.fillStyle = sassParams['color-buttons'];
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
				FounderProgressBar.c.clearRect(0, 0, 95, 95);
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