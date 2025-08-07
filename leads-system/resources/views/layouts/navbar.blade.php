<nav
    style="
    padding: 15px 30px;
    border-bottom: 1px solid #ccc;
    background-color: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: Arial, sans-serif;
">
    <div style="display: flex; gap: 20px;">
        <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #333;"
            onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#333'">Dashboard</a>
        <a href="{{ route('leads.index') }}" style="text-decoration: none; color: #333;"
            onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#333'">Leads</a>
        <a href="{{ route('leads.create') }}" style="text-decoration: none; color: #333;"
            onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#333'">Add Lead</a>
        <a href="{{ route('leads.export') }}" style="text-decoration: none; color: #333;"
            onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#333'">Export CSV</a>
    </div>

    <div>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            style="text-decoration: none; color: #dc3545;" onmouseover="this.style.color='#bd2130'"
            onmouseout="this.style.color='#dc3545'">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
