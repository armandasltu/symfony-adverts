<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    /**
     * @Route("/", name="Adverts")
     */
    public function indexAction(Request $request)
    {
        return $this->render('advert/index.html.twig', [
            'content' => 'Output',
        ]);
    }
}
