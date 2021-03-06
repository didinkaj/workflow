<?php

namespace Didinkaj\Approval\Http\Controllers;

use Didinkaj\Approval\DataTables\WorkflowStageTypesDataTable;
use Didinkaj\Approval\Http\Requests\CreateWorkflowStageTypesRequest;
use Didinkaj\Approval\Http\Requests\UpdateWorkflowStageTypesRequest;
use Didinkaj\Approval\Repositories\WorkflowStagesRepository;
use Didinkaj\Approval\Repositories\WorkflowStageTypesRepository;
use Exception;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;


class WorkflowStageTypesController extends AppBaseController
{
    /** @var  WorkflowStageTypesRepository */
    private $workflowStageTypesRepository;
    private $stagesRepository;

    public function __construct(WorkflowStageTypesRepository $workflowStageTypesRepo, WorkflowStagesRepository $stagesRepository)
    {
        $this->workflowStageTypesRepository = $workflowStageTypesRepo;
        $this->stagesRepository = $stagesRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the WorkflowStageTypes.
     *
     * @param WorkflowStageTypesDataTable $workflowStageTypesDataTable
     * @return Response
     */
    public function index(WorkflowStageTypesDataTable $workflowStageTypesDataTable)
    {
        return $workflowStageTypesDataTable->render('didinkaj-approval::workflow_stage_types.index');
    }

    /**
     * Show the form for creating a new WorkflowStageTypes.
     *
     * @return Response
     */
    public function create()
    {
        return view('didinkaj-approval::workflow_stage_types.create');
    }

    /**
     * Store a newly created WorkflowStageTypes in storage.
     *
     * @param CreateWorkflowStageTypesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function store(CreateWorkflowStageTypesRequest $request)
    {
        $input = $request->all();

        $workflowStageTypes = $this->workflowStageTypesRepository->create($input);

        Flash::success('Workflow Stage Types saved successfully.');

        return redirect(route('didinkaj-approval::workflowStageTypes.index'));
    }

    /**
     * Display the specified WorkflowStageTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workflowStageTypes = $this->workflowStageTypesRepository->find($id);

        if (empty($workflowStageTypes)) {
            Flash::error('Workflow Stage Types not found');

            return redirect(route('didinkaj-approval::workflowStageTypes.index'));
        }

        return view('didinkaj-approval::workflow_stage_types.show')->with('workflowStageTypes', $workflowStageTypes);
    }

    /**
     * Show the form for editing the specified WorkflowStageTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workflowStageTypes = $this->workflowStageTypesRepository->find($id);

        if (empty($workflowStageTypes)) {
            Flash::error('Workflow Stage Types not found');

            return redirect(route('didinkaj-approval::workflowStageTypes.index'));
        }

        return view('didinkaj-approval::workflow_stage_types.edit')->with('workflowStageTypes', $workflowStageTypes);
    }

    /**
     * Update the specified WorkflowStageTypes in storage.
     *
     * @param int $id
     * @param UpdateWorkflowStageTypesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function update($id, UpdateWorkflowStageTypesRequest $request)
    {
        $workflowStageTypes = $this->workflowStageTypesRepository->find($id);

        if (empty($workflowStageTypes)) {
            Flash::error('Workflow Stage Types not found');

            return redirect(route('didinkaj-approval::workflowStageTypes.index'));
        }

        $workflowStageTypes = $this->workflowStageTypesRepository->update($request->all(), $id);

        Flash::success('Workflow Stage Types updated successfully.');

        return redirect(route('didinkaj-approval::workflowStageTypes.index'));
    }

    /**
     * Remove the specified WorkflowStageTypes from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $checkIfStageIsAttached = $this->stagesRepository->count(['workflow_stage_type_id'=>$id]);

        if($checkIfStageIsAttached>0){
            Flash::error('Workflow stage Types Cannot be deleted, there is a workflow stages attached to this workflow stage type');
            return redirect()->back();
        }

        $workflowStageTypes = $this->workflowStageTypesRepository->find($id);

        if (empty($workflowStageTypes)) {
            Flash::error('Workflow Stage Types not found');

            return redirect(route('didinkaj-approval::workflowStageTypes.index'));
        }

        $this->workflowStageTypesRepository->delete($id);

        Flash::success('Workflow Stage Types deleted successfully.');

        return redirect(route('didinkaj-approval::workflowStageTypes.index'));
    }
}
