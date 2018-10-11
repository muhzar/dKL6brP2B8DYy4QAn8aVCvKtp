<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(Auth::user()->image != '')
            <img src="{{ asset(config('app.folder_upload_images') . '/' . Auth::user()->image) }}" class="img-circle">
          @else
            <img src="{{ asset('backend/uploads/images/user-default.jpg') }}" class="img-circle">
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{ url('') }}">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/user') }}">
            <i class="fa fa-user"></i>
            <span>User</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/guard') }}">
            <i class="fa fa-user-secret"></i>
            <span>Guard</span>
          </a>
        </li>
        <!-- <li class="">
          <a href="{{ url('cms/schedule') }}">
            <i class="fa fa-user-secret"></i>
            <span>Schedule</span>
          </a>
        </li> -->
        <li class="">
          <a href="{{ url('cms/guardoncluster') }}">
            <i class="fa fa-user-secret"></i>
            <span>Cluster Guard</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/shift') }}">
            <i class="fa fa-user-secret"></i>
            <span>Shift</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/cluster') }}">
            <i class="fa fa-map"></i>
            <span>Cluster</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/cluster/setcheckpoint') }}">
            <i class="fa fa-flag-checkered"></i>
            <span>Check Point</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/route') }}">
            <i class="fa fa-flag-checkered"></i>
            <span>Route</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/livestreaming') }}">
            <i class="fa fa-flag-checkered"></i>
            <span>Live Streaming</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/report') }}">
            <i class="fa fa-flag-checkered"></i>
            <span>Guard Report</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('cms/history') }}">
            <i class="fa fa-flag-checkered"></i>
            <span>History</span>
          </a>
        </li>

        <!-- <li class="">
          <a href="{{ url('cms/log') }}">
            <i class="fa fa-user"></i>
            <span>Log</span>
          </a>
        </li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>