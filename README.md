# CyberTweet

A cyberpunk-themed social network with real-time interactions and a neon-soaked UI.

## ⚡ Core Features

### 🔐 Authentication & Profiles
- Secure user registration and login
- Customizable user profiles
- Username generation system
- Profile photo support

### 📱 Social Features
- Create and share posts
- Like and repost functionality
- User following system
- Real-time feed updates
- Profile statistics tracking

### #️⃣ Content Organization
- Hashtag system
- Trending topics
- Advanced search functionality
- Post categorization

### 🎨 Cyberpunk UI
- Neon color scheme
- Glitch effects
- Responsive design
- Dark mode optimized

## 🚀 Tech Stack

- **Backend:** Laravel 10.x
- **Frontend:** Vue.js 3
- **Styling:** Tailwind CSS
- **Bridge:** Inertia.js
- **Database:** PostgreSQL

## 💻 Requirements

- PHP >= 8.1
- Node.js >= 16.x
- Composer
- PostgreSQL
- Git

## 🔧 Installation

1. Clone and setup
```bash
git clone <repository-url>
cd cybertweet
composer install
npm install
```

2. Environment
```bash
cp .env.example .env
php artisan key:generate
```

3. Database
```bash
php artisan migrate:fresh --seed
```

4. Development servers
```bash
php artisan serve
npm run dev
```

## 🛠️ Key Components

- **Posts:** Create, like, repost
- **Profiles:** Follow, stats, customization
- **Search:** Users, posts, hashtags
- **Feed:** Real-time updates
- **Hashtags:** Trending, categorization

## 🎨 Features

- Cyberpunk-themed UI
- Real-time updates
- User following system
- Hashtag system
- Post interactions
- Search functionality

## 📝 Development

- **Routes:** `routes/web.php`
- **Components:** `resources/js/Pages`
- **Styling:** `resources/css/app.css`

## 🔐 Security

- Secure authentication
- CORS protection
- Rate limiting
- XSS prevention
- CSRF protection

## 📄 License

[MIT License](LICENSE.md)

---
*Connecting users in the digital frontier* 🌃
