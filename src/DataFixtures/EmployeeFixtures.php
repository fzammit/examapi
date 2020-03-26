<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Repository\JobRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EmployeeFixtures extends Fixture
{
    private $jobRepository;

    public  function __construct(JobRepository $jobRepository) {
        $this->jobRepository = $jobRepository;

    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $employee = new Employee();
            $employee->setFirstname($faker->firstName);
            $employee->setLastname($faker->lastName);
            $employee->setEmployementDate($faker->dateTime);
            $employee->setJob($this->jobRepository->find(rand(6, 10)));
            $manager->persist($employee);
        }

        $manager->flush();
    }
}
