@section('title')
Detalhes do Chamado
@stop
@extends('base')
@section('content')

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
            <strong><i class="fa fa-calendar margin-r-5"></i> Data de Abertura</strong>
      
            <p class="text-muted">
              {{date( 'd-m-Y H:i:s' , strtotime($taskData->openingDate))}}
            </p>
      
            <hr>
      
            <strong><i class="fa fa-user margin-r-5"></i> Solicitante</strong>
      
            <p class="text-muted">
              {{$taskData}}
            </p>
      
            <hr>
      
            <strong><i class="fa fa-envelope margin-r-5"></i> Descrição</strong>
      
            <p class="text-muted">teste</p>
      
            <hr>
      
            <strong><i class="fa fa-file-text margin-r-5"></i> Local do Problema</strong>
      
            <p class="text-muted">teset</p>
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
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Patrimônio</label>
              <input type="text" name="patrimony" id="patrimony" data-mask="000000" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-check align-form">
              <input type="checkbox" class="form-check-input" id="checkPatrimony">
              <label class="form-check-label">Não possui patrimônio</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Descrição</label>
              <textarea name="description" class="form-control"
                placeholder="Escreva uma breve descrição do problema ocorrido." rows="3" required></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Local</label>
              <select class="form-control" name="locale">
  
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Categoria</label>
              <select class="form-control" name="category">

              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Observações</label>
              <textarea name="notes" class="form-control" placeholder="Observações quanto ao problema ocorrido."
                required rows="3"></textarea>
            </div>
          </div>
        </div>
        
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Histórico</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Patrimônio</label>
                    <input type="text" name="patrimony" id="patrimony" data-mask="000000" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-check align-form">
                    <input type="checkbox" class="form-check-input" id="checkPatrimony">
                    <label class="form-check-label">Não possui patrimônio</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="description" class="form-control"
                      placeholder="Escreva uma breve descrição do problema ocorrido." rows="3" required></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Local</label>
                    <select class="form-control" name="locale">
        
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Categoria</label>
                    <select class="form-control" name="category">
      
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Observações</label>
                    <textarea name="notes" class="form-control" placeholder="Observações quanto ao problema ocorrido."
                      required rows="3"></textarea>
                  </div>
                </div>
              </div>
</section>

@stop