<?php

namespace Didinkaj\Approval\Providers;

use Didinkaj\Approval\Events\ApprovalRequestRaised;
use Didinkaj\Approval\Events\WorkflowStageApproved;
use Didinkaj\Approval\Events\WorkflowStageRejected;
use Didinkaj\Approval\Listeners\WhenApprovalRequestIsRaised;
use Didinkaj\Approval\Listeners\WhenWorkflowStageIsApproved;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Didinkaj\Approval\Listeners\WhenWorkflowStageIsRejected;

class WorkflowApprovalEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ApprovalRequestRaised::class => [
            WhenApprovalRequestIsRaised::class,
        ],
        WorkflowStageApproved::class => [
            WhenWorkflowStageIsApproved::class
        ],
        WorkflowStageRejected::class=>[
            WhenWorkflowStageIsRejected::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
