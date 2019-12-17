@section('css')
    @include('didinkaj-approval::.layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@section('scripts')
    @include('didinkaj-approval::.layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection