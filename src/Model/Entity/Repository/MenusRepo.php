<?php
namespace CostAclNavigation\Model\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\AbstractQuery;
use CostAuthorization\Model\Entity\Permissions;

class MenusRepo extends EntityRepository
{
    /**
     * 
     * @param string $module
     */
    public function getNavigatorByModule($module=null,$hydrationMode = AbstractQuery::HYDRATE_ARRAY)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m');
        $qb->from('CostAclNavigation\Model\Entity\Menus', 'm');
        $qb->join('m.permission', 'p');
        $qb->orderBy('m.parentId', 'ASC');
        $qb->orderBy('m.order', 'ASC');
        $results = $qb->getQuery()->getResult();
        return $results;
    }
}

?>