<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    public function __construct(
        private EntityManagerInterface $doctrine,
        private ContactRepository $contactRepository
    ) {}

    /**
     * @return Collection&Contact[]
     */
    public function getAllContacts(): Collection
    {
        return new ArrayCollection($this->contactRepository->findAll());
    }

    public function getById(int $contactId): Contact
    {
        return $this->contactRepository->find($contactId) ?? new Contact();
    }

    public function save(Contact $contact): void
    {
        $this->doctrine->persist($contact);
        $this->doctrine->flush();
    }

    public function delete(Contact $contact): void
    {
        if ($contact->isPresent() === false) {
            return;
        }

        $this->doctrine->remove($contact);
        $this->doctrine->flush();
    }
}
