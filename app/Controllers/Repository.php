<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Repositories;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class Repository extends BaseController
{

    public function list()
    {
        return view('repository/list');
    }

    public function loadData() {
        $model = new Repositories();
        $data = $model->findAll();
        $response = [];
        foreach($data as $element) {
            $response[] = array_values($element);
        }

        return json_encode([
            "data" =>  $response
        ]);
    }

    public function synchonize() {
        $client = \Config\Services::curlrequest();

        // Limitation (60 request/sec)
        $response = $client->request('GET', 'https://api.github.com/search/repositories?q=language:php&per_page=100', [
            'headers' => [
                'User-Agent' => 'codeigniter/4.0',
            ],
        ]);

        $objResponse = json_decode($response->getBody()); 
        
        $repositories = [];

        foreach($objResponse->items as $r) {
            $repositories[] = [
                "id"                => $r->id,
                "name"              => $r->name,
                "url"               => $r->url,
                "description"       => $r->description,
                "created_date"      => $r->created_at,   
                "last_push_date"    => $r->pushed_at,   
                "stars"             => $r->stargazers_count
            ];
        }

        $model = new Repositories();

        return json_encode([
            "success" => $model->processRepositories( $repositories ) 
        ]);

    } 
}
