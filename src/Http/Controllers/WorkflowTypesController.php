<?php

namespace Didinkaj\Approval\Http\Controllers;

use Didinkaj\Approval\DataTables\WorkflowTypesDataTable;
use Didinkaj\Approval\Http\Requests\CreateWorkflowTypesRequest;
use Didinkaj\Approval\Http\Requests\UpdateWorkflowTypesRequest;
use Didinkaj\Approval\Repositories\WorkflowStagesRepository;
use Didinkaj\Approval\Repositories\WorkflowTypesRepository;
use Exception;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;


class WorkflowTypesController extends AppBaseController
{
    /** @var  WorkflowTypesRepository */
    private $workflowTypesRepository;
    private $stagesRepository;

    public function __construct(WorkflowTypesRepository $workflowTypesRepo, WorkflowStagesRepository $stagesRepository)
    {
        $this->workflowTypesRepository = $workflowTypesRepo;
        $this->stagesRepository = $stagesRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the WorkflowTypes.
     *
     * @param WorkflowTypesDataTable $workflowTypesDataTable
     * @return Response
     */
    public function index(WorkflowTypesDataTable $workflowTypesDataTable)
    {
        return $workflowTypesDataTable->render('didinkaj-approval::workflow_types.index');
    }

    /**
     * Show the form for creating a new WorkflowTypes.
     *
     * @return Response
     */
    public function create()
    {
        return view('didinkaj-approval::workflow_types.create');
    }

    /**
     * Store a newly created WorkflowTypes in storage.
     *
     * @param CreateWorkflowTypesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function store(CreateWorkflowTypesRequest $request)
    {
        $input = $request->all();

        $workflowTypes = $this->workflowTypesRepository->create($input);

        Flash::success('Workflow Types saved successfully.');

        return redirect(route('didinkaj-approval::workflowTypes.index'));
    }

    /**
     * Display the specified WorkflowTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workflowTypes = $this->workflowTypesRepository->find($id);

        if (empty($workflowTypes)) {
            Flash::error('Workflow Types not found');

            return redirect(route('didinkaj-approval::workflowTypes.index'));
        }

        return view('didinkaj-approval::workflow_types.show')->with('workflowTypes', $workflowTypes);
    }

    /**
     * Show the form for editing the specified WorkflowTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workflowTypes = $this->workflowTypesRepository->find($id);

        if (empty($workflowTypes)) {
            Flash::error('Workflow Types not found');

            return redirect(route('didinkaj-approval::workflowTypes.index'));
        }

        return view('didinkaj-approval::workflow_types.edit')->with('workflowTypes', $workflowTypes);
    }

    /**
     * Update the specified WorkflowTypes in storage.
     *
     * @param int $id
     * @param UpdateWorkflowTypesRequest $request
     *
     * @return Response
     * @throws ValidatorException
     */
    public function update($id, UpdateWorkflowTypesRequest $request)
    {
        $workflowTypes = $this->workflowTypesRepository->find($id);

        if (empty($workflowTypes)) {
            Flash::error('Workflow Types not found');

            return redirect(route('didinkaj-approval::workflowTypes.index'));
        }

        $workflowTypes = $this->workflowTypesRepository->update($request->all(), $id);

        Flash::success('Workflow Types updated successfully.');

        return redirect(route('didinkaj-approval::workflowTypes.index'));
    }

    /**
     * Remove the specified WorkflowTypes from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $checkIfStageIsAttached = $this->stagesRepository->count(['workflow_type_id'=>$id]);

        if($checkIfStageIsAttached>0){
            Flash::error('Workflow Types Cannot be deleted, there is a workflow stages attached to this workflow type');
            return redirect()->back();
        }

        $workflowTypes = $this->workflowTypesRepository->find($id);

        if (empty($workflowTypes)) {
            Flash::error('Workflow Types not found');

            return redirect(route('didinkaj-approval::workflowTypes.index'));
        }

        $this->workflowTypesRepository->delete($id);

        Flash::success('Workflow Types deleted successfully.');

        return redirect(route('didinkaj-approval::workflowTypes.index'));
    }
}
