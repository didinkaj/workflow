@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Workflow Stage Approvers
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'didinkaj-approval::workflowStageApprovers.store']) !!}

                        @include('didinkaj-approval::workflow_stage_approvers.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
