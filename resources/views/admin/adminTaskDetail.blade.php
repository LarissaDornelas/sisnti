@extends('task/taskDetail')
@section('isAdmin')
@extends('admin/sidebarAdmin')
@section('morecss')
<link rel="stylesheet" href="/Content/bootstrap-datetimepicker.css" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css" rel="stylesheet" />

@stop
@section('adminTaskDetail')


@if($taskData->duplicateOf != null)
<p class="font-weight-bold">Para realizar alterações acesse o chamado <a href="{{route('adminTaskDetail', ['id' => $taskData->duplicateOf])}}">original</a>.</p>
@endif
@if($taskData->duplicateOf == null)
@if($taskData->taskStatus != 'Concluído com Sucesso')
@if($taskData->taskStatus != 'Concluído com Restrição')
@if($taskData->taskStatus != 'Concluído com Duplicata')

<div id="firstEvaluation">
    <button style="margin: 12px 0 17px 0" class="btn btn-primary" onclick="toEvaluate('start')" data-toggle="collapse" data-target="#evaluationBox">{{($taskData->taskStatus == 'Em Aberto') ? 'Avaliar Chamado' : 'Atualizar Atendimento'}}</button>
</div>


@if($taskData->taskStatus == 'Em Aberto')
<div id="evaluationBox" class='box box-default collapse'>
    <div class="box-header with-border">
        <h3 class="box-title">Avaliação do Técnico</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="box-body">
        <div class="box-body">
            <form method="POST" action="{{ route('adminEvaluateTask', ['id' => $taskData->id]) }}">
                {{ csrf_field()}}
                <div class="row ">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Prioridade do chamado</label>
                            <select class="form-control" name="taskPriority_id">
                                @foreach($priority as $item)
                                <option value="{{$item->id}}" {!! ($taskData->taskPriority_id == $item->id)? 'selected' : '' !!}> {{$item->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-check align-form">
                            <input type="checkbox" id="duplicated" class="form-check-input" name="duplicated" value="true" onclick="onCheckedDuplicated()">
                            <label class="form-check-label">Chamado duplicado</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" id="forecastService" style="display: block">
                            <label>Previsão de atendimento</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input id="inputForecastService" type='text' class="form-control" name="forecastService" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="duplicateOptions" style="display: none">
                            <label>Selecionar Chamado Original</label>
                            <select id="selectOriginal" class="selectpicker form-control optsOriginal" data-live-search="true" name="originalTask" onchange="updateDescription()">
                                <option value="-1" id="Nenhum item selecionado"> - </option>

                                @foreach($duplicatedOpt as $item)
                                <option value="{{$item->id}}" id="{{$item->description}}" style="  width: 400px; overflow: hidden; text-overflow: ellipsis;">
                                    <div>{{$item->name}} - {{$item->description}}</div>
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class=" col-md-3">
                        <div class="duplicateOptions" style="display: none">
                            <label>Descrição do Chamado Original</label>
                            <p id="descriptionOriginalTask"></p>

                        </div>

                    </div>
                    <div class="col-md-3">

                    </div>

                </div>

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-1" id="cancelEvaluation" style="display:none;">
                            <button type="button" class="btn btn-danger" onclick="toEvaluate('cancel')" data-toggle="collapse" data-target="#evaluationBox">Cancelar</button>
                        </div>
                        <div {!! ($taskData->taskStatus == 'Em Aberto')? "style='display: none', class='col-sm-1'" : "style='display: block', class='text-right'"!!}} id="buttonSave" >
                            <button class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</div>
@else
<div id="evaluationBox" class='box box-default collapse'>
    <div class="box-header with-border">
        <h3 class="box-title">Atualizar Atendimento</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="box-body">
        <div class="box-body">
            <form method="POST" action="{{ route('adminUpdateTask', ['id' => $taskData->id]) }}">
                {{ csrf_field()}}
                <div class="row ">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Status</label>
                                </div>
                                <div class="col">
                                    <div id="checkOptions" class="statusradio">
                                        <div class="statusradio-yellow">
                                            <input type="radio" name="radio" id="attendace" value="em-atendimento" {!! ($taskData->taskStatus == 'Em Atendimento') ? 'checked' : '' !!}/>
                                            <label for="attendace" onclick=onCheckedStatus('attendace')>Em Atendimento</label>
                                        </div>
                                        <div class="statusradio-red">
                                            <input type="radio" name="radio" id="wait" value="em-espera" {!! ($taskData->taskStatus == 'Em Espera') ? 'checked' : '' !!}/>
                                            <label for="wait" onclick=onCheckedStatus('wait')>Em espera</label>
                                        </div>
                                        <div class="statusradio-green">
                                            <input type="radio" name="radio" id="success" value="concluido" {!! ($taskData->taskStatus == 'Concluído com Sucesso ') ? 'checked' : '' !!}/>
                                            <label for="success" onclick=onCheckedStatus('success')>Concluído</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Descrição da solução</label>
                            <textarea name="solution" style="margin-top: 13px" class="form-control" rows="3" placeholder="Descreva aqui o que foi feito para solucionar o problema." required>{{$taskData->solution}}</textarea>
                        </div>
                        <div class="form-group" id="successOptions" style="display: none">
                            <label>Concluído</label>
                            <select class="form-control" name="taskSuccess">

                                <option value="concluido-com-sucesso"> Concluído com Sucesso</option>
                                <option value="concluido-com-restricao"> Concluído com Restrição</option>
                                <option value="concluido-com-duplicata"> Concluído com Duplicata</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">


                    </div>

                </div>

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-1" id="cancelEvaluation" style="display:none;">
                            <button type="button" class="btn btn-danger" onclick="toEvaluate('cancel')" data-toggle="collapse" data-target="#evaluationBox">Cancelar</button>
                        </div>
                        <div {!! ($taskData->taskStatus == 'Em Aberto')? "style='display: none', class='col-sm-1'" : "style='display: block', class='text-right'"!!}} id="buttonSave" >
                            <button class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
