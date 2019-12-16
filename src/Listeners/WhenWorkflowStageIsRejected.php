<?php

namespace Didinkaj\Approval\Listeners;

use Didinkaj\Approval\Mail\WorkflowRejectedMail;
use Didinkaj\Approval\Models\Approvals;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class WhenWorkflowStageIsRejected
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $workflow = collect($event->workflow);
        $approvedStep = collect($event->approvedStep);
        $workflowPayload = $workflow->pluck('workflowDetails')->first();
        $currentStageApprovers = $workflow->pluck('currentStageApprovers')->flatten(1);

        $sentBy = $workflowPayload['sent_by'];

        //set next approval stage
        $currentStageUpdate = Approvals::findOrFail($workflowPayload['id']);

        if (!empty($currentStageUpdate)) {
            $currentStageUpdate->rejected_at = Carbon::now();
            $currentStageUpdate->approved = 1;
            $currentStageUpdate->save();
            //mark workflow complete
            app($currentStageUpdate->model_type)->markApprovalAsRejected($currentStageUpdate->model_id);
        }

        $allApprovers = $currentStageApprovers->flatten(1)->unique('user_id')->map(function ($approver) {
            return [
                'email' => $approver['approver_email'],
                'name' => $approver['approver_name']
            ];
        });

        return Mail::to($sentBy)
            ->cc($allApprovers)
            ->send(new WorkflowRejectedMail($workflowPayload, $approvedStep, $sentBy));
    }
}
