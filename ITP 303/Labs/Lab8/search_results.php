<?php

	// TODO: Establish DB connection, submit SQL query here. Remember to check for any MySQLi errors.

	$host = "303.itpwebdev.com";
	$user = "awong827_db_user";
	$password = "uscitp2020";
	$db = "awong827_football_schedule_db";

	$mysqli = new mysqli($host, $user, $password, $db);

	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset("utf8");

	$sql = "SELECT schedule.date AS date, day, home.team AS home, away.team AS away, venue
FROM schedule
JOIN days
	ON schedule.day_id = days.id
JOIN teams home
	ON schedule.home_team_id = home.id
JOIN teams away
	ON schedule.away_team_id = away.id
JOIN venues
	ON schedule.venue_id = venues.id
WHERE 1=1";

	if (isset($_GET["team_id"]) && !empty($_GET["team_id"])) {
		$sql = $sql . " AND schedule.home_team_id = " . $_GET["team_id"];
	}

	if (isset($_GET["venue_id"]) && !empty($_GET["venue_id"])) {
		$sql = $sql . " AND schedule.venue_id = " . $_GET["venue_id"];
	}

	if (isset($_GET["day_id"]) && !empty($_GET["day_id"])) {
		$sql = $sql . " AND schedule.day_id = " . $_GET["day_id"];
	}

	$sql = $sql . ";";

	$results = $mysqli->query($sql);
	if (!$results) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Football Database Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Football Schedule Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				<!-- TODO: Replace '1' with actual number of results -->
				Showing <?php echo $results->num_rows;?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Date</th>
							<th>Day</th>
							<th>Home Team</th>
							<th>Away Team</th>
							<th>Venue</th>
						</tr>
					</thead>
					<tbody>

						<!-- TODO: Loop through DB results and output them here. Modify or remove hard-coded output below. -->

						<?php while ($row = $results->fetch_assoc()):?>
							<tr>
								<td>
									<?php echo $row["date"]; ?>
								</td>
								<td>
									<?php echo $row["day"]; ?>
								</td>
								<td>
									<?php echo $row["home"]; ?>
								</td>
								<td>
									<?php echo $row["away"]; ?>
								</td>
								<td>
									<?php echo $row["venue"]; ?>
								</td>
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
	</div> <!-- .container -->
</body>
</html>