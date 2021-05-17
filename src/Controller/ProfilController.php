<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Livre , App\Entity\Emprunt;
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
    public function emprunter(EntityManagerInterface $em,Livre $livre){
        $emprunt = new Emprunt;
        $emprunt->setLivre($livre);
        $emprunt->setAbonne($this->getUser() );
        $emprunt->setDateEmprunt(new \DateTime("now"));
       
        $em->persist($emprunt);
        $em->flush();
        return $this->redirectToRoute("profil_index");


    }
}
