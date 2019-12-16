<?php
use Illuminate\Support\Facades\Route;


Route::group([
        'as'=>'didinkaj-approval-api::',
        'namespace' => 'Didinkaj\Approval\Http\Controllers\API',
        'prefix'=>'api/workflow',
        'middleware' => ['web', 'auth']]
    , function () {

        Route::resource('approvals', 'ApprovalsAPIController');
        Route::resource('workflowStages', 'WorkflowStageAPIController');
        Route::resource('workflowStageCheckLists', 'WorkflowStageCheckListAPIController');
        Route::resource('workflowStageTypes', 'WorkflowStageTypeAPIController');
        Route::resource('workflowSteps', 'WorkflowStepAPIController');
        Route::resource('workflowType', 'WorkflowTypeAPIController');
        Route::resource('WorkflowStageApprovers', 'WorkflowStageApproversAPIController');
        Route::resource('WorkflowStepChecklist', 'WorkflowStepChecklistAPIController');
    }
);
