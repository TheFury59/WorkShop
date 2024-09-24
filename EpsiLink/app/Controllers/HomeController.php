<?php

namespace App\Controllers;

use Slim\Views\Twig;

class HomeController
{
    // Méthode pour la page d'accueil
    public function index($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig'); // Rend la vue home.twig
    }

    // Méthode pour la page équipe
    public function showEquipe($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'equipe.twig'); // Rend la vue equipe.twig
    }

    // Méthode pour la page Workshop
    public function showWorkshop($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'workshop.twig');
    }

    // Méthode pour la page EpsiLink
    public function showEpsiLink($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'epsilink.twig');
    }

    // Méthode pour la page ECT
    public function showEct($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'ect.twig');
    }
    
    // Nouvelle méthode pour rendre la page d'accueil (selon ton dernier code fourni)
    public function showHome($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig'); // Rend la vue home.twig avec le code HTML que tu m'as fourni
    }
}
