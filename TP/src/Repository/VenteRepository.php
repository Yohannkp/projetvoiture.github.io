<?php

namespace App\Repository;

use App\Entity\Vente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\EtatRepository;

/**
 * @method Vente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vente[]    findAll()
 * @method Vente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vente::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Vente $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Vente $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByEtat(\App\Repository\VoitureRepository $voiture,\App\Entity\Vente $vente,\Doctrine\ORM\EntityManagerInterface $em,\App\Repository\EtatRepository $etat){
        $vendu = $etat->find(2);
        foreach($voiture->findAll() as $element){
           /* if($element->getMarque() == $vente->getVoiture()->getMarque())
            {   
                foreach($etat->findAll() as $a){
                    if($a->getStatut() == "Vendu"){
                        $element->setEtat($a);
                    }

                }
                
                $em->persist($element);
                $em->flush();
            }*/
        }
    }

    public function findByYear($debut,$fin){
        return $this->createQueryBuilder("c")
            ->Where('c.dateVente > ?1')
            ->andWhere('c.dateVente < ?2')
            ->setParameter("1", $debut)
            ->setParameter("2", $fin)
            ->getQuery()
            ->getResult()
    ;
    }

    

    // /**
    //  * @return Vente[] Returns an array of Vente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vente
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
