<?php namespace App\Traits;

trait ValidationTrait {

    /**
	 * Validation Action
	 * @return mixed 	true or json with error
	*/

	public function commonValidation( $request, $rules, $messages = false )
	{
        $parameters = $request->all();

        // For mix request with body and in path parameters
        if( count($rules) == 2 && isset( $rules['parameters'] ) && isset( $rules['rules'] ) )
        {
            foreach ( $rules['parameters'] as $key => $value) 
                $parameters[$key] = $value;
            
            $rules = $rules['rules'];
        }

        // Create validator        
        if($messages)
            $validator = \Validator::make( $parameters, $rules, $messages);
        else
            $validator = \Validator::make( $parameters, $rules);
        
        // Execute validator
        if( $validator->fails() )
            return response()->json( [ 'message' => $validator->errors()->all() ] , 500);

        return true;
	}
}