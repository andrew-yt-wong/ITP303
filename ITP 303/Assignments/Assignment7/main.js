updateWeather();

function updateWeather() {
	let savedCity = localStorage.getItem("city");
	if (savedCity)
		$("#city-id").val(savedCity);

	let city = $("#city-id").val();
	$.ajax({
		method: "GET",
		url: "https://api.weatherbit.io/v2.0/current?city=" + city + "&country=US&key=a123a918aaf5433f94b6de0418bccb8e&units=I"
	})
	.done(function(response) {
		// function gets run when we get a successful response back
		$("#weather-num").text(response.data[0].temp);
		$("#weather-desc").text(response.data[0].weather.description);
		$("#weather-app").text(response.data[0].app_temp);
	})
	.fail(function(response){
		console.log("Error!");
	});
}

$("#to-do-list").on("click", ".item", function() {
	if ($(this).css("color") == "rgb(255, 255, 255)") {
		$(this).parent().css({
			color: "indigo",
			fontStyle: "italic"
		});
		$(this).css("text-decoration", "line-through");
	}
	else {
 		$(this).parent().css({
			color: "white",
			fontStyle: "normal"
		});
		$(this).css("text-decoration", "none");
 	}
});

$("#to-do-list").on("click", ".box", function() {
	$(this).parent().fadeOut(300, function() {
		$(this).next().remove();
		$(this).remove();
	});
});

$("#city-id").on("change", function() {
	localStorage.setItem("city", $("#city-id").val());
	updateWeather();
});

$("#new-item").on("submit", function(event) {
	event.preventDefault();
	item = $("#the-item").val();
	$("#to-do-list").append("<li><span class=\"box\"><i class=\"far fa-square\"></i></span> <span class=\"item\">" + item + "</span></li><hr/>");
});

$(".plus").on("click", function() {
	$("#new-item").slideToggle(300);
});

$("#to-do-list").on("mouseenter", "li", function() {
	$(this).css("background-color", "cadetblue");
});

$("#to-do-list").on("mouseleave", "li", function() {
	$(this).css("background-color", "mediumslateblue");
});