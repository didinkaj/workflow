<?php


namespace Didinkaj\Approval\Facade;

use Illuminate\Support\Facades\Facade;

class WorkflowApproval  extends Facade
{
    protected static function getFacadeAccessor() {
        return 'wiz-pack-approval';
    }

}