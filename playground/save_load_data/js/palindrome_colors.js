var myInterval = null, myTimeout = null,
	container = [],
	i, j,
	set = false,
	firstLetter = "", varlastLetter = "",
	clickedPal = "";
			
$(document).ready(function(){
	$("#textBox").focus();
	$(document).click(function() {
		$("#textBox").focus();
	});
	
	$("#pal1").css({"color" : "blue"});
	$("#palOptions span[id^=pal]").click(function(event) {
		resetValues();
		clickedPal = event.target.id;
		$("#pal1, #pal2").css({"color" : "black"});
		$(this).css({"color" : "blue"});
	});
	
});

function resetValues() {
	clearTimeout(myTimeout);
	window.clearInterval(myInterval);
	$("#response").html("");
	$("#textBox").val('');
	$("#textBox").css({"color" : "black"});	
	$("#palindromeRun").html("");

}

function runPal(input) {
	if (clickedPal == "pal2") { pal2(input);}
	else { pal(input); }
}

function pal (input) {
	var str = input.replace(/\s/g, '');
	var str2 = str.replace(/\W/g, '');

	if (checkPal(str2, 0, str2.length-1)) {
		$("#textBox").css({"color" : "green"});
		$("#response").html(input + " is a palindrome");
	}
	else {
		$("#textBox").css({"color" : "red"});
		$("#response").html(input + " is not a palindrome");
	}
	if (input.length <= 0) {
		$("#response").html("");
		$("#textBox").css({"color" : "black"});
	}

}

function checkPal (input, i, j) {
	if (input.length <= 1) {
		return false;
	}
	if (i === j || ((j-i) == 1 && input.charAt(i) === input.charAt(j))) {
		return true;
	}
	else {
		if (input.charAt(i).toLowerCase() === input.charAt(j).toLowerCase()) {
			return checkPal(input, ++i, --j);
		}
		else {
			return false;
		}
	}                             
}


function pal2 (input) {
	var str = input.replace(/\s/g, '');
	var str2 = str.replace(/\W/g, '');
	$("#palindromeRun").html(input);
	//$("#textBox").css({"color" : "white"});
	$("#palindromeRun").lettering();
	
	clearTimeout(myTimeout);
	$("#response").html("");
	myTimeout = setTimeout(function() {
		if (set === false) {
			checkPal2(str2, 0, str2.length-1);
			set = true;
		}				
	}, 1000);
	
	if (input.length <= 0) {
		$("#response").html("");
	}

}

function checkPal2 (input, i, j) {
	var colors = ["CornflowerBlue", "LimeGreen", "Red",  "DarkOrange", "DarkOrchid", "purple", "Gold", "GreenYellow", "Fuchsia"];
	$("#palindromeRun span").each(function (i, v) {
		var str = v.innerHTML;
		str = str.trim(); 
		if (str !== "") { 
			container.push(v);		
		}				
	});
	myInterval = setInterval(function () {
		var rand = Math.floor((Math.random()*colors.length-1)+1);
		
		if (input.length === 1) {
			set = false;
			window.clearInterval(myInterval);
			container = [];					
			$("#response").html(input + " is not a palindrome");
		}
		
		else if (i === j || ((j-i) == 1 && input.charAt(i) === input.charAt(j))) {
			$(container[i], container[j]).css({"color": colors[rand]});
			$("#response").html(input + " is a palindrome");
			set = false;
			window.clearInterval(myInterval);
			container = [];
		}
		else {
			if (input.charAt(i).toLowerCase() === input.charAt(j).toLowerCase()) {
				$(container[i]).css({"color": colors[rand]});
				$(container[j]).css({"color": colors[rand]});
			}
			else {
				$(container[i]).css({"color": "red"});
				$(container[j]).css({"color": "blue"});
				$("#response").html(input + " is not a palindrome");
				set = false;
				window.clearInterval(myInterval);
				container = [];							
			}	
		}					
		i++; 
		j--; 	
	}, 1000);
}				