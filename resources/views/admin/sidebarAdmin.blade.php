@section('sidebar')
<li class="treeview" {!! Route::is('showAdminGeneral',['type'=> "em-aberto"]) ? "class='active menu-open'" : '' !!}>
    <a href="#">
        <i class="fa fa-server"></i> <span>Chamados gerais</span>

    </a>
    <ul class="treeview-menu">
        <li {!! Route::is('showAdminGeneral',['type'=> "em-aberto"]) ? "class='active'" : '' !!}><a href="{{Route('showAdminGeneral', ['type' => "em-aberto"])}}"><i class="fa fa-circle-o"></i> Em Aberto</a></li>
        <li {!! Route::is('showAdminGeneral',['type'=> "aguardando-atendimento"]) ? "class='active'" : '' !!}><a href="{{Route('showAdminGeneral', ['type' => "aguardando-atendimento"])}}"><i class="fa fa-circle-o"></i> Aguardando Atendimento</a></li>
        <li {!! Route::is('showAdminGeneral',['type'=> "todos"]) ? "class='active'" : '' !!}><a href="{{Route('showAdminGeneral', ['type' => "todos"])}}"><i class="fa fa-circle-o"></i> Todos</a></li>


    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-ship"></i>
        <span>Meus Atendimentos</span>
        <span class="pull-right-container">
            <span class="label label-primary pull-right">4</span>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{Route('showAdminMyCalls', ['type' => "em-atendimento"])}}"><i class="fa fa-circle-o"></i> Em Atendimento</a></li>
        <li><a href="{{Route('showAdminMyCalls', ['type' => "em-espera"])}}"><i class="fa fa-circle-o"></i> Em Espera</a></li>
        <li><a href="{{Route('showAdminMyCalls', ['type' => "concluido"])}}"><i class="fa fa-circle-o"></i> Concluídos</a></li>
    </ul>
</li>
@stop
