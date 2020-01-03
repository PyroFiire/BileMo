<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        //create Users
        $operator = [1 => 'sfr', 2 => 'orange'];

        for ($i = 1; $i <= 2; ++$i) {
            $user = new User();
            $user->setUsername($operator[$i])
                 ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
            ;
            $manager->persist($user);
            $users[] = $user;
        }

        //create People
        for ($i = 1; $i <= 10; ++$i) {
            $person = new Person();
            $person->setEmail($faker->email())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setUserClient($faker->randomElement($users))
            ;
            $manager->persist($person);
        }

        //create Products
        $brands = ['Apple', 'Samsung', 'Huawei', 'Sony', 'Google'];
        $colors = ['Azure', 'Black', 'Cyan', 'Gold', 'Lime', 'Orchid', 'Ruby', 'Silver', 'White'];
        $storageGB = [8, 16, 32, 64];
        $memoryGB = [4, 6, 8, 12, 16];

        for ($i = 1; $i <= 50; ++$i) {
            $product = new Product();
            $product->setBrand($brand = $faker->randomElement($brands))
                    ->setModel($brand.$faker->numberBetween(0, 10))
                    ->setReleaseYear($faker->numberBetween(2015, 2019))
                    ->setColor($faker->randomElement($colors))
                    ->setScreenSize($faker->randomFloat(2, 4, 8))
                    ->setStorageGB($faker->randomElement($storageGB))
                    ->setMemoryGB($faker->randomElement($memoryGB))
                    ->setMegapixels($faker->numberBetween(6, 20))
                    ->setPrice($faker->numberBetween(500, 1200))
            ;
            $manager->persist($product);
        }
        $manager->flush();
    }
}
