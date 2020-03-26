<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $job = new Job;
        $job->setTitle("Snowtrooper");

        $manager->persist($job);
        $job = new Job;
        $job->setTitle("ettrooper");

        $manager->persist($job);
        $job = new Job;
        $job->setTitle("Stormtrooper");

        $manager->persist($job);

        $job = new Job;
        $job->setTitle("Swamptrooper");

        $manager->persist($job);

        $job = new Job;
        $job->setTitle("Fieldtrooper");

        $manager->persist($job);

        $manager->flush();

        $manager->flush();
    }
}
