<?php

namespace Didinkaj\Approval\Repositories\API;

use Didinkaj\Approval\Models\WorkflowStageType;
use Didinkaj\Approval\Repositories\BaseRepository;

/**
 * Class WorkflowStageTypeRepository
 * @package WizPack\Workflow\Repositories\API
 * @version December 1, 2019, 12:48 am UTC
*/

class WorkflowStageTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
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
        return WorkflowStageType::class;
    }
}
