<?php

namespace App\Console\Commands;

use App\Article;
use App\Source;
use GuzzleHttp\Client;
use Illuminate\Console\Command;


class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles_no = 0;

        $sources = Source::all();

        foreach($sources as $source)
        {
            $source_articles_no = 0;

            $client = new Client();
        
            $res = $client->request('GET', 'http://newsapi.org/v1/articles', [
                'query' => [
                    'apiKey' => env('NEWS_API_KEY'),
                    'source' => $source->source_id
                ]
            ]);

            $result = json_decode($res->getBody()->getContents());
            $articles = $result->articles;

            foreach($articles as $article)
            {
                $a = Article::where('source_id', '=', $source->source_id)
                        ->where('title', '=', $article->title)
                        ->first();

                if(!$a)
                {
                    $a = new Article;
                    $a->author = $article->author;
                    $a->source_id = $source->source_id;
                    $a->title = $article->title;
                    $a->description = $article->description;
                    $a->url = $article->url;
                    $a->urlToImage = $article->urlToImage;
                    $a->publishedAt = $article->publishedAt;
                    $a->save();
                    
                    $source_articles_no++;
                }
            }

            // echo $source_articles_no." articles";
        
        }

        // echo $articles_no." articles";

    }
}