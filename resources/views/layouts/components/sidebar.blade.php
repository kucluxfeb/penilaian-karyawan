@php
    $role = auth()->user()->role;

    $menuList = [
        [
            "title" => "Karyawan",
            "path" => "/employees",
            "icon" => "bi bi-person-lines-fill",
            "roles" => ["Admin", "Karyawan"],
        ],
        [
            "title" => "Divisi",
            "path" => "/divisions",
            "icon" => "bi bi-diagram-3",
            "roles" => ["Admin"],
        ],
        [
            "title" => "Jurnal",
            "path" => "/journals",
            "icon" => "bi bi-journal-text",
            "roles" => ["Admin", "Karyawan", "Tim Penilai"],
        ],
        [
            "title" => "Kriteria",
            "path" => "/criterias",
            "icon" => "bi bi-list-check",
            "roles" => ["Admin", "Tim Penilai"],
        ],
        [
            "title" => "Penilaian",
            "path" => "/assessments",
            "icon" => "bi bi-star-half",
            "roles" => ["Tim Penilai", "Kepala Sekolah"],
        ],
        [
            "title" => "Hasil Penilaian",
            "path" => "/assessment/result",
            "icon" => "bi bi-star-fill",
            "roles" => ["Admin", "Tim Penilai", "Kepala Sekolah"],
        ],
    ];
@endphp

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="sidebar-brand-text mx-3">KINERJA+ IGAPIN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a href="/" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item -->
            @foreach ($menuList as $menu)
            @if (in_array($role, $menu['roles']))
            <li class="nav-item {{ request()->is(ltrim($menu['path'], '/')) ? 'active' : '' }}">
                <a href="{{ $menu['path'] }}" class="nav-link">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span>{{ $menu['title'] }}</span>
                </a>
            </li>
            @endif
            @endforeach

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>