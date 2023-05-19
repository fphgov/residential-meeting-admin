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
        ?string $address,
        ?string $houseNumber
    ): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.zipCode = :zipCode')
            ->andWhere('a.fullName LIKE :name')
            ->setParameters([
                'zipCode'     => $zipCode,
                'name'        => '%' . $name . '%',
            ]);

        if ($address !== null) {
            $qb
                ->andWhere('a.address LIKE :address')
                ->setParameter('address', '%' . $address . '%');
        }

        if ($houseNumber !== null) {
            $qb
                ->andWhere('a.houseNumber LIKE :houseNumber')
                ->setParameter('houseNumber', '%' . $houseNumber . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
