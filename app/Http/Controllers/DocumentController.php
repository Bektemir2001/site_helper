<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Pages;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOSTS')])
            ->build();
    }

    public function store(Request $request)
    {
        $pages = Pages::all();
        dd($pages);

        foreach ($pages as $page) {
            $resultString = '';
            foreach ($page->headers as $header) {
                $filteredArray = array_filter($header, function ($value) {
                    return $value !== "";
                });
                $resultString .= implode(".", $filteredArray);
            }
            Document::create([
                "domain_id" => 1,
                "page_id" => $page->id,
                "header" => $resultString,
            ]);
        }

        return response()->json(['message' => 'Document created']);
    }

    public function search(Request $request)
    {
        $documents = Document::search($request->get('query'))->get();
        return response()->json($documents);
    }
}
