<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;
class HomeController extends AbstractController



{
    //1 - cette route doit se lancer quand on est a la racine du projet
    #[Route('/', name: 'home')]
    public function index(LivreRepository $lr): Response
    {
/*EXO 1 
    1 - cette route doit se lancer quand on est a la racine du projet
    2 - affiche la liste des livres sous forme de vignette
*/

        return $this->render('home/index.html.twig', [
            'livres' => $lr->findAll(),
            'livres_non_disponibles' => $lr->LivresNonDisponibles()
        ]);
    }
}

/*EXO : vous devez empêcher de pouvoir emprunter un livre s'il n'est pas disponible
(cacher le lien ne suffit pas) */
