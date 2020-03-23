-- Display albums with letters "on" sorted alphabetically
SELECT *
FROM albums
WHERE title LIKE '%on%'
ORDER BY title;

-- Display same as above but no artist_id column
SELECT title AS album_title, name AS artist_name
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id
WHERE title LIKE '%on%'
ORDER BY title;

-- Display tracks that have AAC audio file format
SELECT tracks.name AS track_name, composer, media_types.name AS media_type, unit_price
FROM tracks
JOIN media_types
	ON tracks.media_type_id = media_types.media_type_id
WHERE tracks.media_type_id = 5
ORDER BY track_name;

-- Display R&B/Soul and Jazz tracks with not NULL composer
SELECT track_id, tracks.name AS track_name, composer, milliseconds, genres.name AS genre_name
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
WHERE composer IS NOT NULL
AND (tracks.genre_id = 2 OR tracks.genre_id = 14)
ORDER BY track_name DESC;

-- Display genre DVDs that won awards
SELECT title, award, genre, label, rating
FROM dvd_titles
JOIN genres
	ON dvd_titles.genre_id = genres.genre_id
JOIN labels
	ON dvd_titles.label_id = labels.label_id
JOIN ratings
	ON dvd_titles.rating_id = ratings.rating_id
WHERE award IS NOT NULL
AND dvd_titles.genre_id = 9
ORDER BY award;

-- Display DVDs made by Universal and have DTS sound
SELECT title, sound, label, genre, rating
FROM dvd_titles
JOIN sounds
	ON dvd_titles.sound_id = sounds.sound_id
JOIN labels
	ON dvd_titles.label_id = labels.label_id
JOIN genres
	ON dvd_titles.genre_id = genres.genre_id
JOIN ratings
	ON dvd_titles.rating_id = ratings.rating_id
WHERE dvd_titles.sound_id = 4
AND dvd_titles.label_id = 127
ORDER BY title;

-- Display R rated SciFi DVDs with release date
SELECT title, release_date, rating, genre, sound, label
FROM dvd_titles
JOIN ratings
	ON dvd_titles.rating_id = ratings.rating_id
JOIN genres
	ON dvd_titles.genre_id = genres.genre_id
JOIN sounds
	ON dvd_titles.sound_id = sounds.sound_id
JOIN labels
	ON dvd_titles.label_id = labels.label_id
WHERE release_date IS NOT NULL
AND dvd_titles.rating_id = 7
AND dvd_titles.genre_id = 19
ORDER BY release_date DESC;