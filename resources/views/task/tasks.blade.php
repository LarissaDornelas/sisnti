@section('title')
@yield('title')
@stop
@section('morecss')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@stop
@extends('base')
@yield('isAdmin')
@section('content')
<section class="content-header">
    <h1>
        @yield('textTitle')
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('/') }}"></i>Início</a></li>
        <li class="active"><a href="/solicitacao">Meus Chamados</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Abertura</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Descrição</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Observações</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Local</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Categoria</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Status</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($userTasks as $userTask)
                                <tr>
                                    <td>{{ date( 'd-m-Y H:i:s' , strtotime($userTask->openingDate)) }}</td>
                                    <td>
                                        <div class="b">{{ $userTask->description }}
                                    </td>
                                    <td>
                                        <div class="b">{{ $userTask->note }}
                                    </td>
                                    <td>{{ $userTask->taskLocal}}</td>
                                    <td>{{ $userTask->taskCategory}}</td>
                                    <td><small class="label
                                    @switch($userTask->taskStatus)
                                        @case('Em Aberto')
                                         bg-blue-ufop
                                        @break
                                        @case('Aguardando Atendimento')
                                         bg-blue-2-ufop
                                        @break
                                        @case('Em Atendimento')
                                         bg-yellow-ufop
                                        @break
                                        @case('Em Espera')
                                         label bg-red-ufop
                                        @break
                                        @case('Concluído com Sucesso')
                                         bg-green-ufop
                                        @break
                                        @case('Concluído com Restrição')
                                         bg-green-ufop
                                        @break
                                        @case('Concluído com Duplicata')
                                         bg-green-ufop
                                        @break
                                    @endswitch
                                     ">{{ $userTask->taskStatus }}</small></td>

                                    <td>
                                        <a id="see-details-ufop" @if(Route::is('userTasks')) href="{{route('taskDetail', ['id' => $userTask->id])}}" @elseif(Route::is('showAdminGeneral'|| 'showAdminMyCalls' )) href="{{route('adminTaskDetail', ['id' => $userTask->id])}}" @endif><span class="fa fa-eye"></span></a></td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                        {!! $userTasks->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@stop
@section('morejs')
<script src="{{ asset('assets/js/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.net-bs/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(function() {
        $('#example2').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true 'ordering': true,
            'info': false,
            'autoWidth': false
        })
    })
</script>
@stop
