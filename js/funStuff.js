var stuff = [],
	imgs = [],
	mY = 0,
	mX = 0,
	dir = "",
	vel = 0,
	isRunning = false,
	direction = "right",
	string = "Comics",
	oldIE = false;

(function ($) {
	"use strict";
	// Detecting IE
	if ($('html').is('.ie6, .ie7, .ie8')) {
		log("true");
		oldIE = true;
	}
	else {
		log("false");
	}
}(jQuery));

//t = Date.now();
function getVelocity (event) {
	isRunning = true;
	var currX = event.clientX,
		currY = event.clientY,
		startTime = new Date().getTime(),
		dist = 0;
	var endTime = new Date().getTime();
	var time = endTime - startTime;
}


$(document).ready(function(){
	$('body').mousemove(function(e) {

		if (isRunning == false) {
			getVelocity(e);
			isRunning = false;
		}

		if (e.pageX < mX) {
			direction = "left";
			dir = "-=";
		} else {
			direction = "right";
			dir = "+=";
		}
		mX = e.pageX;
	});


	var thread;
	var timeout = 100;
	$('body').mousemove(function(event) {
		//log("mouse move");
		clearTimeout(thread);
		thread=setTimeout(mousestopped, timeout);
	});
	/*$('body').mousestop(function(event) {

	 });*/
	function mousestopped() {
		//log("mouse has stopped");
	}

	for (var i = 0; i < stuff.length-1; i++) {
		imgs.push(new Image());
		imgs[i].src = stuff[i];
	}

	$(".title").lettering();

	$("h3 span").mouseenter(function () {
		var speed=300;
		var colors = ["White"],
			rand = Math.floor((Math.random()*colors.length-1)+1),
			letter = $(this).clone(),
			parent = $(this).parent(),
			val = $(this);

		var mY = 0;
		parent.append(letter);

		letter.css({
			"color" : "black",
			"position": "absolute",
			"letter-spacing" : "0.9em",
			"left": $(this).position().left,
			"top": parent.height()-30
		});
		//myspan.animate({"top": $(window).outerHeight()}, 9000, "linear", function() {
		letter.animate({
			//top : $(window).outerHeight(),
			top : 600,
			opacity: "toggle",
			height: [ "toggle"],
			margin: "0.5in",
			borderLeftWidth: "15px",
			fontSize: "5px",
			width: "50%",
			left: dir+speed+"px",
			//width: "50%"
		}, {
			duration: 5000,
			specialEasing: {
				width: "linear",
				height: "easeOutBounce"
			},
			complete: function() {
				$(this).remove();
			}

		});

		if (oldIE) {
			val.css({filter: alpha(opacity=0)});
		} else {
			val.css({"opacity" : 0});
		}
		setTimeout(function() {
			if (oldIE) {
				val.css({filter: alpha(opacity=100)});
			} else {
				val.css({"opacity" : 100});
			}
		},2000);
	});

});

function log (val) {
	console.log(val);
}
