<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Search\SearchRequest;
use App\Http\Resources\Api\Search\SearchResource;

use App\Models\User;
use Carbon\Carbon;

class SearchController extends Controller
{
   public function __invoke(SearchRequest $request)
   {
       if($request->validated()) {

           $countOfRows = $request['limit'] ?? 10;
           $word = $request['word'];

           $exceptionId = auth()->user()->id; //except current user

           $results = null;

           if (strpos($word, ' ')) {
               $names = explode(' ', $word);

               $results = User::where('first_name', 'LIKE', '%'.$names[0].'%')->where('last_name', 'LIKE', '%'.$names[1].'%')->where('id', '!=', $exceptionId)->take($countOfRows)->get();
           }
           else{
               $results = User::where('username', 'LIKE', '%'.$word.'%')->orWhere('first_name', 'LIKE', '%'.$word.'%')->where('id', '!=', $exceptionId)->take($countOfRows)->get();
           }

           $results->transform(function ($user) {
               $user->last_seen_human_ago = $user->last_seen ? Carbon::parse($user->last_seen)->diffForHumans() : null;
               return $user;
           });

           return SearchResource::collection($results);
       }
   }
}
