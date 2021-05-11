<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//ligne de dessous ajouter avant enregistrement le 10/05/2021 14h19
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Form\LivreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/admin')]
//Toutes les routes de ce controleur vont commencer par "/admin"
class LivreController extends AbstractController
{
    //
    // @Route("/livre", name="livre)
    // @IsGranted("ROLE_ADMIN")
    
  

    #[Route('/livre', name: 'livre')]
    #[isGranted('ROLE_ADMIN')]
    public function index(LivreRepository $livreRepository): Response
    /*Pour récupéré la   liste de tous les livres enregistrée en bdd, je vais utiliser la classe Livre Repository, Les classes Repository permettent de faire des requète SELECT sur la table correspondante
    Vous ne pouvez pas instancier un objet de la classe Repository (come Request , EntityManager, ...)
    il faut donc utiliser l'injection de dépendance
    c'est a dire que la classe à utiliser est passée en paramètre d'une focntion et sera instancié directement par symfony
    La methode  'findAll' récupère donc tous les enregistrement d'une table et retourne une liste d'objet Entity
    */
    //EN gros findall() c'est comme le SELECT * FROM
    {
        $livres = $livreRepository->findAll();

        return $this->render('livre/index.html.twig', [
            'livres' => $livres
        ]);
    }

    #[Route('/livre/ajouter', name: 'livre_ajouter')]
    public function ajouter(Request $request, EntityManager $em)
    {
        //dump($request);// c'est comme un var_dump();

        if ($request->isMethod("POST")){
            /*l'objet de la classe Request a des propriétés qui contiennenet les valeurs de toutes les variables superglobales de PHP ($_GET,$_POST, ...)
            Pour $_POST, la propriété 'request'
            Ces propriétés sont des objets. Avec la focntion get , je peux récupérer la valeur de l'indice demandé  */
            $titre = $request->request->get("titre");
            $auteur = $request->request->get("auteur");

            $livre = new Livre;
            $livre->setTitre($titre);
            $livre->setAuteur($auteur);
            
            //la classe EntityManager va permettre d'enregistrer en base de données
            //la méthode 'persist' permet de préparer une requête INSERT INTO à partir d'un objet d'une classe Entity
            $em->persist($livre);
            // la methode 'flush' éxécute toutes les requètes SQL en attente
            $em->flush();

            return $this->redirectToRoute("livre");
            //Pour fair eune redirection vers une route existante, on utilise redirectToRoute avec le name d'une route en paramètre

            //dd($titre, $auteur); // dd veut dire dump and die execute et arrète  en gros affiche une variable et arrete l'execution du php (fonction die )
        }
        return $this->render('livre/formulaire.html.twig');
    }

    #[Route('/livre/nouveau', name: 'livre_nouveau')]
    //resumer cours le 11/05/2021 09h35
    //class entityManager va nous permettre d'enregistrer en base de donné (CRUD)
    public function nouveau(Request $request, EntityManager $em){
        $livre= new livre;
        $formLivre = $this->createForm(LivreType::class ,$livre);
        // handleRequest : permet à la variable $formLivre de gérer les information envoyés par le navigateur
        $formLivre->handleRequest($request);
        if($formLivre->isSubmitted() && $formLivre->isValid()){
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute("livre");
        } 
        
        return $this->render("livre/form.html.twig",["form" => $formLivre->createView()]);


    }

    #[Route('/livre/modifier/{id}', name: 'livre_modifier', requirements:['id' => '\d+'])]

    public function modifier(EntityManager $em, Request $request, LivreRepository $lr,$id)
    {

        $livre= $lr->find($id); // la methode 'find' permet de récupérer un enregistrement avec son Identifiant
        $formLivre = $this->createForm(LivreType::class ,$livre);
        // handleRequest : permet à la variable $formLivre de gérer les information envoyés par le navigateur
        $formLivre->handleRequest($request);
        if($formLivre->isSubmitted() && $formLivre->isValid()){
            /* $em->persist($livre);
                Pour modifier un enregistrement, pas besoin d'utiliser la methode 'persist' de l'EntityManager
                Toutes les variables entités qui ont un id non nulle vont ètre enregistrées en bdd quand la methode 'flush' sera appelé
            */
            $em->flush();
            return $this->redirectToRoute("livre");
        } 
        
        return $this->render("livre/form.html.twig",["form" => $formLivre->createView()]);

    }

    #[Route('/livre/supprimer/{id}', name: 'livre_supprimer', requirements:['id' => '\d+'])]
    //En passant un objet Livre comme paramètre de la methode supprimer, $livre sera récupéré dans la base de données selon la valeur {id} passé dans l'URL de la route

    public function supprimer(EntityManager $em, Request $request, Livre $livre)
    {
       // dump($_POST);
       if ($request->isMethod("POST")){
           //la methode 'remove()' prépare la requète DELETE
           $em->remove($livre);
           $em->flush();
           return $this->redirectToRoute("livre");
       }
        return $this->render("livre/supprimer.html.twig",["livre" => $livre]);
    }
    

}
