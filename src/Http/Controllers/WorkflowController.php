<?php

namespace Didinkaj\Approval\Http\Controllers;

use Didinkaj\Approval\Repositories\ApprovalsRepository;
use Didinkaj\Approval\Transformers\ApprovalTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class WorkflowController extends AppBaseController
{
    protected $approvalsRepo;

    /**
     * WorkflowController constructor.
     * @param ApprovalsRepository $approvalsRepo
     */
    public function __construct(ApprovalsRepository $approvalsRepo)
    {
        $this->approvalsRepo = $approvalsRepo;
        $this->middleware('auth');
    }

    /**
     * @param $workflowApprovalId
     * @return \Illuminate\Support\Collection
     */
    public function getWorkflowInfo($workflowApprovalId)
    {
        $workflow = $this->approvalsRepo->getApprovalSteps($workflowApprovalId)->get();

        $transformedResult = new Collection($workflow, new ApprovalTransformer());

        return collect((new Manager())->createData($transformedResult)->toArray()['data']);
    }
}
