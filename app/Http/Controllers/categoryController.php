<?php

namespace App\Http\Controllers;


use Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\category;
use App\Transformer\LeadTransformer;

class categoryController extends Controller
{
	 protected $respose;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
    //
     public function category(LeadTransformer $transformer)
    {
    	// Check Secret Keys
    	$appKey = Request::header('apps-Key');

    	if($appKey=="wdwgaUYM03aEW3TdX0bb"){
        //Get all task
        //$category = category::all();
        // Return a collection of $task with pagination
       // return $this->response->make($category, new  LeadTransformer());
       // return (new LeadTransformer)->transform($category);
       // return $this->response->transform($category)->(new LeadTransformer);
      // return $category;

       /*  return response()->json([
            
                'data' => $transformer->transform($category)
            
        ]);*/

           $category = category::query()->paginate(10000000);
           return $this->response->withPaginator($category, new  LeadTransformer());
        // return $category;

       // $transformer = $category->getTransformer();
        }
        else {
        	 return $this->response->errorNotFound('Task Not Found');
        }
    }
 
}
