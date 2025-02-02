<?php

Radjax\Route::get("/search/api", ["post"], "App\Controllers\SearchController@api", ["protected" => true, "session_saved" => false]);
Radjax\Route::get("/more/comments", ["post"], "App\Controllers\Comment\CommentController@lastComment", ["protected" => true, "session_saved" => false]); 
 
$access = 'App\Middleware\Before\UserAuth@index'; 
Radjax\Route::get("/post/profile", ["post"], "App\Controllers\Post\PostController@postProfile", ["protected" => true, "before" => $access]);
Radjax\Route::get("/post/recommend", ["post"], "App\Controllers\Post\AddPostController@recommend", ["protected" => true, "before" => $access]);
Radjax\Route::get("/folder/content/del", ["post"], "App\Controllers\FolderController@delFolderContent", ["protected" => true, "before" => $access]);
Radjax\Route::get("/folder/del", ["post"], "App\Controllers\FolderController@delFolder", ["protected" => true, "before" => $access]);

Radjax\Route::get("/focus", ["post"], "App\Services\Subscription", ["protected" => true, "before" => $access]);
Radjax\Route::get("/votes", ["post"], "App\Services\Votes", ["protected" => true, "before" => $access]);
Radjax\Route::get("/favorite", ["post"], "App\Services\Favorite", ["protected" => true, "before" => $access]);
Radjax\Route::get("/ignored", ["post"], "App\Services\Ignored", ["protected" => true, "before" => $access]);
Radjax\Route::get("/best", ["post"], "App\Services\AnswerBest", ["protected" => true, "before" => $access]);
Radjax\Route::get("/flag/repost", ["post"], "App\Services\Audit", ["protected" => true, "before" => $access]);
Radjax\Route::get("/notif", ["post"], "App\Controllers\NotificationController@get", ["protected" => false, "before" => $access]);