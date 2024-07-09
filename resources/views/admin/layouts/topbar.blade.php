<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar sticky-top mb-4 shadow">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" id="sidebarToggle">
        <i class="bi bi-map-fill"></i>
      </a>
    </li>
    <li class="nav-item {{Request::is('notifikasi*') ? 'active': ''}}">
      <a class="nav-link" href="/notifikasi">
        <i class="bi bi-bell-fill"></i>
      </a>
    </li>
  </ul>

    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        @auth
        @if(auth()->user()->profile_photo == '-')
          <a class="nav-link" data-toggle="dropdown" href="#">{{auth()->user()->username}}<img src="/storage/defaultfoto.png" alt="Foto Profil" class="rounded-circle mx-2" width="40" height="40"><i class="bi bi-caret-down-fill"></i></a>
        @else
          <a class="nav-link" data-toggle="dropdown" href="#">{{auth()->user()->username}}<img src="/storage/{{auth()->user()->profile_photo}}" alt="Foto Profil" class="rounded-circle mx-2" width="40" height="40"><i class="bi bi-caret-down-fill"></i></a>
        @endif
        @endauth
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="/editprofile" class="dropdown-item"><b>Edit Profil</b></a>
          <a href="/laporkanmasalah/create" class="dropdown-item"><b>Laporkan Masalah</b></a>
          <form action="/logout" method="post">
              @csrf
              <button href="/logout" class="dropdown-item"><b>Logout</b></button>
          </form>
        </div>
      </li>
    </ul>
  </nav>
    <!-- <ul class="navbar-nav ml-auto my-3">
        <li class="nav-link">
            <form action="/logout" method="post">
                @csrf
                <button href="/logout" class="btn btn-primary my-3"> Logout</button>
    
            </form>
        </li>
    </ul>
</nav> -->
<!-- End of Topbar -->
