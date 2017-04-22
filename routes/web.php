<?php

$app->get('/', 'HomeController@index');

$app->get('/sources', 'SourceController@index');

$app->get('/articles', 'ArticleController@index');