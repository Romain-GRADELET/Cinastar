<?php

namespace App\Controller\Back;

use App\Entity\Casting;
use App\Form\CastingType;
use App\Repository\CastingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/back/casting", name="app_back_casting_")
 */
class CastingController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * 
     * @IsGranted("ROLE_MANAGER")
     */
    public function index(CastingRepository $castingRepository): Response
    {
        return $this->render('back/casting/index.html.twig', [
            'castings' => $castingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, CastingRepository $castingRepository): Response
    {
        $casting = new Casting();
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $castingRepository->add($casting, true);
            
            // TODO j'ajoute un flash message de réussite
            $this->addFlash("success", "Votre Casting a bien été ajoutée.");

            return $this->redirectToRoute('app_back_casting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/new.html.twig', [
            'casting' => $casting,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"}, methods={"GET"})
     * 
     * @IsGranted("ROLE_MANAGER")
     */
    public function show(?Casting $casting): Response
    {
        return $this->render('back/casting/show.html.twig', [
            'casting' => $casting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Casting $casting, CastingRepository $castingRepository): Response
    {
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $castingRepository->add($casting, true);

            return $this->redirectToRoute('app_back_casting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/edit.html.twig', [
            'casting' => $casting,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", requirements={"id"="\d+"}, methods={"POST"})
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Casting $casting, CastingRepository $castingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$casting->getId(), $request->request->get('_token'))) {
            $castingRepository->remove($casting, true);
        }

        return $this->redirectToRoute('app_back_casting_index', [], Response::HTTP_SEE_OTHER);
    }
}
