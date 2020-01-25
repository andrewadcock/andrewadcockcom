<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="app_contact")
     */
    public function show(EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $contact = new Contact();
            $contact->setName($data['name']);
            $contact->setEmail($data['email']);
            $contact->setSubject($data['subject']);
            $contact->setMessage($data['message']);

            $em->persist($contact);
            $em->flush();

            // Todo: Create Thank you page or something
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('single/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contact", name="contact_list")
     */
    public function list(ContactRepository $contactRepository) {

        // Get all contacts
        $contacts = $contactRepository->findAll();

        return $this->render('admin/contact-list.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}