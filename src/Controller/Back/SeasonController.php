<?php

namespace App\Controller\Back;

use App\Entity\Season;
use App\Form\Back\SeasonType;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/back/season", name="app_back_season_")
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * 
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('back/season/index.html.twig', [
            'seasons' => $seasonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     * 
     */
    public function new(Request $request, SeasonRepository $seasonRepository): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->add($season, true);

            // TODO j'ajoute un flash message de réussite
            $this->addFlash("success", "Votre Saison a bien été ajoutée.");


            return $this->redirectToRoute('app_back_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/new.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"}, methods={"GET"})
     * 
     */
    public function show(?Season $season): Response
    {
        return $this->render('back/season/show.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * 
     */
    public function edit(Request $request, ?Season $season, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->add($season, true);

            return $this->redirectToRoute('app_back_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", requirements={"id"="\d+"}, methods={"POST"})
     * 
     */
    public function delete(Request $request, ?Season $season, SeasonRepository $seasonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->request->get('_token'))) {
            $seasonRepository->remove($season, true);
        }

        return $this->redirectToRoute('app_back_season_index', [], Response::HTTP_SEE_OTHER);
    }
}
