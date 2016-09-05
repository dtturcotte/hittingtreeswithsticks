
function start() {
	ski_val++;
	$('#skidiv').append("<span id='skier'>" + skier[1] + "</span>");
																   
	document.getElementById("skier").style.position="absolute";
	document.getElementById("skier").style.left="50%";
	document.getElementById("skier").style.top="20";                                     
	document.getElementById("skier").style.fontSize=jumpSize+"px";     
			   
	keyEvents();
		   
	myInterval = setInterval(function(){
		var skidiv = document.getElementById("skier");
		mstracker+=10;
		if (increaseSpeed > 0) {
			increaseSpeed--;
		}
		else {
			increaseSpeed = 20;
			speed++;
		}
	   
		if (spaceHit >0) {
			spaceHit--;
			if (spaceHit > 5)
				jumpSize++;
			else
				jumpSize--;

			skidiv.style.fontSize=jumpSize+"px";
			if (spaceHit == 1) {
				skidiv.innerHTML=skier[1];
				skidiv.style.fontSize="16px";
				jumpSize = 18;
				dir = "down";
			}
		}                                             
	   
		if (wait > 0) {
			if (wait == 1) {
				reset();
			}
			wait--;
		}
		else {
			if (generateItemTimer-- <= 0) {
				generateItemTimer = 4;
				objectFactory();
			}
			if (s > 0) {
				s--;
			}
			else {
				mstracker = 0;
				stracker++;
				s = 10;
			}             
			moveSpans();
		}
		time = stracker + ": " + mstracker;
		updateHUD();
	}, ms);
}

function updateHUD() {
	$(".time").html(time);
	$(".speed").html(speed);
	$(".falls").html(falls);
	$(".style").html(style);
}

function reset() {  
	console.log("reset");
	$(".lasttime").html(time);
	$(".lastspeed").html(speed);
	stracker = 0;
	mstracker = 0;
	time = 0;
	$("#myObstacles").empty();
	$("#skidiv").empty();
	$('#skidiv').append("<span id='skier'>" + skier[1] + "</span>");                                                                               
	document.getElementById("skier").style.position="absolute";
	document.getElementById("skier").style.left="50%";
	document.getElementById("skier").style.top="20";                     
	speed = 10;   
	style = 0;
	falls++;
	dir = "down";
}

function keyEvents() {
	$(document).keydown(function(e){                                    
		var key = e.keyCode, left = 37, right = 39, up = 38, down = 40;
		var playerVel = 15,
			skidiv = document.getElementById("skier");
	   
		//Movement
		if (key == right) {
			skidiv.innerHTML=skier[2];
			dir = "right";
		}
		if (key == left) {                               
			skidiv.innerHTML=skier[0];
			dir = "left";
		}                                                                             
		if (key == up) {
			skidiv.innerHTML=skier[3];
			dir = "up";
		}
		if (key == down) {
			skidiv.innerHTML=skier[1];
			dir = "down";
		}
});
}

function moveSpans() {
	$("#myObstacles span").each(function (index, val) {                                                   
		if (dir == "right") {
			$(val).css("top","-="+speed);    
			$(val).css("left","-=4");                
					   
		}
		else if (dir == "left") {
			$(val).css("top","-="+speed);    
			$(val).css("left","+=4");                                                                                               
		}
		else if (dir == "up") {
			speed = 7;
			$(val).css("top","-="+speed);                                                                    
		}
		else {
			$(val).css("top","-="+speed);                                                                    
		}             
		var skidiv = document.getElementById("skier");
		var skierCoords = $("#skier").position();
		var slopeCoords = $("#slope").position();
		var obstacleCoords = $(val).position();
		var distX = Math.abs(skierCoords.left - obstacleCoords.left);
		var distY = Math.abs(skierCoords.top - obstacleCoords.top);
		if ((distX < 20 && distY < 20)) {
			if (val.innerHTML == items[6]) {
				skidiv.innerHTML=skier[5];
				style+=speed*2;
				spaceHit = 10;
			}

			else if (spaceHit == 0) {
				  skidiv.innerHTML=skier[4];
					wait = 20;
			}
		}
		var slopeWidth=document.getElementById("slope").offsetWidth;

		if (obstacleCoords.top <= slopeCoords.top || obstacleCoords.left <= 0 || obstacleCoords.left >= slopeWidth-50) {
			$(val).remove();
		}                                                             
	});
}

function objectFactory() {

	var randObj = Math.floor((Math.random()*7)+1),
				randX = Math.floor((Math.random()*700)+1),
				randY = Math.floor((Math.random()*400)+1),
				height = document.getElementById("demo_askii").clientHeight;

	$('#myObstacles').append("<span id=\"" + randX + "\">" + items[randObj] + "</span>");

	console.log(height);
	document.getElementById(randX).style.position = "absolute";
	document.getElementById(randX).style.left = randX + "px";
	
	document.getElementById(randX).style.top = height + "px";

}

