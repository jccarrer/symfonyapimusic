<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Guzzle\Http\Client;
use App\Utils\SpotifyService;
/*use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;*/






class GuzzleController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @Route("/guzzle", name="guzzle")
     */
    
    public function index()
    {

   
        $client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.github.com/users/ismail1432/',
            // You can set any number of default request options.
            'timeout'  => 2.0,]);

            $response = $client->request('GET', 'repos',[
                'query' => [
                    'sort' => 'created',
                ],
            ]);
            
            $array="Something else";
            
            if($response->getStatusCode() == 200){
                $array = json_decode($response->getBody()->getContents(), true); // :'(
                    echo $response->getStatusCode();//200
            }
            
                /*var_dump($array[1]['name']);*/

            /*echo $response->getBody();
            $response = $request->send();*/

        /*dd($response);*/



        return $this->render('guzzle/index.html.twig', [
            'controller_name' => 'GuzzleController',
            'repos' => $array
        ]);
    }



    /**
     * @Route("/guzzle2", name="guzzle2")
     */
    public function lecturadeusuario()
    {

        //necesario para coneccion
        $client_id = '497e3c5685fd401397db74453d27f408'; // Your client id
        $client_secret = '1845baf283494bbb85ac816e9cf799f9'; // Your secret
        $redirect_uri = 'http://localhost:8000/guzzle2/'; // Your redirect uri
        $scopes = 'playlist-read-private';
        

        $session = new \SpotifyWebAPI\Session(
            $client_id,
            $client_secret,
            $redirect_uri
        );
        


        




        $api = new \SpotifyWebAPI\SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());
        //dd($api);
            $repos = json_decode(json_encode($api->me()), true);   

            print_r($api->me());

            
            $accessToken = $session->getAccessToken();
            $refreshToken = $session->getRefreshToken();

            $AccessTokenSesion = $this->session->get('accesstoken',$accessToken);
            $RefreshTokenSesion = $this->session->get('refreshtoken',$refreshToken);

            $api->setAccessToken($accessToken);

            print_r(
                $api->getTrack('7EjyzZcbLxW7PaaLua9Ksb')
            );

            
            $playlists = $api->getUserPlaylists('jccarrer', [
                'limit' => 5
            ]);
            
            foreach ($playlists->items as $playlist) {
                echo '<br><a href="' . $playlist->external_urls->spotify . '">' . $playlist->name . '</a> <br>';
            }



        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                    'playlist-read-private',
                    'user-read-private',
                ],
            ];
        


            

            
            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }






        //necesario para mostrar en pantalla
        $user_id='jccarrer';
        $token = 'BQDFKs99JornsJ1ltcF7olwOEcIZik4qPrjSTtE5-RFUCxTn9PpLRQGlCC-tdfF-U9XKbRufII9iNLwb265rymYoT0aX8K5ilTulCNoEmG0aUcZBoHElbzV8XlTwTrb5eFU-xhIyVx_xIseIHc2X3vKV';
        $playlist_url = 'https://api.spotify.com/v1/users/'.$user_id.'/playlists';



        





/*

       $client = new \GuzzleHttp\Client([
            'base_uri' => $playlist_url,
            'timeout'  => 2.0]);


            $response = $client->request('GET', '/', [
                'headers' => [
                    'Authorization' => $token
                ]
            ]);

/*
            

            /*$client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.github.com/users/ismail1432/',
            'timeout'  => 2.0,]);
            
            $response = $client->request('GET', 'repos',[
                'query' => [
                    'sort' => 'created',
                ],
            ]);*/
            
/*            $array="Something else";
            
            if($response->getStatusCode() == 200){
                $array = json_decode($response->getBody(), true); // :'(
                echo $response->getStatusCode();    
            }
            
*/

            

            /*echo $response->getBody();
            $response = $request->send();*/

      



        return $this->render('guzzle/spotify.html.twig', [
            'controller_name' => 'GuzzleController',
            'repos' => $api->me(),
            'token'=> $AccessTokenSesion
        ]);
    }    
    








}
