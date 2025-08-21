# 🛍️ Shop Backend API

A robust Laravel-based backend API for an e-commerce application with comprehensive product management, user authentication, and hierarchical category systems.

## ✨ Features

- **🛒 Product Management**: Full CRUD operations for products with inventory tracking
- **🏷️ Hierarchical Categories**: Multi-level category system with parent-child relationships
- **👥 User Management**: Role-based access control (Admin/User)
- **🔍 Advanced Filtering**: Search, filter by category, price range, and availability
- **📊 Rich Data**: Comprehensive seeding with realistic product data
- **🚀 RESTful API**: Clean, well-structured API endpoints

## 🏗️ Architecture

- **Framework**: Laravel 11.x
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum
- **API**: RESTful with JSON responses

## 🚀 Quick Start

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
php artisan migrate:fresh --seed
```

### 4. Start Server
```bash
php artisan serve
```

## 📊 Database Structure

- **Users**: 10 users with role-based access
- **Categories**: 61 categories in hierarchical structure
- **Products**: 105 products with realistic data

## 🔐 Default Credentials

- **Admin**: admin@example.com / password
- **User**: user@example.com / password

## 📡 API Endpoints

### Base URL: `http://localhost:8000/api`

#### Categories
- `GET /categories` - List all categories
- `POST /categories` - Create category
- `GET /categories/{id}` - Get category
- `PUT /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category

#### Products
- `GET /posts` - List all products (paginated)
- `POST /posts` - Create product
- `GET /posts/{id}` - Get product
- `PUT /posts/{id}` - Update product
- `DELETE /posts/{id}` - Delete product

#### Special Endpoints
- `GET /posts/featured` - Featured products
- `GET /posts/low-stock` - Low stock products
- `GET /posts/price-range` - Products by price range
- `GET /posts/category/{category}` - Products by category

## 🔍 Query Parameters

- `category_id` - Filter by category
- `min_price` / `max_price` - Price range filter
- `in_stock` - Availability filter
- `search` - Search in title/description
- `sort_by` - Sort field
- `sort_order` - Sort direction
- `per_page` - Items per page

## 🗄️ Main Categories

1. **Electronics** - Smartphones, Laptops, Tablets
2. **Clothing & Fashion** - Apparel, Footwear, Accessories
3. **Home & Garden** - Furniture, Appliances, Garden Tools
4. **Sports & Outdoors** - Fitness, Camping, Bicycles
5. **Books & Media** - Fiction, Non-fiction, Movies, Music
6. **Beauty & Health** - Skincare, Makeup, Wellness
7. **Automotive & Vehicles** - Car Parts, Tools, Electronics
8. **Toys & Games** - Board Games, Video Games, Educational
9. **Food & Beverages** - Organic Foods, Beverages, Snacks
10. **Jewelry & Watches** - Necklaces, Rings, Watches

## 🛠️ Development Commands

```bash
# Run tests
php artisan test

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# List routes
php artisan route:list

# Database operations
php artisan migrate:fresh --seed
php artisan db:wipe
```

## 📁 Project Structure

```
app/
├── Http/Controllers/Api/     # API Controllers
├── Models/                   # Eloquent Models
└── Providers/               # Service Providers

database/
├── factories/               # Model Factories
├── migrations/              # Database Migrations
└── seeders/                 # Database Seeders

routes/
└── api.php                  # API Routes
```

## 🔧 Configuration

Update `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shop_backend
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🚀 Deployment

### Production Checklist
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Configure production database
- Set up proper CORS origins
- Configure caching
- Set up SSL certificates

## 📚 Documentation

For detailed API documentation, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License.

---

**Built with ❤️ using Laravel**
