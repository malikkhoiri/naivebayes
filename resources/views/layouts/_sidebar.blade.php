<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{url('/home')}}" class="" id="dashboard"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li><a href="{{url('/question')}}" class="" id="question"><i class="lnr lnr-file-empty"></i> <span>Unggah Soal</span></a></li>
                <li><a href="{{url('/answer')}}" class="" id="answer"><i class="lnr lnr-list"></i> <span>Unggah Jawaban</span></a></li>
                <li><a href="{{url('/analysis')}}" class="" id="analysis"><i class="lnr lnr-inbox"></i> <span>Analisis Soal</span></a></li>
                @if(auth()->user()->role == 1)
                <li><a href="{{url('/process')}}" class="" id="process"><i class="lnr lnr-code"></i> <span>Proses</span></a></li>
                <li><a href="{{url('/training')}}" class="" id="training"><i class="lnr lnr-database"></i> <span>Training Data</span></a></li>
                <li><a href="{{route('user.index')}}" class="" id="user"><i class="lnr lnr-users"></i> <span>User</span></a></li>
                @endif
                <!-- <li><a href="elements.html" class=""><i class="lnr lnr-code"></i> <span>Elements</span></a></li>
                <li><a href="charts.html" class=""><i class="lnr lnr-chart-bars"></i> <span>Charts</span></a></li>
                <li><a href="panels.html" class=""><i class="lnr lnr-cog"></i> <span>Panels</span></a></li>
                <li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            <li><a href="page-profile.html" class="">Profile</a></li>
                            <li><a href="page-login.html" class="">Login</a></li>
                            <li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="tables.html" class=""><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
                <li><a href="typography.html" class=""><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
                <li><a href="icons.html" class=""><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li> -->
            </ul>
        </nav>
    </div>
</div>
