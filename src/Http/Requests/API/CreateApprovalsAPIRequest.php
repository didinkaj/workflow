<?php

namespace Didinkaj\Approval\Http\Requests\API;

use Didinkaj\Approval\Models\Approvals;

class CreateApprovalsAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Approvals::$rules;
    }
}
