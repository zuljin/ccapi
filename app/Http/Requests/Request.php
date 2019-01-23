<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    /**
     * Overloading validate() to fire a new method after a success validation: onValidate().
     */
    public function validate()
    {
        // First of all fire up the validation.
        parent::validate();

        // If we are still here means no Exceptions have been fired.
        // Let's see if we have any 'onValidate' method in the child class, and if so fire it.
        if ( method_exists( $this, 'onValidate') ) {
            call_user_func( [ $this, 'onValidate' ] );
        }
    }

}
