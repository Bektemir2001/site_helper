<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class ElasticsearchController extends Controller
{
    protected $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = app('ElasticsearchClient');
    }

    public function index(Request $request)
    {
        // Валидация входящего запроса
        $validated = $request->validate(['search' => 'required']);  // Теперь это будет содержать только 'search'
        $searchTerm = $validated['search'];

        $params = [
            'index' => 'my_index',
            'size'  => 3,
            'body'  => [
                'query' => [
                    'match' => [
                        'header' => $searchTerm
                    ]
                ]
            ]
        ];

        $results = $this->elasticsearch->search($params);



        return response()->json([
            'results' => array_map(function ($hit) {
                $page = Pages::where('id', $hit['_id'])->first();
                if($page)
                {
                    $page = $page->link;
                }
                return [
                    'id' => $hit['_id'],
                    'header' => $hit['_source']['header'],
                    "page" => $page
                ];
            }, $results['hits']['hits'])
        ]);
    }


    public function store()
    {

        $pages = Pages::all();
        foreach ($pages as $page) {
            $resultString = '';
            foreach ($page->headers as $header) {
                $filteredArray = array_filter($header, function ($value) {
                    return $value !== "";
                });
                $resultString .= implode(".", $filteredArray);
            }
            $params = [
                'index' => 'my_index',
                'id'    => $page->id,
                'body'  => ['header' => $resultString, 'domain_id' => 1]
            ];

            $this->elasticsearch->index($params);


        }
        return response()->json(['message' => 'Successfully indexed']);
    }
}

