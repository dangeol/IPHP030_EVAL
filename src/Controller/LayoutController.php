<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    public function index()
    {
		return $this->render('layout/layout.html.twig');
    }
}
