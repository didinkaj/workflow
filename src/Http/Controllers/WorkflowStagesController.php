<?php

namespace Didinkaj\Approval\Http\Controllers;

use Didinkaj\Approval\DataTables\WorkflowStagesDataTable;
use Didinkaj\Approval\Http\Requests\CreateWorkflowStagesRequest;
use Didinkaj\Approval\Http\Requests\UpdateWorkflowStagesRequest;
use Didinkaj\Approval\Repositories\WorkflowStagesRepository;
use Didinkaj\Approval\Repositories\WorkflowStageTypesRepository;
use Didinkaj\Approval\Repositories\WorkflowStepRepository;
use Didinkaj\Approval\Repositories\WorkflowTypesRepository;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;


class WorkflowStagesController extends AppBaseController
{
    /** @var  WorkflowStagesRepository */
    private $workflowStagesRepository;
    private $workflowTypesRepository;
    private $stageTypesRepository;
    private $workflowStepRepository;

    public function __construct(
        WorkflowStagesRepository $workflowStagesRepo,
        WorkflowStageTypesRepository $stageTypesRepository,
        WorkflowTypesRepository $workflowTypesRepository,
        WorkflowStepRepository $workflowStepRepository
    )
    {
        $this->workflowStagesRepository = $workflowStagesRepo;
        $this->stageTypesRepository = $stageTypesRepository;
        $this->workflowTypesRepository = $workflowTypesRepository;
        $this->workflowStepRepository = $workflowStepRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the WorkflowStages.
     *
     * @param WorkflowStagesDataTable $workflowStagesDataTable
     * @return Response
     */
    public function index(WorkflowStagesDataTable $workflowStagesDataTable)
    {
        return $workflowStagesDataTable->render('didinkaj-approval::workflow_stages.index');
    }

    /**
     * Show the form for creating a new WorkflowStages.
     *
     * @return Response
     */
    public function create()
    {
        return view('didinkaj-approval::workflow_stages.create')
            ->withWorkFlowTypes($this->workflowTypesRepository->all(['name','id'])->pluck('name', 'id'))
            ->withWorkFlowStageTypes($this->stageTypesRepository->all(['name','id'])->pluck('name', 'id'));
    }

    /**
     * Store a newly created WorkflowStages in storage.
     *
     * @param CreateWorkflowStagesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function store(CreateWorkflowStagesRequest $request)
    {
        $input = $request->all();

        $workflowStages = $this->workflowStagesRepository->create($input);

        Flash::success('Workflow Stages saved successfully.');

        return redirect(route('didinkaj-approval::workflowStages.index'));
    }

    /**
     * Display the specified WorkflowStages.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workflowStages = $this->workflowStagesRepository->find($id);

        if (empty($workflowStages)) {
            Flash::error('Workflow Stages not found');

            return redirect(route('didinkaj-approval::workflowStages.index'));
        }

        return view('didinkaj-approval::workflow_stages.show')
            ->withWorkflowStages($workflowStages)
            ->withWorkFlowTypes($this->workflowTypesRepository->all(['name','id'])->pluck('name', 'id'))
            ->withWorkFlowStageTypes($this->stageTypesRepository->all(['name','id'])->pluck('name', 'id'));
    }

    /**
     * Show the form for editing the specified WorkflowStages.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workflowStages = $this->workflowStagesRepository->find($id);

        if (empty($workflowStages)) {
            Flash::error('Workflow Stages not found');

            return redirect(route('didinkaj-approval::workflowStages.index'));
        }

        return view('didinkaj-approval::workflow_stages.edit')->with('workflowStages', $workflowStages)
            ->withWorkFlowTypes($this->workflowTypesRepository->all(['name','id'])->pluck('name', 'id'))
            ->withWorkFlowStageTypes($this->stageTypesRepository->all(['name','id'])->pluck('name', 'id'));
    }

    /**
     * Update the specified WorkflowStages in storage.
     *
     * @param int $id
     * @param UpdateWorkflowStagesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function update($id, UpdateWorkflowStagesRequest $request)
    {
        $workflowStages = $this->workflowStagesRepository->find($id);

        if (empty($workflowStages)) {
            Flash::error('Workflow Stages not found');

            return redirect(route('didinkaj-approval::workflowStages.index'));
        }

        $workflowStages = $this->workflowStagesRepository->update($request->all(), $id);

        Flash::success('Workflow Stages updated successfully.');

        return redirect(route('didinkaj-approval::workflowStages.index'));
    }

    /**
     * Remove the specified WorkflowStages from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $checkIfStepIsAttached = $this->workflowStepRepository->count(['workflow_stage_id' => $id]);

        if ($checkIfStepIsAttached > 0) {
            Flash::error('Workflow stage Cannot be deleted, there is a workflow step attached to this workflow stage ');
            return redirect()->back();
        }

        $workflowStages = $this->workflowStagesRepository->find($id);

        if (empty($workflowStages)) {
            Flash::error('Workflow Stages not found');

            return redirect(route('didinkaj-approval::workflowStages.index'));
        }

        $this->workflowStagesRepository->delete($id);

        Flash::success('Workflow Stages deleted successfully.');

        return redirect(route('didinkaj-approval::workflowStages.index'));
    }
}
