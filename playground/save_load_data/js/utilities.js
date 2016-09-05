var timeout = null, k=0;
var strings = [ "I'll eventually think of something cool to put here...", "can I help you?", 
				"you have a lot of time on your hands...", "okay, no more typing for you...", "go look at my comics!"];
var ski_val = 0, startedOnce = false;
				
var msg = ["Palin drōm: a word, phrase, or sequence that reads the same backward as forward...", "Type in a palindrome"];

$(document).ready(function() {	
		
	$("#headings div[id^=demo]").hide();
	$("#headings li[id^=heading]").hover(function () {
		var $menu = $(this).find('[id^=demo]');
		$menu.slideDown("fast");      
		$('[id^=demo]').not($menu).slideUp("fast");
		
		if ($("#demo_palindrome").is(":visible")) {
			$("#textBox").focus();
			if (timeout == null) {
				simulateTyping(0);
				if (k == msg.length-1) k=0; else k++;
			}
		}
		else {
			stopTimeout();
			document.getElementById("typing").innerHTML = "";
			document.getElementById("textBox").value = "";
			document.getElementById("response").innerHTML = "";
		}
		
		if ($("#demo_askii").is(":visible")) {
			startedOnce = true;
			if (ski_val === 0) {
				console.log("started");
				start(ski_val);
			}

		}
		else {
			if (startedOnce) {
				clearInterval(myInterval);
				myInterval = null;
				reset();
				console.log("reset me");
				ski_val = 0;
			}
		}
			
	});
	
});

function simulateTyping (i) {
	timeout = setTimeout(function () {
		document.getElementById("typing").innerHTML = document.getElementById("typing").innerHTML + msg[k].charAt(i);
		if (i < msg[k].length) simulateTyping(++i);			
	}, 60);	
}

function stopTimeout() {
    if (timeout != null) {
        clearTimeout(timeout);
        timeout = null;
    }
}