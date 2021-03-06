<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as'=>'didinkaj-approval::',
    'namespace' => 'Didinkaj\Approval\Http\Controllers',
    'prefix'=>'workflow',
    'middleware' => ['web', 'auth']]
    , function () {

    Route::get('demo/test', 'ApprovalsController@index');

    Route::resource('workflowTypes', 'WorkflowTypesController');

    Route::resource('workflowStageTypes', 'WorkflowStageTypesController');

    Route::resource('workflowStages', 'WorkflowStagesController');

    Route::resource('workflowStageCheckLists', 'WorkflowStageCheckListController');

    Route::resource('workflowStageApprovers', 'WorkflowStageApproversController');

    Route::resource('approvals', 'ApprovalsController');

    //approval/rejection
    Route::get('workflowApproveRequest/{Approvals}/{workflowStage}', 'ApproveRequestController@handle');

    Route::get('workflowRejecctRequest/{Approvals}/{workflowStage}', 'RejectRequestController@handle');

});