<?php

namespace App\Controller;

use App\Entity\Contact;
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
    public function show(Request $request)
    {
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class, ['label'=> 'Name', 'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('email', EmailType::class, ['label'=> 'Email', 'attr' => ['class' => 'form-control']])
            ->add('subject', TextType::class, ['label'=> 'Subject', 'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('message', TextareaType::class, ['label'=> 'Message','attr' => ['class' => 'form-control']])
            ->add('Save', SubmitType::class, ['label'=> 'Submit', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        //$form->handleRequest($request);

        return $this->render('single/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}