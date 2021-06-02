    <!-- sidebar: style can be found in sidebar.less -->
    @if(\Illuminate\Support\Facades\Auth::check())
    <section class="sidebar" style="height: auto">
         <sidebarcom auth="{{$AuthUser}}" />
    </section>
    @endif
    <!-- /.sidebar -->
