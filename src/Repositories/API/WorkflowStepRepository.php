<?php

namespace Didinkaj\Approval\Repositories\API;

use Didinkaj\Approval\Models\WorkflowStep;
use Didinkaj\Approval\Repositories\BaseRepository;

/**
 * Class WorkflowStepRepository
 * @package WizPack\Workflow\Repositories\API
 * @version December 1, 2019, 12:52 am UTC
*/

class WorkflowStepRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'workflow_stage_id',
        'workflow_id',
        'user_id',
        'approved_at',
        'rejected_at',
        'weight'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WorkflowStep::class;
    }
}
