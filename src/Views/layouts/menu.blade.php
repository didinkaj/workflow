<li class="{{ Request::is('workflow/approvals*') ? 'active' : '' }}">
    <a href="{!! route('didinkaj-approval::approvals.index') !!}"><i class="fa fa-edit"></i><span>Approvals</span></a>
</li>

<li class="{{ Request::is('workflow/workflow*') ? 'active' : '' }} treeview">
    <a href="#">
        <i class="fa fa-dashboard"></i> <span>WorkFlow</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">

        <li class="{{ Request::is('workflow/workflowStages*') ? 'active' : '' }}">
            <a href="{!! route('didinkaj-approval::workflowStages.index') !!}"><i class="fa fa-edit"></i><span>Workflow Stages</span></a>
        </li>
        <li class="{{ Request::is('workflow/workflowStageApprovers*') ? 'active' : '' }}">
            <a href="{!! route('didinkaj-approval::workflowStageApprovers.index') !!}"><i class="fa fa-edit"></i><span>Workflow Stage Approvers</span></a>
        </li>

        <li class="{{ Request::is('workflow/workflowStageCheckLists*') ? 'active' : '' }}">
            <a href="{!! route('didinkaj-approval::workflowStageCheckLists.index') !!}"><i class="fa fa-edit"></i><span>Workflow Stage Check Lists</span></a>
        </li>

        <li class="{{ Request::is('workflow/workflowStageTypes*') ? 'active' : '' }}">
            <a href="{!! route('didinkaj-approval::workflowStageTypes.index') !!}"><i
                        class="fa fa-edit"></i><span>Workflow Stage Types</span></a>
        </li>

        <li class="{{ Request::is('workflow/workflowTypes*') ? 'active' : '' }}">
            <a href="{!! route('didinkaj-approval::workflowTypes.index') !!}"><i class="fa fa-edit"></i><span>Workflow Types</span></a>
        </li>

    </ul>
</li>
