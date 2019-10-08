@section('title')
Detalhes do Chamado
@stop
@extends('base')
@yield('isAdmin')
@section('content')

@if($error )
<div class="alert alert-danger show" role="alert">
    This is a danger alert—check it out!
</div>
@else


<section class="content-header">
    <h1>
        Chamado Nº{{$taskData->id}}


    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('/') }}"></i>Início</a></li>
        <li><a href="/solicitacao">Meus Chamados</a></li>
        <li class="active">Detalhes do Chamado</li>
    </ol>
</section>


<section class="content">
    @if($reopenInTime)
    <div id="firstEvaluation">
        <button style="margin: 12px 0 17px 0" class="btn btn-primary" onclick="toEvaluate('start')" data-toggle="collapse" data-target="#evaluationBox">Reabrir chamado</button>
    </div>
    <div id="evaluationBox" class='box box-default collapse'>
        <div class="box-header with-border">
            <h3 class="box-title">Reabrir Chamado</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div class="box-body">
            <div class="box-body">
                <form method="POST" action="{{ route('reopenTask', ['id' => $taskData->id]) }}">
                    {{ csrf_field()}}
                    <div class="row ">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Motivo</label>
                                <textarea name="reopen" style="margin-top: 13px" class="form-control" rows="3" placeholder="Descreva aqui o motivo para reabrir o chamado." required></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class='text-right' id="buttonSave">
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>
    @endIf
    @yield('adminTaskDetail')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do Chamado</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover table-striped table-bordered">
                            <tr>
                                <th title="Data de Abertura" class="text-center" scope="col"><i class="fa fa-calendar margin-r-5"></i></th>
                                <td class="tamFixed">{{date( 'd-m-Y H:i:s' , strtotime($taskData->openingDate))}}</td>
                            </tr>
                            <tr>
                                <th title="Solicitante" class="text-center" scope="col"><i class="fa fa-user margin-r-5"></i></th>
                                <td class="tamFixed">{{$taskData->name}}</td>
                            </tr>
                            <tr>
                                <th title="Patrimônio" class="text-center" scope="col"><i class="fa fa-file-text margin-r-5"></i></th>
                                <td class="tamFixed">
                                    @if($taskData->patrimony == null)
                                    Não definido
                                    @else
                                    {{$taskData->patrimony}}
                                    @endif</td>
                            </tr>
                            <tr>
                                <th title="Local do Problema" class="text-center" scope="col"><i class="fa fa-location-arrow margin-r-5"></th>
                                <td class="tamFixed">{{$taskData->taskLocal}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th class="bg-secondary"><strong><i class="fa  fa-commenting margin-r-5"></i> Descrição</strong></th>
                            </tr>
                            <tr>
                                <td> {{$taskData->description}}</td>
                            </tr>
                            <tr>
                                <th class="bg-secondary"><strong><i class="fa fa-sticky-note margin-r-5"></i> Observações</strong></th>
                            </tr>
                            <tr>
                                <td> {{$taskData->note}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Andamento do Chamado</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover table-striped table-bordered">
                            <tr>
                                <th title="Status" class="text-center" scope="col"><i class="fa fa-spinner margin-r-5"></i></th>
                                <td class="tamFixed">{{$taskData->taskStatus}}</td>
                            </tr>
                            <tr>
                                <th title="Previsão de Atendimento" class="text-center" scope="col"><i class="fa fa-calendar margin-r-5"></i></th>
                                <td class="tamFixed">
                                    @if($taskData->forecastService == null)
                                    Não definido
                                    @else
                                    {{$taskData->forecastService}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th title="Solução" class="text-center" scope="col"><i class="fa fa-check margin-r-5"></i></th>
                                <td class="tamFixed">
                                    @if($taskData->solution == null)
                                    Não definido
                                    @else
                                    {{$taskData->solution}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th title="Responsável" class="text-center" scope="col"><i class="fa  fa-user margin-r-5"></th>
                                <td class="tamFixed">
                                    @if($taskData->manager_id == null)
                                    Não definido
                                    @else
                                    {{$manager->managerName}}
                                    @endif</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-hover table-striped table-bordered">
                            <tr>
                                <th colspan="2" class="text-center">Histórico</th>
                            </tr>
                            <tr>
                                <th scope="col">Data/Hora</th>
                                <th scope="col">Descrição</th>
                            </tr>
                            @foreach($historic as $item)
                            <tr>
                                <td>
                                    {{date( 'd-m-Y H:i:s' , strtotime($item->date))}}
                                </td>
                                <td>
                                    {{$item->description}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>


</section>
@endif
@stop
