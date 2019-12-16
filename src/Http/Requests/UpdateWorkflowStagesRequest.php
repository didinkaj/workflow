<?php

namespace  Didinkaj\Approval\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Didinkaj\Approval\Models\WorkflowStage;

class UpdateWorkflowStagesRequest extends FormRequest
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
        $rules = WorkflowStage::$rules;

        return $rules;
    }
}
