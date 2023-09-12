<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class MovieController extends AbstractController
{
    #[Route(
        path: '/movies',
        name: 'app_movies_list',
        methods: ['GET']
    )]
    public function list(MovieRepository $repository): Response
    {
        return $this->render('movie/list.html.twig', [
            'movies' => $repository->searchAll(),
        ]);
    }

    #[Route(
        path: '/movies/{slug}',
        name: 'app_movies_details',
        requirements: [
            'slug' => '\d{4}-'.Requirement::ASCII_SLUG,
        ],
        methods: ['GET']
    )]
    public function details(string $slug, MovieRepository $repository): Response
    {
        return $this->render('movie/details.html.twig', [
            'movie' => $repository->searchBySlug($slug),
        ]);
    }

    #[Route(
        path: '/movies/new',
        name: 'app_movies_new',
        methods: ['GET', 'POST']
    )]
    #[Route(
        path: '/movies/{slug}/edit',
        name: 'app_movies_edit',
        requirements: [
            'slug' => '\d{4}-'.Requirement::ASCII_SLUG,
        ],
        methods: ['GET', 'POST']
    )]
    public function newOrEdit(
        MovieRepository $repository,
        Request $request,
        EntityManagerInterface $entityManager,
        string|null $slug = null
    ): Response {
        if (!empty($slug)) {
            $movie = $repository->searchBySlug($slug);
        } else {
            $movie = new Movie();
        }

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('app_movies_list');
        }

        return $this->render('movie/form.html.twig', [
            'form' => $form,
            'movie' => $movie,
            'editing' => !empty($slug)
        ]);
    }
}
