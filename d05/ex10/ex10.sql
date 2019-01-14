SELECT title AS 'Title', summary AS 'Summary', prod_year FROM
(SELECT title, summary, prod_year FROM film WHERE id_genre=
(SELECT id_genre FROM genre WHERE `name`='erotic')) AS T;