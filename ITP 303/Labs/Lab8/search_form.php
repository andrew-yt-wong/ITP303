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

	$teams_sql = "SELECT * FROM teams;";
	$venues_sql = "SELECT * FROM venues;";
	$days_sql = "SELECT * FROM days;";

	$teams_results = $mysqli->query($teams_sql);
	$venues_results = $mysqli->query($venues_sql);
	$days_results = $mysqli->query($days_sql);

	if (!$teams_results) {
		echo $mysqli->error;
		exit();
	}

	if (!$venues_results) {
		echo $mysqli->error;
		exit();
	}

	if (!$days_results) {
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
	<title>Football Schedule Search Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Football Schedule Search Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<form action="search_results.php" method="GET">
			<div class="form-group row">
				<label for="team" class="col-sm-3 col-form-label text-sm-right">Team:</label>
				<div class="col-sm-9">
					<select name="team_id" id="team" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- TODO: Output all teams from the DB here. -->

						<?php while ($row = $teams_results->fetch_assoc()):?>

							<option value="<?php echo $row['id']; ?>"> <?php echo $row["team"] ?> </option>

						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="venue" class="col-sm-3 col-form-label text-sm-right">Venue:</label>
				<div class="col-sm-9">
					<select name="venue_id" id="venue" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- TODO: Output all venues from the DB here. -->

						<?php while ($row = $venues_results->fetch_assoc()):?>

							<option value="<?php echo $row['id']; ?>"> <?php echo $row["venue"] ?> </option>

						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="day" class="col-sm-3 col-form-label text-sm-right">Day:</label>
				<div class="col-sm-9">
					<select name="day_id" id="day" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- TODO: Output all days from the DB here. -->

						<?php while ($row = $days_results->fetch_assoc()):?>

							<option value="<?php echo $row['id']; ?>"> <?php echo $row["day"] ?> </option>

						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>