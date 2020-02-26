<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class ApiController extends AbstractController
{
   /**
     * @Route("/", name="index")
     */
    public function homePage(HttpClientInterface $httpClient)
    {
        $response = $httpClient->request('GET', 'https://api.github.com/users/ismail1432/repos',[
            'query' => [
                'sort' => 'created',
            ],
        ]);
        /*dd($response->toArray());*/
        

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
            'repos'=> $response->toArray()
        ]);
    }





   /**
     * @Route("/show/{id}", name="show")
     */
    public function showPage($id, HttpClientInterface $httpClient)
    {
        $response = $httpClient->request('GET', 'https://api.github.com/repositories/'.$id );
        

        return $this->render('api/show.html.twig', [
            'repos'=> $response->toArray()
        ]);
    }




    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
