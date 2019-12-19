<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadProducts extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getGroups(): array
    {
        return ['products'];
    }

    public function load(ObjectManager $manager)
    {
        //create Users
        $user = new User();
        $user->setUsername('admin')
             ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
        ;
        $manager->persist($user);

        //create Products
        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone 6S')
                ->setReleaseYear(2015)
                ->setColor('Space Gray')
                ->setScreenSize(4.7)
                ->setStorageGB(32)
                ->setMemoryGB(2)
                ->setMegapixels(12)
                ->setPrice(449)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone 6')
                ->setReleaseYear(2014)
                ->setColor('Silver')
                ->setScreenSize(4.7)
                ->setStorageGB(64)
                ->setMemoryGB(1)
                ->setMegapixels(8)
                ->setPrice(319)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone 8')
                ->setReleaseYear(2017)
                ->setColor('Gold')
                ->setScreenSize(4.7)
                ->setStorageGB(64)
                ->setMemoryGB(2)
                ->setMegapixels(12)
                ->setPrice(449)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone X')
                ->setReleaseYear(2017)
                ->setColor('Space Gray')
                ->setScreenSize(5.8)
                ->setStorageGB(256)
                ->setMemoryGB(3)
                ->setMegapixels(12)
                ->setPrice(1149)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone XS Max')
                ->setReleaseYear(2018)
                ->setColor('Gold')
                ->setScreenSize(6.5)
                ->setStorageGB(256)
                ->setMemoryGB(4)
                ->setMegapixels(8)
                ->setPrice(1249)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Apple')
                ->setModel('iPhone 11')
                ->setReleaseYear(2019)
                ->setColor('Black')
                ->setScreenSize(6.1)
                ->setStorageGB(64)
                ->setMemoryGB(4)
                ->setMegapixels(12)
                ->setPrice(999)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Samsung')
                ->setModel('Galaxy S9 Plus')
                ->setReleaseYear(2018)
                ->setColor('Coral Blue')
                ->setScreenSize(6.2)
                ->setStorageGB(64)
                ->setMemoryGB(3)
                ->setMegapixels(8)
                ->setPrice(699)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Samsung')
                ->setModel('Galaxy S8 Plus')
                ->setReleaseYear(2017)
                ->setColor('Midnight Black')
                ->setScreenSize(6.2)
                ->setStorageGB(64)
                ->setMemoryGB(4)
                ->setMegapixels(8)
                ->setPrice(589)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Samsung')
                ->setModel('Galaxy Note 9')
                ->setReleaseYear(2018)
                ->setColor('Blue')
                ->setScreenSize(6)
                ->setStorageGB(128)
                ->setMemoryGB(6)
                ->setMegapixels(12)
                ->setPrice(999)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Samsung')
                ->setModel('Galaxy S10')
                ->setReleaseYear(2019)
                ->setColor('prism Black')
                ->setScreenSize(6.1)
                ->setStorageGB(128)
                ->setMemoryGB(8)
                ->setMegapixels(12)
                ->setPrice(899)
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setBrand('Samsung')
                ->setModel('Galaxy S8')
                ->setReleaseYear(2017)
                ->setColor('Arctic Silver')
                ->setScreenSize(5.8)
                ->setStorageGB(64)
                ->setMemoryGB(4)
                ->setMegapixels(12)
                ->setPrice(499)
        ;
        $manager->persist($product);

        $manager->flush();
    }
}
