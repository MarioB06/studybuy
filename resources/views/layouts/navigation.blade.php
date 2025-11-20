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
        width: 32px;
        height: 32px;
        background: #000;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
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
            <div class="logo-icon">🎒</div>
            <span>StudyBuy</span>
        </a>
        <nav class="nav-links">
            <a href="{{ route('profile.edit') }}">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Abmelden</button>
            </form>
        </nav>
    </div>
</header>
