<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <br>
    <li class="menu-item {{ Request::is('dashboard/admin') ? 'active' : '' }}">
        <a href="/dashboard/admin" class="menu-link ">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboards">Dashboards</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
    </li>
    <br>
    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Data </span>
    </li>

    {{-- akun --}}
<div class="mt-1"></div>

<li class="menu-item {{ Request::is('admin/akun*') ? 'active' : '' }}">
    <a href="/admin/akun" class="menu-link ">
        <i class="menu-icon tf-icons ti ti-star"></i>
        <div data-i18n="Dev Account">Dev Account</div>
        {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
    </a>
</li>


    
    

  

</ul>




















