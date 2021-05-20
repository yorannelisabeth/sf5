<?php

namespace App\Repository;

use App\Entity\Livre ,App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
    * @return Livre[] Returns an array of Livre objects
    */
    
    public function findByMot($value)
    {
        /*

        SELECT * FROM livre l  WHERE l.titre LIKE "%mot%"

        slect tous les livres dont le titre du livre contient mot    mot fais reference a ce que l'on tappe dans la barre de recherche
        */
        return $this->createQueryBuilder('l') // obliger de definir un alias a la table généralement comme ici c'est deja preparer il prenne la première lettre du repository ici l de livre
            ->where("l.titre LIKE :mot ")
           // ->andWhere('l.exampleField = :val') cette ligne est pour si on souhaite ajouter d'autre clause where en plsud e la première 
            ->setParameter('mot', "%" . $value . "%" )
            ->orderBy('l.auteur', 'ASC')
            ->addOrderBy("l.titre")
           // ->setMaxResults(10) si on souhaite en afficher que un certain nombre
            ->getQuery()
            ->getResult()
        ;
    }
 public function LivresNonDisponibles()
 {
      /*
      explication 15h19 le 18/05/2021

        SELECT l.*  
        FROM livre l JOIN emprunt e ON l.id = e.livre_id
        WHERE e.date_retour IS null

       
        */
     return $this->createQueryBuilder("l")
     ->join(Emprunt::class, "e", "WITH","l.id = e.livre")
     ->where("e.date_retour IS NULL")
     ->orderBy("l.auteur")
     ->addOrderBy("l.titre")
     ->getQuery()
     ->getResult()
     ;
 }

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
