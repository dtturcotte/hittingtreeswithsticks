

function getAngle (x1, y1, x2, y2) {
	var dY = Math.abs(y2-y1); //opposite
	var dX = Math.abs(x2-x1); //adjacent
	var dist = Math.sqrt((dY*dY)+(dX*dX)); //hypotenuse
	var sin = dY/dist; //opposite over hypotenuse
	var radians = Math.asin(sin);
	var degrees = radians*(180/Math.PI); //convert from radians to degrees
	angle = degrees;
	return degrees; //return angle in degrees
}

$(document).ready(function(){
		c=document.getElementById("myCanvas"),
		ctx=c.getContext("2d");
		drawAngles();
		
	$("canvas").mousemove(function(e) {					
		getDirection(e);
		if (!set) {
			x1 = e.pageX,
			y1 = e.pageY,
			t1 = new Date().getTime();
			set = true;
		}
		
		clearTimeout(thread);
		thread = setTimeout(callback.bind(this, e), 10);

	});
	
		
	//just animate this box to move at an angle from center down at 30 degrees
	$(".anotherBox").mouseenter(function(e) {
		pos =  $(this).position();
		box2X = pos.left;
		box2Y = pos.top;	
		if (animate) {
			$(this).animate({
				//top : $(window).outerHeight(),
				top : newY+"px",
				left: newX+"px",
			}, "slow");	
		}
		animate = false;
	});
	
	
	$(".miniBox").mouseenter(function(e) {
		
		pos =  $(this).position();
		miniX = pos.left;
		miniY = pos.top;				
							
		$(this).animate({
			//top : $(window).outerHeight(),
			top : ydir+(instantaneousVel*ballSpeed)+"px",
			left: xdir+(instantaneousVel*ballSpeed)+"px",
		}, "slow");		
		
		if (miniX <= 100) {
			$(this).position.left = 50;
		}
		if (miniX >= 600) {
			$(this).position.left = 50;
		}
	});
});

function calcNewLoc (x, y, xD, yD) {
	newX = x + (xD * Math.cos(angle));
	newY = y + (yD * Math.sin(angle));
	//newX = Math.floor(newX * 100)/100;
	//newY = Math.floor(newY * 100)/100;
	
}


function callback(e) {
	x2 = e.pageX;
	y2 = e.pageY;
	t2 = new Date().getTime();
	
	var xDist = x2 - x1,
		yDist = y2 - y1,
		time = t2 - t1;
	
	//to calc angle... need to get starting position and ending position
	$(".angle").html("ANGLE: " + getAngle(x1, y1, x2, y2));
				
	calcNewLoc(x1, y1, xDist, yDist);
	
	animate = true;										
	
	instantaneousVel = Math.abs(xDist/time);	
	instantaneousVel+=1;
	log("mouse has stopped : " + instantaneousVel);	
	set = false;
}

function drawAngles () {
	var d = 50; //start line at (10, 20), move 50px away at angle of 30 degrees
	var angle = 80 * Math.PI/180;
	ctx.beginPath();
	ctx.moveTo(300,0);
	ctx.lineTo(300,600); //x, y
	ctx.moveTo(0,300);
	ctx.lineTo(600,300);
	ctx.arc(300,300,300,0,2*Math.PI);
	ctx.stroke();
}
			
function getDirection (event) {
	if (event.pageX < mX) {
		xdir = "+=";
		//log('From Left');
	} 
	else {
		xdir = "-=";
		//log('From Right');
	}		
	if (event.pageY < mY) {
		ydir = "-=";
		//log('From top');
	}
	else {
		ydir = "+=";
		//log('From bottom');
	}
	mX = event.pageX;
	mY = event.pageY;				
}			

function log (val) {
	console.log(val);
}