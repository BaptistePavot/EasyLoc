<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BorrowerController extends AbstractController
{
    /**
     * @Route("/borrower", name="borrower")
     */
    public function index()
    {
        return $this->render('borrower/index.html.twig', [
            'controller_name' => 'BorrowerController',
        ]);
    }
}
