<?php

namespace App\Http\Controllers;

use App\Article;
use DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $db = DB::table('articles')->leftJoin('sources', 'articles.source_id', '=', 'sources.source_id');

        $allowed_article_columns = ['author', 'title'];
        $allowed_source_columns = ['source_id', 'name', 'category', 'language', 'country'];

        foreach($allowed_article_columns as $column)
        {
            if ($request->has($column))
            {
                $db = $db->where('articles.'.$column, '=', $request->input($column));
            }
        }

        foreach($allowed_source_columns as $column)
        {
            if ($request->has($column))
            {
                $db = $db->where('sources.'.$column, '=', $request->input($column));
            }
        }

        if ($request->has('limit'))
        {
            $db = $db->take(intval($request->input('limit')));
        }

        if ($request->has('sortBy'))
        {
            $db = $db->orderBy($request->input('sortBy'));
        }

        $articles = $db->select('*', 'articles.url')->get();

        return $articles;
    }
}
