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
    private $_links;

    public function __construct(
        Person $person
    ) {
        $this->id = $person->getId();
        $this->email = $person->getEmail();
        $this->firstname = $person->getFirstname();
        $this->lastname = $person->getLastname();
        $this->_links = $person->get_links();
    }

    public function getPeopleDTO(array $people)
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

    public function get_Links(): ?array
    {
        return $this->_links;
    }

    public function set_Links(array $links): self
    {
        $this->_links = $links;

        return $this;
    }
}
