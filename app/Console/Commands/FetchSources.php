<?php

namespace App\Console\Commands;

use App\Source;
use GuzzleHttp\Client;
use Illuminate\Console\Command;


class FetchSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sources';

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
        $client = new Client();
        
        $res = $client->request('GET', 'http://newsapi.org/v1/sources', [
            'query' => [
                'apiKey' => env('NEWS_API_KEY')
            ]
        ]);

        $result = json_decode($res->getBody()->getContents());
        $sources = $result->sources;
        $source_no = 0;

        foreach($sources as $source)
        {
            $s = Source::where('source_id', '=', $source->id)->first();
            if(!$s)
            {
                $s = new Source;
                $s->source_id = $source->id;
                $s->name = $source->name;
                $s->description = $source->description;
                $s->url = $source->url;
                $s->category = $source->category;
                $s->language = $source->language;
                $s->country = $source->country;
                $s->urlsToLogosSmall = $source->urlsToLogos->small;
                $s->urlsToLogosMedium = $source->urlsToLogos->medium;
                $s->urlsToLogosLarge = $source->urlsToLogos->large;
                $s->save();
                
                $source_no++;
            }
        }

        // echo $source_no." sources";
    }
}