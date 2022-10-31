<?php

namespace App\Repository;

use App\Entity\EndUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<EndUser>
 *
 * @method EndUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method EndUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method EndUser[]    findAll()
 * @method EndUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EndUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, ApiTokenRepository $apiTokenRepository)
    {
        parent::__construct($registry, EndUser::class);
        $this->apiTokenRepository = $apiTokenRepository;
    }
    public function findByApiToken(string $apiToken): ?EndUser
    {
        return $this->apiTokenRepository->findOneBy(['token' => $apiToken])?->getUser();
    }

    public function save(EndUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EndUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof EndUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

//    /**
//     * @return EndUser[] Returns an array of EndUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EndUser
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
