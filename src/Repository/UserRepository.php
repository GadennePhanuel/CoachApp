<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    public function switchPlayerToAllowed($userId){
        $cnx = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE user
            SET roles = :roles
            WHERE id = :id_user
        ';
        $stmt = $cnx->prepare($sql);
        $stmt->execute([
            'id_user' => $userId,
            'roles' =>  JSON_encode(["ROLE_PLAYER"])
        ]);
    }

    public function switchPlayerToNotAllowed($userId){
        $cnx = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE user
            SET roles = :roles
            WHERE id = :id_user
        ';
        $stmt = $cnx->prepare($sql);
        $stmt->execute([
            'id_user' => $userId,
            'roles' => JSON_encode(["ROLE_NOT_ALLOWED","ROLE_PLAYER"])
        ]);
    }

    public function switchCoachToAllowed($userId){
        $cnx = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE user
            SET roles = :roles
            WHERE id = :id_user
        ';
        $stmt = $cnx->prepare($sql);
        $stmt->execute([
            'id_user' => $userId,
            'roles' => JSON_encode(["ROLE_COACH"])
        ]);
    }

    public function switchCoachToNotAllowed($userId){
        $cnx = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE user
            SET roles = :roles
            WHERE id = :id_user
        ';
        $stmt = $cnx->prepare($sql);
        $stmt->execute([
            'id_user' => $userId,
            'roles' => JSON_encode(["ROLE_NOT_ALLOWED","ROLE_COACH"])
        ]);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
