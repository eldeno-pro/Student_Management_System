<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System') - MUBS AWAD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --mubs-primary: #003366;
            --mubs-accent: #e67e22;
        }
        .navbar-mubs {
            background-color: var(--mubs-primary);
        }
        .badge-mubs {
            background-color: var(--mubs-accent);
        }
        .footer-mubs {
            background-color: #0f172a;
            color: #cbd5e1;
        }
        .card-stat {
            border-left: 4px solid var(--mubs-primary);
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header & Navigation Bar (Question 5a & 5d) -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-mubs shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <i class="bi bi-mortarboard-fill fs-4 text-warning"></i>
                    <span>MUBS SMS <span class="fw-light small opacity-75">| BUC3131</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    @auth
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- Dashboard link tailored to role -->
                            <li class="nav-item">
                                @if(auth()->user()->hasRole('admin'))
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
                                    </a>
                                @elseif(auth()->user()->hasRole('lecturer'))
                                    <a class="nav-link {{ request()->routeIs('lecturer.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('lecturer.dashboard') }}">
                                        <i class="bi bi-person-workspace me-1"></i> Lecturer Dashboard
                                    </a>
                                @elseif(auth()->user()->hasRole('student'))
                                    <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('student.dashboard') }}">
                                        <i class="bi bi-backpack4 me-1"></i> Student Portal
                                    </a>
                                @endif
                            </li>

                            <!-- Conditional Navigation Links by Permission / Role (Question 5d) -->
                            @can('manage-students')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('students.*') ? 'active fw-bold' : '' }}" href="{{ route('students.index') }}">
                                        <i class="bi bi-people me-1"></i> Students
                                    </a>
                                </li>
                            @endcan

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('courses.*') ? 'active fw-bold' : '' }}" href="{{ route('courses.index') }}">
                                    <i class="bi bi-journal-bookmark me-1"></i> Courses
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('registrations.*') ? 'active fw-bold' : '' }}" href="{{ route('registrations.index') }}">
                                    <i class="bi bi-card-checklist me-1"></i> Registrations
                                </a>
                            </li>
                        </ul>

                        <!-- User Profile & Logout -->
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-white small">
                                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                                <span class="badge bg-light text-dark ms-1 text-uppercase">{{ auth()->user()->roles->pluck('name')->first() }}</span>
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            <!-- Breadcrumbs / Page Title Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 fw-bold text-dark mb-0">@yield('page_title', 'Student Management System')</h2>
                    <small class="text-muted">@yield('page_subtitle', 'Makerere University Business School')</small>
                </div>
                <div>
                    @yield('page_actions')
                </div>
            </div>

            <!-- Global Feedback Messages (Question 4e & 5c) -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-2"></i> Please fix the following errors:</div>
                    <ul class="mb-0 ps-4 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Content Section (Question 5a) -->
            @yield('content')
        </div>
    </main>

    <!-- Reusable Footer (Question 5a) -->
    <footer class="footer-mubs py-3 mt-auto text-center small">
        <div class="container">
            <p class="mb-1"><strong>Makerere University Business School</strong> — Coursework Two (BUC3131: Advanced Web Application Development)</p>
            <p class="text-secondary mb-0">Developed collaboratively by Denis Wawomola, Namwase Whitney, Muganga Anthony, & Nyaika Keith &copy; {{ date('Y') }}</p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
