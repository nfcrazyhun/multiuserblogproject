
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
![1-home-page-min](https://user-images.githubusercontent.com/47859399/148252688-796f2874-e1c2-4053-97b5-27f3fa45a72f.png)
![2-home-page-responsive-min](https://user-images.githubusercontent.com/47859399/148252703-be4b76ee-493c-4102-8220-e1b1d4187f83.png)
![3-post-show-min](https://user-images.githubusercontent.com/47859399/148252711-570542a9-200f-4d1f-a007-b4e9cd2b1c57.png)
![4-post-show-responsive-min](https://user-images.githubusercontent.com/47859399/148252714-1fdf0f4c-1634-4fb0-93b5-c17ff5689699.png)
![5-hamburger-menu-min](https://user-images.githubusercontent.com/47859399/148252727-163e050d-b9bc-4ead-aa7a-12630cb48042.png)
![6-admin-posts-index-min](https://user-images.githubusercontent.com/47859399/148252732-a6021d27-7094-45e9-8d26-eb8f9c604ae5.png)
![7-admin-posts-advanced-search-min](https://user-images.githubusercontent.com/47859399/148252746-397ec035-ef03-45bb-8d47-4cf37918ac2f.png)
![8-admin-edit-post-min](https://user-images.githubusercontent.com/47859399/148252759-f416d3d8-3565-4df9-b9a7-115ffa8da88b.png)
![9-admin-delete-post-min](https://user-images.githubusercontent.com/47859399/148252768-39d60a7e-1d0a-47e3-af12-df24c19b01c0.png)
![10-test-coverage-min](https://user-images.githubusercontent.com/47859399/148252777-9b732b74-de85-42d8-8038-f5108ac63bc6.png)
