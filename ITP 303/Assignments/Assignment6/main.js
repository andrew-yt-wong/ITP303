// Calls ajax on startup to display all of the currently playing movies
let startUpUrl = "https://api.themoviedb.org/3/movie/now_playing?api_key=2d0eb211cf097d1a893eb8ad49258c07&language=en-US&page=1";
let imagesUrl = "https://api.themoviedb.org/3/configuration?api_key=2d0eb211cf097d1a893eb8ad49258c07";
let imageUrl = "";
ajax(imagesUrl, displayImage);

// Requests from the DB API
function ajax(url, display) {
	let httpRequest = new XMLHttpRequest();

	httpRequest.open("GET", url);
	httpRequest.send();

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState == httpRequest.DONE) {
			if (httpRequest.status == 200) {
				display(httpRequest.responseText);
			}
			else {
				// There is some error
				console.log("AJAX Error!");
				console.log(httpRequest.status);
			}
		}
	}
}

// Returns a image string that is usable
function displayImage(responseText) {
	let images = JSON.parse(responseText);
	imageUrl = images.images.base_url + images.images.poster_sizes[6];
	ajax(startUpUrl, displayResults);
}

// Displays the results and updates the "showing" text
function displayResults(responseText) {
	let results = JSON.parse(responseText);
	let movies = document.querySelector("#movies");

	// Update showing text
	document.querySelector("#num-results-displayed").innerHTML = results.results.length;
	document.querySelector("#num-results").innerHTML = results.total_results;

	// Remove all current movies showing
	while (movies.hasChildNodes())
		movies.removeChild(movies.lastChild);

	// Check if we have results
	if (results.results.length == 0)
		movies.innerHTML = "No movies found.";

	// Create and append the movies
	for (let i = 0; i < results.results.length; ++i) {
		let movie = document.createElement("div");
		movie.classList.add("col-6");
		movie.classList.add("col-md-4");
		movie.classList.add("col-lg-3");

		let poster = document.createElement("div");
		poster.style.color = "white";
		poster.style.textAlign = "center";
		poster.style.position = "relative";
		poster.classList.add("font-weight-bold");

		let posterOverlay = document.createElement("div");
		posterOverlay.style.width = "100%";
		posterOverlay.style.height = "100%";
		posterOverlay.style.visibility = "hidden";
		posterOverlay.style.position = "absolute";
		posterOverlay.style.backgroundColor = "black";
		posterOverlay.style.opacity = "80%";
		
		let rating = document.createElement("div");
		rating.innerHTML = "Rating: " + results.results[i].vote_average;
		rating.classList.add("row-12");
		rating.style.padding = "5%";

		let voteCount = document.createElement("div");
		voteCount.innerHTML = "Voters: " + results.results[i].vote_count;
		voteCount.classList.add("row-12");
		voteCount.style.paddingBottom = "5%";

		let synopsis = document.createElement("div");
		let overview = results.results[i].overview;
		if (overview.length > 200) 
			overview = overview.slice(0, 200) + "...";
		synopsis.innerHTML = overview;
		synopsis.classList.add("row-12");
		synopsis.style.padding = "0 5%";

		posterOverlay.appendChild(rating);
		posterOverlay.appendChild(voteCount);
		posterOverlay.appendChild(synopsis);

		let posterImage = document.createElement("img");
		if (results.results[i].poster_path == null)
			posterImage.src = "images/noimage.jfif";
		else
			posterImage.src = imageUrl + results.results[i].poster_path;
		posterImage.style.width = "100%";
		posterImage.classList.add("row-12");

		poster.appendChild(posterOverlay);
		poster.appendChild(posterImage);

		poster.onmouseenter = function() {
			poster.firstChild.style.visibility = "visible";
		}

		poster.onmouseleave = function() {
			poster.firstChild.style.visibility = "hidden";
		}

		let title = document.createElement("div");
		title.style.textAlign = "center";
		title.innerHTML = results.results[i].title;
		title.classList.add("row-12");

		let release = document.createElement("div");
		release.style.textAlign = "center";
		release.innerHTML = results.results[i].release_date;
		release.classList.add("row-12");

		movie.appendChild(poster);
		movie.appendChild(title);
		movie.appendChild(release);

		movies.appendChild(movie);
	}
}

// Checks if we need to research
document.querySelector("#search-form").onsubmit = function(event) {
	// Don't actually submit this form, we're creating a single page app!
	event.preventDefault();

	let searchInput = document.querySelector("#search-id").value.trim();

	let url = "https://api.themoviedb.org/3/search/movie?api_key=2d0eb211cf097d1a893eb8ad49258c07&language=en-US&query=" + searchInput + "&page=1&include_adult=false";

	if (searchInput != "")
		ajax(url, displayResults);
}