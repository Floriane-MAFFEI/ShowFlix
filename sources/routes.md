# Routes du site

## Route API

| URL                       | Méthode HTTP | Contrôleur        | Méthode             | Commentaire                                                                       |
|---------------------------|--------------|-------------------|---------------------|-----------------------------------------------------------------------------------|
| `/api/genres`             | `GET`        | `GenreController` | `getGenres`         | Liste les genres de films dispo                                                   |
| `/api/genres/{id}/movies` | `GET`        | `GenreController` | `getMoviesByGenres` | {id}: représente l'id du genre <br> Affiche les films appartenant au genre choisi |
| `/api/movies`             | `GET`        | `MovieController` | `getMovies`         | Liste les films dispo                                                             |
| `/api/movies/{id}`        | `GET`        | `MovieController` | `getMoviesById`     | {id}: représente l'id du film, Affiche le film choisi                             |
| `/api/movies/random`      | `GET`        | `MovieController` | `getRandom`         | Liste un film aléatoire                                                           |
| `/api/movies`             | `POST`       | `MovieController` | `postMovies`        | Crée un film                                                                      |
| `/api/users`              | `GET`        | `MovieController` | `getUsers`          | Liste les utilisateurs                                                            |


## Routes Back (Backoffice)

| URL                                    | Méthode HTTP | Contrôleur        | Méthode  | Commentaire                                                              |
|----------------------------------------|--------------|-------------------|----------|--------------------------------------------------------------------------|
| `/back-office/film`                    | `GET`        | `MovieController` | `index`  | Liste les films                                                          |
| `/back-office/film/ajouter`            | `GET`,`POST` | `MovieController` | `new`    | Crée un film                                                             |
| `/back-office/film/{id}`               | `GET`        | `MovieController` | `show`   | {id}: représente l'id du film, <br/> Affiche le film choisi              |
| `/back-office/film/{id}/editer`        | `GET`,`POST` | `MovieController` | `edit`   | Modifie le film sélectionné                                              |
| `/back-office/film/{id}`               | `DELETE`     | `MovieController` | `delete` | Supprime le film sélectionné                                             |
| `/back-office/utilisateur`             | `GET`        | `UserController`  | `index`  | Liste les utilisateurs                                                   |
| `/back-office/utilisateur/ajouter`     | `GET`,`POST` | `UserController`  | `new`    | Crée un utilisateur                                                      |
| `/back-office/utilisateur/{id}`        | `GET`        | `UserController`  | `show`   | {id}: représente l'id de l'utilisateur,<br/>Affiche l'utilisateur choisi |
| `/back-office/utilisateur/{id}/editer` | `GET`,`POST` | `UserController`  | `edit`   | Modifie l'utilisateur sélectionné                                        |
| `/back-office/utilisateur/{id}`        | `DELETE`     | `UserController`  | `delete` | Supprime l'utilisateur sélectionné                                       |



# Routes Front

| URL                                 | Contrôleur           | Méthode  | Commentaire                                                              |
|-------------------------------------|----------------------|----------|--------------------------------------------------------------------------|
| `/`                                 | `MainController`     | `home`   | Page d'accueil                                                           |
| `/favoris`                          | `FavoriteController` | `list`   | Liste les favoris                                                        |
| `/favoris/ajouter/{id}`             | `FavoriteController` | `add`    | {id}: représente l'id du film à ajouter, <br/> <br/>Ajoute un favoris    |
| `/favoris/vider`                    | `FavoriteController` | `empty`  | Vide la liste des favoris                                                |
| `/favoris/supprimer/{id}`           | `FavoriteController` | `list`   | {id}: représente l'id du film à supprimer, <br/> Supprime un favoris     |
| `/film-serie/{id}`                  | `MovieController`    | `show`   | {id}: représente l'id du film, <br/> Affiche le film choisi              |
| `/film-serie`                       | `MovieController`    | `list`   | Liste les films ou via la recherche par mot clé                          |
| `/film-serie/{id}/critique/ajouter` | `ReviewController`   | `add`    | {id}: représente l'id du film,<br/>Ajouter un commentaire au film choisi |
| `/login`                            | `SecurityController` | `login`  | Page de connexion                                                        |
| `/logout`                           | `SecurityController` | `logout` | Page de déconnexion                                                      |
