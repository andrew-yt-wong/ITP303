$.ajax({
	method: "GET",
	url: "https://api.weatherbit.io/v2.0/current?city=Los%20Angeles&country=US&state=California&key=a123a918aaf5433f94b6de0418bccb8e&units=I"
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