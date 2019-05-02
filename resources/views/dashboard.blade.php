@extends('base')
@section('title')
Início
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Início
      <small>{{ Auth::user()->name }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Início</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-grey-ufop">
          <div class="inner">
            <h3>4</h3>

            <p>Total de Chamados</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue-ufop">
          <div class="inner">
            <h3>0</h3>

            <p>Em aberto</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue-2-ufop">
          <div class="inner">
            <h3>0</h3>

            <p>Aguardando atendimento</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow-ufop">
          <div class="inner">
            <h3>0</h3>

            <p>Em atendimento</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red-ufop">
          <div class="inner">
            <h3>0</h3>

            <p>Em Espera</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green-ufop">
          <div class="inner">
            <h3>4</h3>

            <p>Concluídos</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">Ver detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
</section>
@stop