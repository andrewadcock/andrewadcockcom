<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin2", name="app_admin_dashboard")
     */
    public function dashboard()
    {

        return $this->render('admin/dashboard.html.twig');
    }
}