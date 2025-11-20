<x-app-layout>
    <style>
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .profile-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
            margin-bottom: 40px;
        }

        .profile-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 0 20px;
            }
        }
    </style>

    <div class="profile-container">
        <h1 class="profile-title">Profil</h1>

        <div class="profile-section">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-section">
            @include('profile.partials.update-password-form')
        </div>

        <div class="profile-section">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
