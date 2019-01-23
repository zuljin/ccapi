<?php namespace App\Http\Requests;

use Illuminate\Support\Collection;
use PhpParser\Builder\Class_;

use App\Traits\ValidationTrait;

class UserRequest extends Request
{
    use ValidationTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Validation rules to store a new user trade
     *
     * @return array
    */

    public function rulesStoreTrade( $id )
    {
        //user_id (in url path)
        //coin_id: int
        //amount: float, (could be negative)
        //price_usd: float,
        //traded_at: date, ('2018-04-20T16:40:51.620Z', Iso8601) | composer require "penance316/laravel-iso8601-validator"
        //notes: 'I want that lambo!' (optional)

        return [ 'parameters'    => [ 
                        'userId'  => $id,
                    ],
                    'rules'         => [
                        'userId'    =>  'required|exists:user,id',
                        'coin_id'   =>  'required|exists:coin,id',
                        'amount'    =>  'required|regex:/^-?\d*(\.\d{1,20})?$/',
                        'price_usd' =>  'required|regex:/^\d*(\.\d{1,20})?$/',
                        'traded_at' =>  'required|iso_date',
                        'notes'     =>  'nullable|string|max:500',
                    ]
            ];
  
    }

    /**
     * Request rules for Show Request
    */

    public function rulesPortfolio( $id )
    {
        return [ 'parameters'    => [ 
                    'userId'  => $id,
                ],
                'rules'         => [
                    'userId'  => 'required|exists:user_trade,user_id|exists:user,id',
                ]
        ];
    }

    /**
     * Is the user authorized to make this request?
     *
     * @return bool
     */
    public function authorize()
    {
        // A Priori, once the user reaches the form, is able to perform the request :)
        return true;
    }

    /**
     * Set of rules to validate the Filter form.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * Custom messages for requests
     *
     * @return array
    */

    public function messages( $userId = '' )
    {    
        return [
            'userId.exists'     => 'User ' . $userId . ' not found',
        ];
    }

    /**
	 * Validation Action, now, adapt for Route (GET) parameters too ^_^
	 * 
	 * @return mixed 	true or json with error
	*/

	public function validation( $rules, $messages = false )
	{
        return $this->commonValidation( $this, $rules, $messages);
	}


    /**
     * After validation actions..
     */
    public function onValidate()
    {
    }

    /**
     * Parse the Request to assure we have an array.
     */
    protected function parse()
    {
    }
}