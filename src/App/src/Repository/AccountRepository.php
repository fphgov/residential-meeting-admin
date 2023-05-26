<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

final class AccountRepository extends EntityRepository
{
    /** @var return \App\Entity\AccountInterface[] */
    public function findAccounts(
        string $zipCode,
        string $name,
        ?string $address
    ): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.zipCode = :zipCode')
            ->andWhere(
                $qb->expr()->like('a.lastname', ':name')
            )
            ->setParameters([
                'zipCode'     => $zipCode,
                'name'        => '%' . $name . '%',
            ]);

        if ($address !== null) {
            $qb
                ->andWhere('a.address LIKE :address')
                ->setParameter('address', '%' . $address . '%');
        }

        $qb->addOrderBy('a.fullName', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
