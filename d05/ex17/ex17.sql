SELECT count(*) AS 'nb_susc',
ROUND(AVG(price)-(AVG(price)%1)) AS 'av_susc',
SUM(duration_sub)%42 AS 'ft'
FROM subscription;