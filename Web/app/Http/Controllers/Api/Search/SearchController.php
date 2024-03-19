<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Search\SearchRequest;
use App\Http\Resources\Api\Search\SearchResource;

use App\Models\User;

class SearchController extends Controller
{
   public function __invoke(SearchRequest $request)
   {
       if($request->validated()) {

           $countOfRows = $request['limit'] ?? 10;
           $word = $request['word'];

           $results = null;

           if (strpos($word, ' ')) {
               $names = explode(' ', $word);

               $results = User::where('first_name', 'LIKE', '%'.$names[0].'%')->andWhere('last_name', 'LIKE', '%'.$names[1].'%')->take($countOfRows)->get();
           }
           else{
               $results = User::where('username', 'LIKE', '%'.$word.'%')->orWhere('first_name', 'LIKE', '%'.$word.'%')->take($countOfRows)->get();
           }


           return SearchResource::collection($results);
       }
   }
}
