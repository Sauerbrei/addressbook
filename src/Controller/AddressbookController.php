<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Manager\ContactManager;
use App\Service\FileUploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AddressbookController extends AbstractController
{
    public function __construct(
        private ContactManager $contactManager
    ) {}

    #[Route('/', name: 'addressbook')]
    public function index(): Response
    {
        return $this->render(
            'addressbook_view.html.twig',
            [
                'contactList' => $this->contactManager->getAllContacts(),
            ]
        );
    }

    #[Route('/add', name: 'addressbook_add')]
    public function add(Request $request, FileUploadService $fileUploadService): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();

            if ($picture instanceof UploadedFile) {
                $storeDirectory = $this->getParameter('picture_upload_directory');
                $storedFile = $fileUploadService->storeUpload($picture, $storeDirectory);
                $contact->setPicture($storedFile->getFilename());
                $this->contactManager->save($contact);
            }

            return $this->redirectToRoute('addressbook');
        }

        return $this->renderForm(
            'addressbook_add.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route('/delete/{contactId}', name: 'addressbook_delete')]
    public function delete(int $contactId, Filesystem $filesystem): Response
    {
        $contact = $this->contactManager->getById($contactId);

        if ($contact->isPresent() === false) {
            throw new NotFoundHttpException();
        }

        $filesystem->remove($this->getParameter('picture_upload_directory') . '/' . $contact->getPicture());
        $this->contactManager->delete($contact);
        $this->addFlash('success', 'Contact deleted.');

        return $this->redirectToRoute('addressbook');
    }
}
