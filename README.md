# 🎮 WP Start

A starter WordPress framework.

## ✋ Requirements

| Dependency                    | Version  |
|-------------------------------|----------|
| [Node.js](https://nodejs.org) | ^18.17.1 |
| [Lando](https://lando.dev/)   | ^3.6.0   |

## 🏁 Getting Started

1. Copy `.env.example` to `.env`

        cp .env.example .env

2. Start the services

       lando start

3. Ensure you are running the correct node version

       nvm use

4. Install the project dependencies

       npm install

5. Create a `wp-config.php` file

       npm run config

6. Start the project watcher

       npm start
