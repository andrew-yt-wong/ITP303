<?php
	if (!isset($_GET['dvd_title_id']) || empty($_GET['dvd_title_id'])) {
		$error = "Invalid Track ID.";
	}
	else {
		$host = "303.itpwebdev.com";
		$user = "awong827_db_user";
		$password = "uscitp2020";
		$db = "awong827_dvd_db";

		$mysqli = new mysqli($host, $user, $password, $db);
		if ($mysqli->connect_errno) {
			echo $mysqli->connet_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$sql = "SELECT title, release_date, award, label, sound, genre, rating, format
FROM dvd_titles
LEFT JOIN genres
	ON genres.genre_id = dvd_titles.genre_id
LEFT JOIN ratings
	ON ratings.rating_id = dvd_titles.rating_id
LEFT JOIN labels
	ON labels.label_id = dvd_titles.label_id
LEFT JOIN formats
	ON formats.format_id = dvd_titles.format_id
LEFT JOIN sounds
	ON sounds.sound_id = dvd_titles.sound_id
WHERE dvd_title_id = " . $_GET['dvd_title_id'] . ";";

		$results = $mysqli->query($sql);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}

		$row = $results->fetch_assoc();

		$mysqli->close();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

				<?php if (isset($error) && !empty($error)): ?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php else: ?>

				<table class="table table-responsive">

					<tr>
						<th class="text-right">Title:</th>
						<td><?php echo $row['title']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Release Date:</th>
						<td><?php echo $row['release_date']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Genre:</th>
						<td><?php echo $row['genre']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Label:</th>
						<td><?php echo $row['label']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Rating:</th>
						<td><?php echo $row['rating']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Sound:</th>
						<td><?php echo $row['sound']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Format:</th>
						<td><?php echo $row['format']; ?></td>
					</tr>

					<tr>
						<th class="text-right">Award:</th>
						<td><?php echo $row['award']; ?></td>
					</tr>

				</table>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>