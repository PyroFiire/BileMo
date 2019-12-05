<?php

namespace App\DTO;

use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class PersonDTO
{
    private $id;
    private $email;
    private $firstname;
    private $lastname;

    public function __construct(
        Person $person
    )
    { 
        $this->id = $person->getId();
        $this->email = $person->getEmail();
        $this->firstname = $person->getFirstname();
        $this->lastname = $person->getLastname();
    }

    public function getPeopleDTO(Array $people)
    {
        foreach ($people as $person) {
            $personDTO = new self($person);
            $peopleDTO[] = $personDTO;
        }
        return $peopleDTO;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }
}
