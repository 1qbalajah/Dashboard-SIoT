<aside class="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="sidebar-logo-img">AM</div>
        <span class="sidebar-logo-text">Azure Metrics</span>
    </div>
    
    <!-- Navigation -->
    <nav>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link" data-match="/dashboard">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/device" class="nav-link" data-match="/device">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                    Device
                </a>
            </li>
            <li class="nav-item">
                <a href="/sensor" class="nav-link" data-match="/sensor">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Sensor
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="nav-login">
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Ambil path URL saat ini (contoh: "/dashboard" atau "/device")
        const currentPath = window.location.pathname;
        
        // 2. Pilih semua link navigasi
        const navLinks = document.querySelectorAll('.nav-link');
        
        // 3. Loop dan cocokkan dengan atribut data-match
        navLinks.forEach(link => {
            const matchPath = link.getAttribute('data-match');
            
            // Jika URL cocok, tambahkan class 'active'
            if (matchPath && currentPath.startsWith(matchPath)) {
                link.classList.add('active');
            }
        });
    });
</script>