SELECT title, summary FROM
(SELECT title, summary, id_film FROM film WHERE summary LIKE '%Vincent%' ORDER BY id_film) AS T;