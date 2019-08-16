@extends('task/taskDetail')
@section('isAdmin')
@extends('admin/sidebarAdmin')
@section('adminTaskDetail')
@if($taskData->taskStatus == 'Em Aberto')
<div id="firstEvaluation">
    <button class="btn btn-primary btn-lg" onclick="toEvaluate('start')" data-toggle="collapse" data-target="#evaluationBox">Avaliar Chamado</button>
</div>
@endif
<div id="evaluationBox"  {!! ($taskData->taskStatus == 'Em Aberto')? "class= 'box box-default collapse'" : "class='box box-default'"!!}>
        <div class="box-header with-border">
          <h3 class="box-title">Avaliação do Técnico</h3>
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
                       {{$taskData->manager_id}}
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
                    <tr>
                      <td>
                          {{date( 'd-m-Y H:i:s' , strtotime($taskData->historicDate))}}
                      </td>
                      <td>
                          {{$taskData->historicDescription}}
                      </td>
                    </tr>

                  </table>
                </div>

            </div>
            <div class="container-fluid">
                    <div class="row">
                    @if($taskData->taskStatus == 'Em Aberto')
                    <div id="cancelEvaluation" class="col-md-6" style="display:none;">
                        <button class="btn btn-danger btn-lg" onclick="toEvaluate('cancel')" data-toggle="collapse" data-target="#evaluationBox">Cancelar</button>
                    </div>
                    @endif
                    <div {!! ($taskData->taskStatus == 'Em Aberto')? "style='display: none', class='text-right col-md-6'" : "style='display: block', class='text-right'"!!}} id="buttonSave"  >
                        <button class="btn btn-success btn-lg">Salvar Alterações</button>
                    </div>
                    </div>
                    </div>
      </div>
      </div>

      </div>



@endsection
@section('morejs')
<script>
    function toEvaluate(opt){

       var box = document.getElementById('evaluationBox');
       var buttonEvaluate = document.getElementById('firstEvaluation');
       var buttonCancel = document.getElementById('cancelEvaluation');

        if(opt == "start"){
           $("#evaluationBox").on("show.bs.collapse");
            buttonEvaluate.style.display = "none";
            buttonCancel.style.display = "block";
            buttonSave.style.display = "block" ;
        }else if(opt == "cancel"){
            $("#evaluationBox").on("hide.bs.collapse");
            buttonCancel.style.display = "none";
            buttonEvaluate.style.display = "block";
            buttonSave.style.display = "none" ;


        }

    }
</script>
@endsection
@stop

