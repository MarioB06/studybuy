# 🎒 StudyBuy

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> **Marktplatz für studienrelevante Second-Hand-Objekte**  
> Von Studis für Studis – einfach, sicher und nachhaltig

## 📖 Über StudyBuy

StudyBuy ist ein spezialisierter Re-Commerce-Marktplatz für Studierende an Universitäten und Fachhochschulen. Die Plattform ermöglicht den einfachen, sicheren und lokalen Handel von studienrelevanten Objekten wie:

- 💻 **Elektronik** (iPads, Laptops, Tablets)
- 📚 **Fachbücher** und Lehrmaterial
- 🖩 **Taschenrechner** (TI-84, Casio, etc.)
- 🎒 **Zubehör** (Rucksäcke, Schreibwaren, etc.)

### 🎯 Vision & Mission

**Vision:** Der führende Marktplatz für studentische Second-Hand-Objekte im DACH-Raum zu werden.

**Mission:** 
- 🌱 **Nachhaltigkeit**: Wiederverwendung statt Neukauf – Reduktion von Ressourcenverbrauch und CO₂-Fussabdruck
- 💰 **Erschwinglichkeit**: Zugang zu günstigen Studienmaterialien für alle
- 🤝 **Gemeinschaft**: Eine vertrauenswürdige Community durch Verified-Student-Registrierung
- ❤️ **Soziale Verantwortung**: Unterstützung bedürftiger Studierender durch einen Studentenfonds

## ✨ Features

### 🔐 Verified Student System
- Registrierung mit universitärer E-Mail-Adresse
- Erhöhte Sicherheit und Vertrauen innerhalb der Community
- Zugang nur für verifizierte Studierende

### 🛍️ Marktplatz-Funktionen
- **Produktinserate** mit bis zu 5 Bildern
- **Kategorisierung** nach Produkttypen
- **Schulen/Universitäten** Filter für lokale Angebote
- **Suchfunktion** für schnelles Finden von Produkten
- **Produktdetailseiten** mit vollständigen Informationen

### 👨‍💼 Admin-Bereich
- Dashboard mit Übersicht und Statistiken
- Verwaltung von Kategorien
- Verwaltung von Schulen/Universitäten
- Benutzerverwaltung mit Admin-Rollen

### 💳 Zahlungsabwicklung (geplant)
- Integration mit Stripe für sichere Zahlungen
- Transaktionsprotokollierung
- 5% Plattformgebühr (Take-Rate)

## 🛠️ Technologie-Stack

### Backend
- **Framework**: Laravel 11.x
- **PHP**: 8.2+
- **Datenbank**: MySQL
- **Authentication**: Laravel Breeze

### Frontend
- **Views**: Blade Templates
- **Styling**: Inline CSS (MVP-Phase)
- **JavaScript**: Alpine.js
- **Icons**: FontAwesome

### Deployment
- **Server**: Apache/Nginx
- **Asset Management**: Laravel Mix/Vite
- **Storage**: Local File Storage (S3 ready)

## 📁 Projektstruktur

```
studybuy/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin-Controller
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── SchoolController.php
│   │   │   ├── Auth/           # Authentifizierung
│   │   │   ├── ProductController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php     # Admin-Middleware
│   │   └── Requests/
│   └── Models/
│       ├── Product.php
│       ├── ProductCategory.php
│       ├── ProductImage.php
│       ├── School.php
│       └── User.php
├── database/
│   ├── migrations/              # Datenbank-Migrationen
│   └── seeders/
│       └── ProductCategorySeeder.php
├── resources/
│   └── views/
│       ├── admin/              # Admin-Views
│       ├── auth/               # Login/Register
│       ├── products/           # Produkt-Views
│       ├── profile/            # Profil-Views
│       └── dashboard.blade.php
├── routes/
│   ├── web.php                 # Web-Routen
│   └── auth.php                # Auth-Routen
└── public/
    └── storage/                # Öffentlicher Storage Link
```

## 🗄️ Datenbank-Schema

### Haupttabellen

- **users** - Benutzer mit Admin-Flag (`bit`)
- **schools** - Universitäten und Hochschulen
- **product_categories** - Produktkategorien mit Icons
- **products** - Produktinserate
- **product_images** - Produktbilder (1:n Relation)
- **stripe_payment_logs** - Zahlungsprotokollierung (vorbereitet)

## 🎨 Design-Prinzipien

### Farbschema
- **Primary**: `#1aa8ba` (Türkis) - Call-to-Actions, Links
- **Background**: `#f8f9fa` (Hellgrau)
- **Cards**: `#ffffff` (Weiß)
- **Text**: `#000000`, `#333333`, `#666666`

### UI/UX Philosophie
- **Minimalistisch**: Fokus auf Inhalte, nicht auf Design-Elemente
- **Studentenfreundlich**: Einfache, intuitive Navigation
- **Mobile First**: Responsive Design für alle Geräte
- **Schnell**: Optimierte Ladezeiten, keine überflüssigen Animationen

## 🔑 Berechtigungen & Rollen

### Benutzer-Typen

1. **Gast** - Kann Produkte durchsuchen
2. **Registrierter User** - Kann kaufen und verkaufen
3. **Admin** (`bit = true`) - Voller Zugriff auf Admin-Bereich

### Admin-Funktionen
- Kategorie-Management
- Schulen-Management
- Benutzer-Übersicht
- Statistiken und Analytics

## 📧 Kontakt

- **Email**: info@studybuy.ch
- **Website**: [studybuy.ch](https://studybuy.ch)
- **GitHub**: [@studybuy](https://github.com/mariob06/studybuy)

---

**Hinweis**: Dies ist ein MVP-Projekt in aktiver Entwicklung. Features und Design können sich ändern.

