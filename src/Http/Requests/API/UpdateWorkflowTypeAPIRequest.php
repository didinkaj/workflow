<?php

namespace Didinkaj\Approval\Http\Requests\API;

use Didinkaj\Approval\Models\WorkflowType;

class UpdateWorkflowTypeAPIRequest extends APIRequest
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
        $rules = WorkflowType::$rules;
        
        return $rules;
    }
}
