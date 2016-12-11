<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 12/10/16
 * Time: 9:12 PM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findProductsByName($productName)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT price FROM AppBundle:Product"
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
