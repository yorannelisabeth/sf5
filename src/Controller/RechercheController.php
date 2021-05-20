<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'recherche')]
    public function index(Request $rq, LivreRepository $lr): Response
    {
        /* 
            1 - RECUPERER le mot tapé dans le formulaire de recherche ,
            2 -  affichez ce mot : Résultat pour la recherche de : ..."
            11h40 correction le 18/05/2021
            
        */
        $mot = $rq->query->get("mot");
        $livres = $lr->findByMot($mot);
        $livres_non_disponibles = $lr->LivresNonDisponibles();

      // dans la route Recherche ,, tu n'envoies pas la varialbe livre_non_rendu 
        return $this->render('recherche/index.html.twig',compact("mot","livres", "livres_non_disponibles"));
        /*
        compact() va créer un tableau avec les paramètres qui lui sont passées:
        compact("nom","prenom")va retourner le tableau :
        [
            "nom"->$nom,
            "prenom"->$prenom
        ]
        il faut que les variables $nom,et $prenom existent

            ---------------------autre facon -----------------------
            query sert a récupéré les elment d'un get formulaire ps ne pas oublié de mettre un name dans le formulaire sinon on ne peut pas récupé les information envoyer.
            mot est le name de l'input du formulaire search dans le menu.html.twig
          return $this->render('recherche/index.html.twig', [
            'mot' => $mot,
        ]);
      
        */
    }                                                                                                                           
        
}
    

