<?php
	require "config/config.php";
	$isUpdated = false;

	if (!isset($_POST['title']) || empty($_POST['title'])) {
		$error = "Please fill out all required fields";
	}
	else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		if (isset($_POST['release_date']) && !empty($_POST['release_date'])) {
			$release_date = $_POST['release_date'];
		}
		else {
			$release_date = "null";
		}

		if (isset($_POST['label']) && !empty($_POST['label'])) {
			$label = $_POST['label'];
		}
		else {
			$label = "null";
		}

		if (isset($_POST['sound']) && !empty($_POST['sound'])) {
			$sound = $_POST['sound'];
		}
		else {
			$sound = "null";
		}

		if (isset($_POST['genre']) && !empty($_POST['genre'])) {
			$genre = $_POST['genre'];
		}
		else {
			$genre = "null";
		}

		if (isset($_POST['rating']) && !empty($_POST['rating'])) {
			$rating = $_POST['rating'];
		}
		else {
			$rating = "null";
		}

		if (isset($_POST['format']) && !empty($_POST['format'])) {
			$format = $_POST['format'];
		}
		else {
			$format = "null";
		}

		if (isset($_POST['award']) && !empty($_POST['award'])) {
			$award = $_POST['award'];
		}
		else {
			$award = "null";
		}

		// Using prepared statements
		$statement = $mysqli->prepare(
			"UPDATE dvd_titles SET title = ?, release_date = ?, label_id = ?, sound_id = ?, genre_id = ?, rating_id = ?, format_id = ?, award = ? WHERE dvd_title_id = ?"
		);

		// Bind the parameters
		$statement->bind_param("ssiiiiisi", $_POST["title"], $release_date, $label, $sound, $genre, $rating, $format, $award, $_POST["dvd_title_id"]);

		$executed = $statement->execute();
		if(!$executed) {
			echo $mysqli->error;
		}

		// affected_rows will return how many records have been inserted/updated from the above statement
		if ($statement->affected_rows == 1) {
			$isUpdated = true;
		}
		$statement->close();

		$mysqli->close();

	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_POST['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php?dvd_title_id=<?php echo $_POST['dvd_title_id']; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if ($isUpdated) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully edited.
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?dvd_title_id=<?php echo $_POST['dvd_title_id']; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>