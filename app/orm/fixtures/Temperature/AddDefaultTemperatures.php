<?php namespace App\Orm\Fixtures\Temperature;

use Api\Temperature\Entity\Temperature;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class AddDefaultTemperatures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $temperature = new Temperature(1, 10, new \DateTime('2015-01-01T15:00:00+00:00'));
        $manager->persist($temperature);

        $temperature = new Temperature(2, 11, new \DateTime('2015-01-02T15:10:10+00:00'));
        $manager->persist($temperature);

        $temperature = new Temperature(3, 12, new \DateTime('2015-01-03T15:20:20+00:00'));
        $manager->persist($temperature);

        $manager->flush();

        echo __CLASS__, "\n";
    }
}
