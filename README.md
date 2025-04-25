# Argalesong
## System Requirements

Before setting up the application, ensure your system meets the following requirements:

- **Composer**: 2.7.4
- **PHP**: 8.3.7
- **Node.js**: 20.9.0

## Installation Guide

Follow these steps to configure and run the application:

### 1. Clone the Repository

```bash
git clone https://github.com/Mkeyzxi/argalesong.git
cd argalesong
```

### 2. Install Composer Dependencies
Install the necessary PHP dependencies using Composer:

```bash
composer install
```
### 3. Configure the Environment File
Copy the example environment file and configure it according to your environment:
```bash
cp .env.example .env
```

### 4. Install Node.js Dependencies
Install the required frontend dependencies using npm:
```bash
npm install
```

### 5. Generate Application Key
Generate a unique application key:
```bash
php artisan key:generate
```
### 6. Build Frontend Assets
For production:
```bash
npm run build
```
For development:

```bash
npm run dev
```
### Jalankan Program 
```bash
php artisan serve
```





