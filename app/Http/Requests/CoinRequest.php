<?php 
namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpParser\Builder\Class_;

use App\Traits\ValidationTrait;

class CoinRequest extends Request
{
    use ValidationTrait;

    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * Request rules for Show Request
    */

    public function rulesShow( $id )
    {
        return [ 'parameters'    => [ 
                    'coinId'  => $id,
                ],
                'rules'         => [
                    'coinId'  => 'required|exists:coin,id',
                ]
        ];
    }

    /**
     * Request rules for Index Request
    */
    public function rulesIndex( $page )
    {
        echo $page . "\n";
        return [ 'parameters'    => [ 
                    'page'  => $page,
                ],
                'rules'         => [
                    'page'  => 'required|integer',
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
        return [];
    }

    /**
     * Custom messages for requests
     *
     * @return array
    */

    public function messages( $coinId = '')
    {    
        return [
            'coinId.exists' => 'Coin ' . $coinId . ' not found',
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