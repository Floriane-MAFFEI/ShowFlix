# MCD 
:
:
:
:
user: id_user, pseudo, password, role

:
:
belongs, 0N movie, 0N genre
genre: id_genre, name
write, 0N user, 11 review

season: season_id, number_episode, number_season
has, 0N movie, 11 season
movie: id_movie, title, duration, release_date, synopsis, summary, poster, type
reviewed, 0N movie, 11 review
review: id_review, content, rating, date

:
:
plays, 0N movie, 11 casting
casting: id_casting, credit_order, role
is, 0N actor, 11 casting

:
:
:
:
actor: id_actor, name, surname


## MCD image

![MCD.svg](../public/img/MCD.svg)