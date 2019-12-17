<?php

namespace Didinkaj\Approval\Http\Controllers;

use Didinkaj\Approval\DataTables\WorkflowStageApproversDataTable;
use Didinkaj\Approval\Http\Requests\CreateWorkflowStageApproversRequest;
use Didinkaj\Approval\Http\Requests\UpdateWorkflowStageApproversRequest;
use Didinkaj\Approval\Repositories\UserRepository;
use Didinkaj\Approval\Repositories\WorkflowStageApproversRepository;
use Didinkaj\Approval\Repositories\WorkflowStagesRepository;
use Didinkaj\Approval\Repositories\WorkflowStageTypesRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;


class WorkflowStageApproversController extends AppBaseController
{
    /** @var  WorkflowStageApproversRepository */
    private $workflowStageApproversRepository;
    private $userRepository;
    private $stageTypesRepository;
    private $stagesRepository;

    public function __construct(
        WorkflowStageApproversRepository $workflowStageApproversRepo,
        UserRepository $userRepository,
        WorkflowStageTypesRepository $stageTypesRepository,
        WorkflowStagesRepository $stagesRepository
    )
    {
        $this->workflowStageApproversRepository = $workflowStageApproversRepo;
        $this->userRepository = $userRepository;
        $this->stageTypesRepository = $stageTypesRepository;
        $this->stagesRepository = $stagesRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the WorkflowStageApprovers.
     *
     * @param WorkflowStageApproversDataTable $workflowStageApproversDataTable
     * @return Response
     */
    public function index(WorkflowStageApproversDataTable $workflowStageApproversDataTable)
    {
        return $workflowStageApproversDataTable->render('didinkaj-approval::workflow_stage_approvers.index');
    }

    /**
     * Show the form for creating a new WorkflowStageApprovers.
     *
     * @return Response
     */
    public function create()
    {
        return view('didinkaj-approval::workflow_stage_approvers.create')
            ->withUsers($this->userRepository->all()->pluck('name', 'id'))
            ->withWorkflowStage($this->stagesRepository->with('workflowStageType')->get()->pluck('workflowStageType.name', 'id'))
            ->withWorkFlowStageTypes($this->stageTypesRepository->all()->pluck('name', 'id'));
    }

    /**
     * Store a newly created WorkflowStageApprovers in storage.
     *
     * @param CreateWorkflowStageApproversRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function store(CreateWorkflowStageApproversRequest $request)
    {
        $input = $request->all();
        $input['granted_by'] = Auth::id();

        $stageType = $this->stagesRepository->find($request->get('workflow_stage_id'));

        $workflowStageApprovers = $this->workflowStageApproversRepository->updateOrCreate([
                'workflow_stage_id' => $request->get('workflow_stage_id'),
                'workflow_stage_type_id' => $stageType->workflow_stage_type_id,
                'user_id' => $request->get('user_id')
            ]
            ,
            $input
        );

        Flash::success('Workflow Stage Approvers saved successfully.');

        return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
    }

    /**
     * Display the specified WorkflowStageApprovers.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workflowStageApprovers = $this->workflowStageApproversRepository->find($id);

        if (empty($workflowStageApprovers)) {
            Flash::error('Workflow Stage Approvers not found');

            return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
        }

        return view('didinkaj-approval::workflow_stage_approvers.show')->with('workflowStageApprovers', $workflowStageApprovers);
    }

    /**
     * Show the form for editing the specified WorkflowStageApprovers.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workflowStageApprovers = $this->workflowStageApproversRepository->find($id);

        if (empty($workflowStageApprovers)) {
            Flash::error('Workflow Stage Approvers not found');

            return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
        }

        return view('didinkaj-approval::workflow_stage_approvers.edit')
            ->with('workflowStageApprovers', $workflowStageApprovers)
            ->withUsers($this->userRepository->all()->pluck('name', 'id'))
            ->withWorkflowStage($this->stagesRepository->with('workflowStageType')->get()->pluck('workflowStageType.name', 'id'))
            ->withWorkFlowStageTypes($this->stageTypesRepository->all()->pluck('name', 'id'));
    }

    /**
     * Update the specified WorkflowStageApprovers in storage.
     *
     * @param int $id
     * @param UpdateWorkflowStageApproversRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function update($id, UpdateWorkflowStageApproversRequest $request)
    {
        $workflowStageApprovers = $this->workflowStageApproversRepository->find($id);


        if (empty($workflowStageApprovers)) {
            Flash::error('Workflow Stage Approvers not found');

            return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
        }
        $input = $request->all();

        $input['granted_by'] = Auth::id();

        $stageType = $this->stagesRepository->find($request->get('workflow_stage_id'));

        $input['workflow_stage_type_id'] = $stageType->workflow_stage_type_id;

        $workflowStageApprovers = $this->workflowStageApproversRepository->update($input, $id);

        Flash::success('Workflow Stage Approvers updated successfully.');

        return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
    }

    /**
     * Remove the specified WorkflowStageApprovers from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $workflowStageApprovers = $this->workflowStageApproversRepository->find($id);

        if (empty($workflowStageApprovers)) {
            Flash::error('Workflow Stage Approvers not found');

            return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
        }

        $this->workflowStageApproversRepository->delete($id);

        Flash::success('Workflow Stage Approvers deleted successfully.');

        return redirect(route('didinkaj-approval::workflowStageApprovers.index'));
    }
}
