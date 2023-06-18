<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\AppProvider;
use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Review;
use App\Entity\Season;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // Declaration of a private variable to store the passwordHasher Object
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        // Assignment of the UserPasswordHasherInterface object passed.
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $entityManager): void
    {
        // Installation of the faker in the method and I define it in fr and I import the provider
        $faker = Factory::create("fr_FR");

        // Create a Faker instance of SpecieProvider
        $faker->addProvider(new AppProvider());

        // ! FIXTURE PERSON

        $persons = [];
        for ($i=0; $i < 20; $i++) {
            // Creates a new instance of the Person class
            $person = new Person();
            // Sets from the retrieved random data
            $person->setFirstname($faker->firstName());
            $person->setLastname($faker->lastName());

            // Add my persons to an empty array
            $persons[] = $person;

            // Persist the Person instance in the database
            $entityManager->persist($person);
        }


        // ! FIXTURE GENRE

        // Initializing an empty list to store instances of Genre
        $genreList = [];

        for ($i=0; $i < 20; $i++) {
            $genre = new Genre();

            $genre->setName($faker->unique()->genre());

            // Add the genre to the list
            $genreList[] = $genre;

            // Persist the Genre instance in the database
            $entityManager->persist($genre);
        }

        // ! FIXTURE MOVIE / SEASON / CASTING

        for ($i=0; $i < 20; $i++) {
            $movie = new Movie();

            // Sets all my parameters
            $movie->setTitle($faker->unique()->movieTitle());
            $movie->setDuration($faker->numberBetween(60,250));
            $movie->setReleaseDate(new DateTimeImmutable($faker->date()));
            $movie->setSynopsis($faker->paragraph(6));
            $summary = substr($movie->getSynopsis(), 0, 100);
            $movie->setSummary($summary);
            $movie->setPoster("https://picsum.photos/id/".mt_rand(1,180)."/300/500");

            // A random number between 0 and 1
            $aleatoire = mt_rand(0,1);

            // If the random number is equal to 0 a movie is created otherwise it will be a series            if
            if ($aleatoire === 0){
                $movie->setType("film");

            }else{
                $movie->setType("série");

                for ($j=1; $j <= mt_rand(1,10); $j++) {

                    // Create a season then persist it
                    $season = new Season();
                    $season->setNumberEpisode(mt_rand(5,25));
                    $season->setNumberSeason($j);
                    $entityManager->persist($season);

                    // Add the season to the series
                    $movie->addSeason($season);
                }


            }

            // Add a random genre between 0 and the size of genreList
            $faker->unique(true);

            // Loop to assign 3 genres to each movie/series
            for ($k=0; $k < 3; $k++) {
                $movie->addGenre($genreList[$faker->unique()->numberBetween(0,count($genreList) -1)]);
            }

            for ($l=1; $l <= 5; $l++) {

                // Create my castings
                $casting = new Casting();

                // Add the parameters
                $casting->setRole($faker->name());
                $casting->setCreditOrder($l);

                // Get a random person object
                $randomPerson = $persons[array_rand($persons)];

                // Link the person to the casting
                $casting->setPerson($randomPerson);

                // Link between movie and casting
                $movie->addCasting($casting);

                // Persist the Casting instance in the database
                $entityManager->persist($casting);
            }

            for ($m=0; $m < mt_rand(1,5) ; $m++) {

                // Create an empty review
                $review = new Review();

                $review->setUsername($faker->userName());
                $review->setEmail($faker->email());
                $review->setContent($faker->sentence(20));
                $review->setRating($faker->numberBetween(1,5));
                $review->setWatchedAt(new DateTimeImmutable($faker->date()));

                $review->setReactions($faker->randomElements($faker->reactions(),mt_rand(1,5)));


                // Associate the review with the movie
                $movie->addReviews($review);

                // Persist the Review instance in the database
                $entityManager->persist($review);
            }

            // Persist the Movie instance in the database
            $entityManager->persist($movie);

        }

        // ! USERS

        $admin = new User();
        // Set the email
        $admin->setEmail("admin@gmail.io");
        // Set the roles
        $admin->setRoles(["ROLE_ADMIN"]);
        // Set the user's password using the passwordHasher
        $admin->setPassword($this->passwordHasher->hashPassword($admin,"admin"));
        // Persist the instance in the database
        $entityManager->persist($admin);

        $manager = new User();
        $manager->setEmail("manager@gmail.io");
        $manager->setRoles(["ROLE_MANAGER"]);
        $manager->setPassword($this->passwordHasher->hashPassword($manager,"manager"));
        $entityManager->persist($manager);

        $user = new User();
        $user->setEmail("user@gmail.io");
        $user->setRoles([]);
        $user->setPassword($this->passwordHasher->hashPassword($user,"user"));
        $entityManager->persist($user);

        // I flush in order to save in DB the objects that have been persisted
        $entityManager->flush();
    }
}