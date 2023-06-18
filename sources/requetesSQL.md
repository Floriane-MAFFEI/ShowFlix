### Récupérer tous les films.
```SELECT * FROM movie```

### Récupérer les acteurs et leur(s) rôle(s) pour un film donné.
```SELECT * FROM person INNER JOIN casting ON person.id = casting.person_id INNER JOIN movie ON movie.id = casting.movie_id WHERE movie.title = "Epic movie"```

### Récupérer les genres associés à un film donné.
```SELECT genre.name, movie.title FROM genre INNER JOIN movie_genre ON movie_genre.genre_id = genre.id INNER JOIN movie ON movie.id = movie_genre.movie_id WHERE movie.title = "Epic movie"```

### Récupérer les saisons associées à un film/série donné.
```SELECT * FROM season INNER JOIN movie ON movie.id = season.movie_id WHERE movie.title = "Epic movie"```

### Récupérer les critiques pour un film donné.
```SELECT * FROM review INNER JOIN movie ON movie.id = review.movie_id WHERE movie.title = "Epic movie"```

### Récupérer les critiques pour un film donné et son utilisateur associé
```SELECT * FROM review INNER JOIN movie ON movie.id = review.movie_id INNER JOIN user ON user.id = review.user_id  WHERE movie.title = "Epic movie"```

### Calculer, pour chaque film, la moyenne des critiques par film (en une seule requête)
````SELECT title, ROUND(AVG(rating),1) AS moyenne FROM movie INNER JOIN review ON movie.id = review.movie_id GROUP BY movie.id````

### Calculer, pour chaque film, la moyenne des critiques par film (en une seule requête)
```SELECT title, ROUND(AVG(rating),1) AS moyenne FROM movie INNER JOIN review ON movie.id = review.movie_id WHERE movie.title = "Epic movie"```

### Récupérer tous les films pour une année de sortie donnée.
```SELECT * FROM `movie` WHERE YEAR(release_date) = 1970```

### Récupérer tous les films pour un titre donné (par ex. 'Epic Movie').
```SELECT * FROM `movie` WHERE `title` = "..."```

### Récupérer tous les films dont le titre contient une chaîne donnée.
```SELECT * FROM `movie` WHERE `title` LIKE "%Epic%"```

### Nombre de films par page : 10 (par ex.)
### Récupérer la liste des films de la page 2 (grâce à LIMIT).
```SELECT * FROM movie LIMIT 10 OFFSET 10```
