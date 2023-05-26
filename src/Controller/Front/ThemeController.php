<?php

namespace App\Controller\Front;

use App\Services\ThemeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    /**
     * @Route("/front/theme", name="app_front_theme")
     */
    public function index(ThemeService $themeService): Response
    {
        $themeService->switch();

        return $this->redirectToRoute('default', [

        ]);
    }
}
