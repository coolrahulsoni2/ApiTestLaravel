<?php namespace App\Transformer;
 
use League\Fractal\TransformerAbstract;
 
class LeadTransformer extends TransformerAbstract {
 
    public function transform($Api) {
        return [
            'id' => $Api->id,
            'name' => $Api->Name,
            //'email' => $Api->email
            'status' => 'Success',
            
        ];
       
    }

    public function with($Api){
    	  return [
            'status' => 'Success',
            
        ];
    }
 }