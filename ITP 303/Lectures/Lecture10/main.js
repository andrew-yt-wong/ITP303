
function displayResults(responseText) {
	console.log(responseText);

	// Convert JSON string into JS object
	let response = JSON.parse(responseText);
	console.log(response);

	// Because response is now an objects, I can grab any piece of information I want using the key (aka property) and using dot notation
	console.log(response.results[0].artistName);

	// Remove all the existing results
	// .hasChildNodes() - returns true or false
	// .removeChld() - removes one child element
	let tbody = document.querySelector("tbody");
	while (tbody.hasChildNodes())
		tbody.removeChild(tbody.lastChild);

	// Create a <tr> tag for each of the results!
	for (let i = 0; i < response.results.length; ++i) {
		let trTag = document.createElement("tr");
		// Create five <td> tags that will go INSIDE the <tr> tag
		let imgTdTag = document.createElement("td");
		let imgTag = document.createElement("img");
		imgTag.src = response.results[i].artworkUrl100;
		// Aped <img> to <td>
		imgTdTag.appendChild(imgTag);

		let artistTdTag = document.createElement("td");
		artistTdTag.innerHTML = response.results[i].artistName;

		let trackTdTag = document.createElement("td");
		trackTdTag.innerHTML = response.results[i].trackName;

		let albumTdTag = document.createElement("td");
		albumTdTag.innerHTML = response.results[i].collectionName;

		// Preview audio
		let audioTdTag = document.createElement("td");
		let audioTag = document.createElement("audio");
		audioTag.src = response.results[i].previewUrl;
		audioTag.controls = true;

		// Appeand <audio> to <td>
		audioTdTag.appendChild(audioTag);

		// Append all these <td> tags to the <tr>
		trTag.appendChild(imgTdTag);
		trTag.appendChild(artistTdTag);
		trTag.appendChild(trackTdTag);
		trTag.appendChild(albumTdTag);
		trTag.appendChild(audioTdTag);
		console.log(trTag);

		// Finally, append the <tr> tag to <tbody>
		document.querySelector("tbody").appendChild(trTag);
	}
}

document.querySelector("#search-form").onsubmit = function(event) {
	// Don't actually submit this form, we're creting a single page app!
	event.preventDefault();

	// Grab user input
	let searchInput = document.querySelector("#search-id").value.trim();
	let limitInput = document.querySelector("#limit-id").value;
	
	let url = "https://itunes.apple.com/search?term=" + searchInput + "&limit=" + limitInput;

	// Make the http request to iTunes via AJAX using the vanilla JS way
	let httpRequest = new XMLHttpRequest();

	// Sent a request to iTunes
	httpRequest.open("GET", url);
	httpRequest.send();

	// This function will run when some state changes, which means we're getting a response back from iTunes
	httpRequest.onreadystatechange = function() {
		// There will be several state changes but I only care about readyState == 4 AKA .DONE
		if (httpRequest.readyState == httpRequest.DONE) {
			// Check for errors when getting a response back
			if (httpRequest.status == 200) {
				// 200 means we got a successful response back!
				// console.log(httpRequest.responseText);

				// Pass the response to a function that will handle the display
				displayResults(httpRequest.responseText);
			}
			else {
				// There is some error
				console.log("AJAX Error!");
				console.log(httpRequest.status);
			}
		}
	}
}