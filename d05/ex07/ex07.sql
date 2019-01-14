SELECT title, summary FROM
(SELECT title, summary, duration FROM film WHERE title LIKE '%42%' OR summary LIKE '%42%' ORDER BY duration) AS T;