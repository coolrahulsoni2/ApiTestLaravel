<?php

namespace App\Http\Controllers;


//use Request;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Http\Controllers\Controller;
use App\category;
use App\subcategory;
use App\query;
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

    public function subcategory($id)
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

           $category = subcategory::query()->where("cateId",$id)->paginate(10000000);
           //return $this->response->withPaginator($category, new  LeadTransformer());
         return $category;

       // $transformer = $category->getTransformer();
        }
        else {
        	 return $this->response->errorNotFound('Task Not Found');
        }
    }


public function leads($id)
    {
    	// Check Secret Keys
    	$appKey = Request::header('apps-Key');

    	if($appKey=="wdwgaUYM03aEW3TdX0bb"){
        //Get all task
        $leads = query::query()->where("categoryId",$id)->paginate(10);
        // Return a collection of $task with pagination
        return $this->response->withPaginator($leads, new  LeadTransformer());
        }
        else {
        	 return $this->response->errorNotFound('Task Not Found');
        }
    }

 
public function login(Request $request)
    {
    	// Check Secret Keys
    	//$userData = collect(json_decode($request->get('json')))->collapse();
    
    	//echo( $userData->username);

    	$username=$request->input("username");
    	$password=$request->input("password");
    	/*print_r( $request->input());
    	echo 'hello'.$username;
    	echo 'hello'.$password;*/
    	// Check Secret Keys
    	//$appKey = Request::header('apps-Key');
    	$appKey = $request->header('apps-Key'); // string
    	if($appKey=="wdwgaUYM03aEW3TdX0bb"){
        //Get all task
        $leads = query::query()->where("email",$username)->paginate(10);
        echo getQueryLog();
        // Return a collection of $task with pagination
        return $this->response->withPaginator($leads, new  LeadTransformer());
        //return  $leads;
        }
        else {
        	 return $this->response->errorNotFound('Task Not Found');
        }
    }

 
}
