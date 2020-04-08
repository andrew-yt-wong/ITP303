<?php
	$host = "303.itpwebdev.com";
	$user = "awong827_db_user";
	$password = "uscitp2020";
	$db = "awong827_dvd_db";

	$mysqli = new mysqli($host, $user, $password, $db);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql = "SELECT dvd_title_id, title, release_date, award, label, sound, genre, rating, format
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
WHERE 1=1";

	if (isset($_GET['title']) && !empty($_GET['title'])) {
		$sql = $sql . " AND title LIKE '%" . $_GET['title'] . "%'";
	}

	if (isset($_GET['genre']) && !empty($_GET['genre'])) {
		$sql = $sql . " AND genres.genre_id = " . $_GET['genre'];
	}

	if (isset($_GET['rating']) && !empty($_GET['rating'])) {
		$sql = $sql . " AND ratings.rating_id = " . $_GET['rating'];
	}

	if (isset($_GET['label']) && !empty($_GET['label'])) {
		$sql = $sql . " AND labels.label_id = " . $_GET['label'];
	}

	if (isset($_GET['format']) && !empty($_GET['format'])) {
		$sql = $sql . " AND formats.format_id = " . $_GET['format'];
	}

	if (isset($_GET['sound']) && !empty($_GET['sound'])) {
		$sql = $sql . " AND sounds.sound_id = " . $_GET['sound'];
	}

	if (isset($_GET['release_date_from']) && !empty($_GET['release_date_from'])) {
		$sql = $sql . " AND release_date >= " . $_GET['release_date_from'];
	}

	if (isset($_GET['release_date_to']) && !empty($_GET['release_date_to'])) {
		$sql = $sql . " AND release_date <= " . $_GET['release_date_to'];
	}

	if (isset($_GET['award']) && !empty($_GET['award'])) {
		if ($_GET['award'] != "any") {
			if($_GET['award'] == "yes") {
				$sql = $sql . " AND award IS NOT NULL";
			}
			else {
				$sql = $sql . " AND award IS NULL";
			}
		}
	}

	$sql = $sql . ";";

	$results = $mysqli->query($sql);
	if ($results == false) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing <?php echo $results->num_rows;?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>

						<?php while ($row = $results->fetch_assoc()): ?>

						<tr>
							<td>
								<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>">
									<?php echo $row['title']; ?>
								</a>
							</td>
							<td><?php echo $row['release_date']; ?></td>
							<td><?php echo $row['genre']; ?></td>
							<td><?php echo $row['rating']; ?></td>
						</tr>

						<?php endwhile; ?>

					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>