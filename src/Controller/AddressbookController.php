<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressbookController extends AbstractController
{
    public function __construct(
        private ContactRepository $contactRepository
    ) {}

    #[Route('/', name: 'addressbook')]
    public function index(): Response
    {
        $contactList = $this->contactRepository->findAll();

        return $this->render(
            'addressbook_view.html.twig',
            [
                'contactList' => $contactList,
            ]
        );
    }
}
