SELECT title, summary FROM
(SELECT title, summary, id_film FROM film WHERE LOWER(summary) LIKE '%vincent%' ORDER BY id_film) AS T;