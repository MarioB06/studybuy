<style>
    .header {
        background: white;
        border-bottom: 1px solid #e0e0e0;
        padding: 20px 40px;
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 24px;
        font-weight: 600;
        text-decoration: none;
        color: #000;
    }

    .logo-icon {
        width: auto;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-size: 15px;
    }

    .nav-links a:hover {
        color: #000;
    }

    .nav-links form {
        margin: 0;
    }

    .logout-button {
        background: none;
        border: none;
        color: #333;
        font-size: 15px;
        cursor: pointer;
        padding: 0;
        font-family: inherit;
    }

    .logout-button:hover {
        color: #000;
    }

    .admin-badge {
        background: #1aa8ba;
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<header class="header">
    <div class="header-container">
        <a href="{{ route('dashboard') }}" class="logo">
            <x-application-logo class="logo-icon" />
        </a>
        <nav class="nav-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Alle Produkte</a>
            <a href="{{ route('my-products.index') }}">Käufe & Verkäufe</a>
            <a href="{{ route('chats.index') }}">Chats</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @endif
            <a href="{{ route('profile.edit') }}">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Abmelden</button>
            </form>
        </nav>
    </div>
</header>
