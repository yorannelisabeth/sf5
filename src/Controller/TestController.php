<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * Ces commentaires s'appellent annotations. ils commencent par / **il ne doit rien y avoir après. Chaque ligne doit commencer par *
     *
     * Toutes les méthodes d'un controller (qui correspond a une route) devront retourner un objet de la classe Reponse
     *
     * c'est ici que l'n mettra le arobaseRoute etc ... on choisi une version ou l'autre
     */
//@Route("/test", name="test")
    //la ligne justre en dessou est la mme chose que celle au dessus celle du bas est la depuis php 8
    #[Route('/test', name:'test')]
function index(): Response
    {
    return $this->json([
        'message' => 'Welcome to your new controller!',
        'path' => 'src/Controller/TestController.php',
    ]);
}

#[Route('/test/accueil', name:'test_accueil')]
function accueil()
    {

    $nombre = 45;
    $prenom = "Roger";
    return $this->render("base.html.twig", ["nombre" => $nombre, "prenom" => $prenom]);
}

#[Route('/test/heritage')]
function heritage()
    {
    return $this->render("test/heritage.html.twig"); // ici c'est le chemin pour la view
}

#[Route('/test/transitif')]
public function transitif(){
    return $this->render("test/transitif.html.twig");// ici c'est le chemin pour la view
}

#[Route('/test/variables')]

public function tableau(){

    $tab = ["jour" => "07" , "mois"=> "mai", "annee"=> 2021];
    return $this->render("test/variables.html.twig",[
        "tableau"=> $tab,
        "tableau2" => [45 , "test", true],
        "nombre" => 0,
        "chaine" => ""
    ]);
}

#[Route('/test/salutation/{prenom?}')]




public function salutation($prenom){
$prenom=$prenom?? "inconnu";
return $this->render("test/salutation.html.twig",
[
 "prenom"=> $prenom
 // "nombre => 456
]);

//EXO:créez la vue et afficher dans la balise h1
//bonjour prenom
}

/*--------------------------------------------------- */
/** 
* @Route("/test/calcul/{nb1?}/{nb2}", name="test_calcul", requirements={"nb1"="[0-9]+", "nb2"="[0-9]+"})
*/

#[Route('/test/calcul/{nb1}/{nb2}', name:'test_calcul', requirements:['nb1'=>'[0-9]+', 'nb2'=>'[0-9]+'])]

public function calcul($nb1,$nb2)
{
    return $this->render("test/calcul.html.twig",["nb1"=>$nb1, "nb2"=> $nb2]);
}

/**
     *z EXO : créez une nouvelle route qui va prendre
     *  2 paramètres dans l'url et qui va affichez la 
     * valeur de l'addition, la multiplication, la soustraction
     * et la division des 2 nombres passés en paramètres
     * 
     * Si le 2ième paramètres est 0, il ne faut pas afficher
     * le résultat de la division (affichez "Division par 0 impossible")

 */
}

