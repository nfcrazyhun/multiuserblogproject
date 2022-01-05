
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Multi User Blog Project
## About this app
This web application made in:\
**TALL** stack - **T**ailwind, **A**lpine.js, **L**aravel, **L**ivewire

**This application made for learning purpose.**

##Features
**You can expect functionalities like:**

- Full responsive (mobile friendly) design
- The Home page lists users published posts (Newest first)
- You can filter results by clicking on the author's name or the category name

**After registration:**

- On your admin page, you can see all your posts,
    - including: Draft, Pending, Published, Archived
- You can sort posts every columns by clicking on the column title
- Supports Advanced Search by:
    - Title
    - Category
    - Status
    - Created at (min,max)
    - Published at (min,max)
- Can create new post or edit existing one
    - Editor includes WYSIWYG editor
    - Interactive upload for cover image
    - Image preview
    - Field validations
    - Auto slug form title.
- Delete posts
- Restore deleted post
- Note:  delete = archive
- Update your profile information
- Real-time field validations (on some inputs)
- During mage uploads:
    - Avatar: automatic resize to (1:1) aspect ratio
    - Cover:  automatic resize to (3:2) aspect ratio
- And some nice-to-have quality of life features.

## Installation guide
1. Open a terminal
2. Clone this repository
```
git clone https://github.com/nfcrazyhun/multiuserblogproject.git
```
3. `cd` into it

4. Install dependencies
```
composer install
```
5. (Optional) Install npm packages and build Webpack
```
npm install
npm run dev
```
6. Copy then rename .env.example to .env
```
copy .env.example .env
```
7. Generate application key
```
php artisan key:generate
```
8. Create symbolic links
```
php artisan storage:link
```
9. Create a database. (collation: utf8mb4_unicode_ci)

10. Update database credentials in the .env

11. **Absolutely update** the **APP_URL** line in the **.env** file  
    to your virtual host name **or** the **images** definitely **will be broken.**

12. Set up database tables (with demo data)
```
php artisan migrate:refresh --seed
```

### The application comes with default admin.
-   email: `admin@admin.com`
-   password: `admin`

## Note
The project was made with the following software versions:
- PHP 8.0.12
- Laravel Framework 8.78.0
- Tailwind CSS 3.0.10
- Alpine.js 3.7.1
- Livewire 2.8.2

And conditionally included form CDNs:
- Trix - for rick text editor
- Pikaday - for date picker
- FilePond - for image upload

## Roadmap
- page where super admin can see and modify all users posts
- comment section
- messaging system between users

## Screenshots
