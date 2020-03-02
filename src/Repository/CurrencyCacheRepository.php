<?php

namespace App\Repository;

use App\Entity\CurrencyCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use DateTimeInterface;

/**
 * @method CurrencyCache|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyCache|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyCache[]    findAll()
 * @method CurrencyCache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyCacheRepository extends ServiceEntityRepository
{
    private $manager = null;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        $this->manager = $manager;

        parent::__construct($registry, CurrencyCache::class);
    }

    public function findUnexpiredCacheByCurrency(string $currency): ?CurrencyCache
    {
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.baseCurrency = :curr')
            ->andWhere('c.expiresAt >= :now')
            ->setParameter('curr', $currency)
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getResult();
        if ($result && count($result)) {
            return $result[0];
        }
        return null;
    }

    public function saveCacheForCurrency(string $currency, string $json, DateTimeInterface $expiry)
    {
        $currencyCache = $this->findOneBy(['baseCurrency' => $currency]);
        if ($currencyCache) {
            $this->updateCacheForCurrency($currencyCache, $json, $expiry);
        } else {
            $this->createCacheForCurrency($currency, $json, $expiry);
        }
    }

    private function updateCacheForCurrency(CurrencyCache $currencyCache, string $json, DateTimeInterface $expiry)
    {
        $currencyCache->setExchangeRatesJSON($json);
        $currencyCache->setExpiresAt($expiry);
        $this->manager->persist($currencyCache);
        $this->manager->flush();
        
    }

    private function createCacheForCurrency(string $currency, string $json, DateTimeInterface $expiry)
    {
        $newCurrencyCache = new CurrencyCache();

        $newCurrencyCache
            ->setBaseCurrency($currency)
            ->setExchangeRatesJSON($json)
            ->setExpiresAt($expiry);

        $this->manager->persist($newCurrencyCache);
        $this->manager->flush();
    }

    public function deleteAllCache()
    {
        $query = $this->createQueryBuilder('c')
            ->delete()
            ->getQuery();

        return $query->execute();
    }
    /*
    public function findOneBySomeField($value): ?CurrencyCache
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