@endif
@endif
@endif
@endif
@endif
@endsection
@section('morejs')
<script type="text/javascript">
    function toEvaluate(opt) {

        var box = document.getElementById('evaluationBox');
        var buttonEvaluate = document.getElementById('firstEvaluation');
        var buttonCancel = document.getElementById('cancelEvaluation');

        if (opt == "start") {
            $("#evaluationBox").on("show.bs.collapse");
            buttonEvaluate.style.display = "none";
            buttonCancel.style.display = "block";
            buttonSave.style.display = "block";
        } else if (opt == "cancel") {
            $("#evaluationBox").on("hide.bs.collapse");
            buttonCancel.style.display = "none";
            buttonEvaluate.style.display = "block";
            buttonSave.style.display = "none";


        }

    }

    function onCheckedStatus(opt) {
        if (opt == 'success') {
            document.getElementById('successOptions').style.display = 'block';
        } else {
            document.getElementById('successOptions').style.display = 'none';
        }


    }

    function onCheckedDuplicated() {

        var list = document.getElementsByClassName("duplicateOptions");

        if (document.getElementById('duplicated').checked) {
            document.getElementById('forecastService').style.display = 'none';
            document.getElementById('inputForecastService').required = false;
            updateDescription();
            for (var i = 0; i < list.length; i++) {
                list[i].style.display = 'block';
            }
        } else {
            document.getElementById('forecastService').style.display = 'block';
            document.getElementById('inputForecastService').required = true;

            for (var i = 0; i < list.length; i++) {
                list[i].style.display = 'none';
            }
        }
    }

    function updateDescription() {
        var varItens = document.getElementById('selectOriginal');
        var text = "Nenhum item selecionado";
        for (i = 0; i < varItens.length; i++) {
            if (varItens.options[i].selected) {
                text = varItens.options[i].id
            }
        }
        document.getElementById("descriptionOriginalTask").innerHTML = text;
    }
    $(function() {
        $('#datetimepicker1').datetimepicker({

            format: "DD/MM/YYYY"


        });


    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endsection
@stop
