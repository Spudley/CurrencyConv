<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\CurrencyCache;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->oneThatIsExpired($manager);
        $this->oneThatIsNotExpired($manager);

        $manager->flush();
    }
    
    private function oneThatIsNotExpired(ObjectManager $manager)
    {
        $cache = new CurrencyCache();
        $cache->setBaseCurrency('GBP');
        $cache->setExchangeRatesJSON(json_encode(['USD' => 0.55, 'EUR' => 0.95]));
        $cache->setExpiresAt(DateTime('now + 20 days'));
        $manager->persist($cache);
    }

    private function oneThatIsExpired(ObjectManager $manager)
    {
        $cache = new CurrencyCache();
        $cache->setBaseCurrency('CAD');
        $cache->setExchangeRatesJSON(json_encode(['USD' => 1.25, 'JPY' => 95.80]));
        $cache->setExpiresAt(DateTime('now - 20 days'));
        $manager->persist($cache);
    }
}
