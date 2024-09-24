<?php
require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Créer un container pour gérer les dépendances
$container = new Container();
AppFactory::setContainer($container);

// Créer l'application Slim
$app = AppFactory::create();

// Créer l'instance de Twig
$twig = Twig::create(__DIR__ . '/../views', ['cache' => false]);

// Ajouter le middleware Twig en injectant directement l'instance
$app->add(TwigMiddleware::create($app, $twig));

// Définir les routes
$app->get('/', [\App\Controllers\HomeController::class, 'showHome']);
$app->get('/equipe', [\App\Controllers\HomeController::class, 'showEquipe']);
$app->get('/workshop', [\App\Controllers\HomeController::class, 'showWorkshop']);
$app->get('/epsilink', [\App\Controllers\HomeController::class, 'showEpsiLink']);
$app->get('/ect', [\App\Controllers\HomeController::class, 'showEct']);

// Lancer l'application
$app->run();
