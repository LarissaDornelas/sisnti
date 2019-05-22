@section('title')
Detalhes do Chamado
@stop
@extends('base')
@section('content')


@if($error == 'Acesso Negado')
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
    <li class="active">Novo</li>
  </ol>
</section>

<section class="content">
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
                <th class="text-center" scope="col"><i class="fa fa-calendar margin-r-5"></i></th>
                <td>{{date( 'd-m-Y H:i:s' , strtotime($taskData->openingDate))}}</td>
              </tr>
              <tr>
                <th class="text-center" scope="col"><i class="fa fa-user margin-r-5"></i></th>
                <td>{{$taskData->name}}</td>
              </tr>
              <tr>
                <th class="text-center" scope="col"><i class="fa fa-file-text margin-r-5"></i></th>
                <td>{{$taskData->patrimony}}</td>
              </tr>
              <tr>
                <th class="text-center" scope="col"><i class="fa fa-location-arrow margin-r-5"></th>
                <td>{{$taskData->taskLocal}}</td>
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
                  <th class="text-center" scope="col"><i class="fa fa-spinner margin-r-5"></i></th>
                  <td>{{$taskData->taskStatus}}</td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-calendar margin-r-5"></i></th>
                  <td>
                      @if($taskData->forecastService == null)
                      Não definido
                      @else
                      {{$taskData->forecastService}}
                      @endif
                  </td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-check margin-r-5"></i></th>
                  <td>
                      @if($taskData->solution == null)
                      Não definido
                     @else
                     {{$taskData->solution}}
                     @endif
                  </td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-location-arrow margin-r-5"></th>
                  <td>{{$taskData->taskLocal}}</td>
                </tr>
  
              </table>
            </div>
          </div>
         
    </div>
    </div>
    </div>

</section>
@endif
@stop