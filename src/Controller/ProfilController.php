<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Livre , App\Entity\Emprunt;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;



class ProfilController extends AbstractController
{
    /**
     * @Route("/profil" , name="profil_index")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
    
     */
    

    public function index(): Response
    {
        //$abonneConnecte = $this->getUser();
        //$listeEmprunts = $abonneConnecte->getEmprunts();
        return $this->render('profil/index.html.twig');
    }

    /**
     * @Route("/profil/emprunter/{id}" , name="profil_emprunter")
     */
    public function emprunter(EntityManagerInterface $em,LivreRepository $lr,Livre $livre){
        $livresNonDisponibles =$lr->LivresNonDisponibles();
        // in_array($aiguilles,$botteDeFoin) permet de tester la présence d'une valeur dans un tableau
        if(in_array($livre, $livresNonDisponibles)){
            $this->addFlash("danger", "Ce livre est indisponible");
            return $this->redirectToRoute("home");


        }else{
        $emprunt = new Emprunt;
        $emprunt->setLivre($livre);
        $emprunt->setAbonne($this->getUser() );
        $emprunt->setDateEmprunt(new \DateTime("now"));
       
        $em->persist($emprunt);
        $em->flush();
        return $this->redirectToRoute("profil_index");
    }

    }
}
