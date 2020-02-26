<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Guzzle\Http\Client;
use App\Utils\SpotifyService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use GuzzleHttp\Exception\BadResponseException;



class SpotifyController extends AbstractController
{
    /**
     * @Route("/spotify", name="spotify")
     */
    public function index()
    {
        return $this->render('spotify/index.html.twig', [
            'controller_name' => 'SpotifyController',
        ]);
    }





    
}
