@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Workflow Stages
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($workflowStages, ['route' => ['didinkaj-approval::workflowStages.update', $workflowStages->id], 'method' => 'patch']) !!}

                        @include('didinkaj-approval::workflow_stages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection