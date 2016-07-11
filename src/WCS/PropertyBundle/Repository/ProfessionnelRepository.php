<?php

namespace WCS\PropertyBundle\Repository;

/**
 * ProfessionnelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfessionnelRepository extends \Doctrine\ORM\EntityRepository
{
	public function getLatLng($latitude, $longitude, $radius)
	{

		$qb = $this->createQueryBuilder('LatLng');

        $qb->select('LatLng.profNom as nom',
        			'LatLng.profLatitude as lat',
        			'LatLng.profLongitude as lng')
        	->addSelect('( 6371 * acos(cos(radians(' . $latitude . ')) * cos( radians( LatLng.profLatitude ) ) * cos( radians( LatLng.profLongitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( LatLng.profLatitude ) ) ) ) as radius')
            ->having('radius < :radius')
            ->orderBy('radius', 'ASC')
            ->setParameter('radius', $radius);
        ;
    
        return $qb->getQuery()->getResult();    
	}
}