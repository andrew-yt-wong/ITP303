-- Create a view football_schedule that displays full schedule in chronological order
CREATE OR REPLACE VIEW football_schedule AS
	SELECT days.day, schedule.date, home.team AS home, away.team AS away, venues.venue
	FROM schedule
	JOIN days
		ON schedule.day_id = days.id
	JOIN teams home
		ON schedule.home_team_id = home.id
	JOIN teams away
		ON schedule.away_team_id = away.id
	JOIN venues
		ON schedule.venue_id = venues.id
	ORDER BY schedule.date;

-- Add two games
INSERT INTO venues (venue)
VALUES ('Folsom Field');
INSERT INTO schedule (day_id, date, home_team_id, away_team_id, venue_id)
VALUES(7, '2017-11-18', 10, 4, 10);
INSERT INTO schedule (day_id, date, home_team_id, away_team_id, venue_id)
VALUES(7, '2017-11-18', 9, 6, 8);

-- Update Beavers v Bears game
UPDATE schedule
SET date = '2017-11-06', away_team_id = 1
WHERE schedule.id = 18;

-- Delete Beavers v Devils game
DELETE FROM schedule
WHERE schedule.id = 21;

-- Display all venues and counts (AGGREGATE FUNCTIONS)
SELECT venues.id AS venue_id, venue, COUNT(*) AS game_count
FROM schedule
JOIN venues
	ON schedule.venue_id = venues.id
GROUP BY venues.id;

-- Create a view for drama DVDs with release date not NULL
CREATE OR REPLACE VIEW dramas AS
	SELECT dvd_title_id, title, release_date, award, format, genre, label, rating, sound
    FROM dvd_titles
    JOIN formats
		ON dvd_titles.format_id = formats.format_id
	JOIN genres
		ON dvd_titles.genre_id = genres.genre_id
	JOIN labels
		ON dvd_titles.label_id = labels.label_id
	JOIN ratings
		ON dvd_titles.rating_id = ratings.rating_id
	JOIN sounds
		ON dvd_titles.sound_id = sounds.sound_id
	WHERE release_date IS NOT NULL
    AND dvd_titles.genre_id = 9;
    
-- Add a movie
INSERT INTO dvd_titles (title, release_date, award, format_id, genre_id, label_id, rating_id, sound_id)
VALUES('The Godfather', '1972-03-24', '45th Academy Award for Best Picture', 2, 9, 92, 7, 4);

-- Update Zero Effect
UPDATE dvd_titles
SET label_id = 24, genre_id = 7, format_id = 4
WHERE dvd_title_id = 5131;

-- Delete Major League 3
DELETE FROM dvd_titles
WHERE dvd_title_id = 5932;

-- Display number of chars for longest and shortest title in database
SELECT MAX(CHAR_LENGTH(title)) AS longest_title, MIN(CHAR_LENGTH(title)) AS shortest_title
FROM dvd_titles;

-- Display all genres and number of DVDs in column
SELECT genres.genre_id, genre, COUNT(*) AS dvd_count
FROM dvd_titles
JOIN genres
	ON dvd_titles.genre_id = genres.genre_id
GROUP BY genres.genre_id;