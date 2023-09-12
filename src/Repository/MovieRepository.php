<?php

namespace App\Repository;

use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    const MOVIES = [
        [
            'title' => 'Men in Black',
            'description' => <<<DESC
    Chargés de protéger la Terre de toute infraction extraterrestre et de réguler l'immigration intergalactique sur notre planète, les Men in black ou MIB opèrent dans le plus grand secret. Vêtus de costumes sombres et équipés des toutes dernières technologies, ils passent inaperçus aux yeux des humains dont ils effacent régulièrement la mémoire récente : la présence d'aliens sur notre sol doit rester secrète.
    Récemment séparé de son vieux partenaire, retourné à la vie civile sans aucun souvenir de sa vie d'homme en noir, K, le plus expérimenté des agents du MIB décide de former J, un jeune policier. Ensemble, ils vont affronter une nouvelle menace : Edgar le cafard...
    DESC,
            'releasedAt' => '1997/08/06',
            'picture' => '120603.jpg',
            'genres' => ['Comédie', 'Science fiction', 'Action'],
            'slug' => '1997-men-in-black',
        ],
        [
            'title' => 'FORREST GUMP',
            'description' => <<<DESC
    Quelques décennies d'histoire américaine, des années 1940 à la fin du XXème siècle, à travers le regard et l'étrange odyssée d'un homme simple et pur, Forrest Gump.
    DESC,
            'releasedAt' => '1994/10/05',
            'picture' => '1994-forrest-gump.jpg',
            'genres' => ['Romance', 'Drame', 'Comédie'],
            'slug' => '1994-forrest-gump',
        ],
        [
            'title' => 'LA LISTE DE SCHINDLER',
            'description' => <<<DESC
    Evocation des années de guerre d'Oskar Schindler, fils d'industriel d'origine autrichienne rentré à Cracovie en 1939 avec les troupes allemandes. Il va, tout au long de la guerre, protéger des juifs en les faisant travailler dans sa fabrique et en 1944 sauver huit cents hommes et trois cents femmes du camp d'extermination de Auschwitz-Birkenau.
    DESC,
            'releasedAt' => '1994/03/02',
            'picture' => '5927961.jpg',
            'genres' => ['Drame', 'Historique', 'Biopic'],
            'slug' => '1994-la-liste-de-schindler',
        ],
        [
            'title' => 'LA LIGNE VERTE',
            'description' => <<<DESC
    Paul Edgecomb, pensionnaire centenaire d'une maison de retraite, est hanté par ses souvenirs. Gardien-chef du pénitencier de Cold Mountain en 1935, il était chargé de veiller au bon déroulement des exécutions capitales en s’efforçant d'adoucir les derniers moments des condamnés. Parmi eux se trouvait un colosse du nom de John Coffey, accusé du viol et du meurtre de deux fillettes. Intrigué par cet homme candide et timide aux dons magiques, Edgecomb va tisser avec lui des liens très forts.Paul Edgecomb, pensionnaire centenaire d'une maison de retraite, est hanté par ses souvenirs. Gardien-chef du pénitencier de Cold Mountain en 1935, il était chargé de veiller au bon déroulement des exécutions capitales en s’efforçant d'adoucir les derniers moments des condamnés. Parmi eux se trouvait un colosse du nom de John Coffey, accusé du viol et du meurtre de deux fillettes. Intrigué par cet homme candide et timide aux dons magiques, Edgecomb va tisser avec lui des liens très forts.
    DESC,
            'releasedAt' => '2000/03/01',
            'picture' => '19254683.jpg',
            'genres' => ['Fantastique', 'Drame', 'Policier'],
            'slug' => '2000-la-ligne-verte',
        ],
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @param MovieRaw $raw
     */
    private static function hydrate(array $raw): Movie
    {
        $movie = new Movie();
        $movie->setSlug($raw['slug']);
        $movie->setTitle($raw['title']);
        $movie->setDescription($raw['description']);
        $movie->setReleasedAt(new DateTimeImmutable($raw['releasedAt']));
        // $movie->setGenres($raw['genres']);
        $movie->setPicture($raw['picture']);

        return $movie;
    }

    public static function getBySlug(string $slug): Movie
    {
        $indexedBySlug = array_column(self::MOVIES, null, 'slug');

        return self::hydrate($indexedBySlug[$slug]);
    }

    /**
     * @return list<Movie>
     */
    public static function listAll(): array
    {
        return array_map(self::hydrate(...), self::MOVIES);
    }

    public function searchBySlug(string $slug): ?Movie
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function searchAll(): array
    {
        return $this->findAll();
    }
}
