<li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);"
        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
            data-feather="bell"></i>
            @if($notification['count_notif'] > 0)
            <span class="badge bg-danger">{{ $notification['count_notif'] }}</span>
            @endif
        </a>
    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
        aria-labelledby="navbarDropdownAlerts">
        <h6 class="dropdown-header dropdown-notifications-header">
            <i class="me-2" data-feather="bell"></i>
            Alerts Center
        </h6>
        @if ($notification['count_notif'] == 0)
        <p class="dropdown-item dropdown-notifications-item" >No Have Notification</p>
        @else
        @foreach($notification['stok'] as $item)
        <a class="dropdown-item dropdown-notifications-item" href="starter-minimal.html#!">
            <div class="dropdown-notifications-item-icon bg-danger"><i data-feather="package"></i></div>
            <div class="dropdown-notifications-item-content">
                <div class="dropdown-notifications-item-content-details">
                    {{ \Carbon\Carbon::parse($item['updated_at'])->formatLocalized('%Y-%B-%d') }}
                </div>
                <div class="dropdown-notifications-item-content-text">
                    {{ $item['nama'] }} sisa {{ $item['jumlah'] }} {{-- Menampilkan nama barang dan jumlah --}}
                </div>
            </div>
        </a>
        @endforeach
        @endif
        
        <a class="dropdown-item dropdown-notifications-footer" href="starter-minimal.html#!">View All Alerts</a>
    </div>
</li>
