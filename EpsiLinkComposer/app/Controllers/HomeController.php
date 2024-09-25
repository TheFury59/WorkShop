<?php

namespace App\Controllers;

use Slim\Views\Twig;

class HomeController
{
    // Page d'accueil
    public function showHome($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig');
    }

    // Page équipe
    public function showEquipe($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'equipe.twig');
    }

    // Page Workshop
    public function showWorkshop($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'workshop.twig');
    }

    // Page EpsiLink
    public function showEpsiLink($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'epsilink.twig');
    }

    // Page ECT
    public function showEct($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'ect.twig');
    }

    // Page d'enregistrement
    public function showRegister($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'register.twig');
    }
}
