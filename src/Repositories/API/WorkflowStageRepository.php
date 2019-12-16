<?php

namespace Didinkaj\Approval\Repositories\API;

use Didinkaj\Approval\Models\WorkflowStage;
use Didinkaj\Approval\Repositories\BaseRepository;

/**
 * Class WorkflowStageRepository
 * @package App\Repositories
 * @version December 1, 2019, 12:34 am UTC
*/

class WorkflowStageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'workflow_stage_type_id',
        'workflow_type_id',
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
        return WorkflowStage::class;
    }
}
