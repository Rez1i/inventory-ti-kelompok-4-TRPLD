<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img class="nav-brand me-auto" src="img/siibala-icon-light.png" alt="">
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title p-2" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close mx-2" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 active" aria-current="page" href="index.html">Home</a>
                        </li>
                        <li class="nav-item mx-lg-2">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown mx-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            @auth
            <form action="/logout" method="post">
                @csrf
                <button type="submit" class="login-button mx-2">Logout</button>
            </form>
            @else
            <a class="login-button mx-2" href="/login">Login</a>
           
            @endauth

            
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>
