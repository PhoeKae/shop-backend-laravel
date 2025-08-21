# Backend API Documentation

## Overview
This Laravel backend provides a comprehensive API for an e-commerce application with users, categories, and products (posts).

## Database Seeding
The database has been populated with realistic sample data including:
- **10 Users** (1 admin, 1 regular user, 8 additional users)
- **61 Categories** (10 main categories with 5-6 subcategories each)
- **105 Products** (posts) with realistic data

### Default Credentials
- **Admin**: admin@example.com / password
- **User**: user@example.com / password

## API Endpoints

### Authentication
- `GET /api/user` - Get authenticated user (requires auth:sanctum)

### Categories
- `GET /api/categories` - List all categories
- `POST /api/categories` - Create a new category
- `GET /api/categories/{id}` - Get specific category
- `PUT /api/categories/{id}` - Update category
- `DELETE /api/categories/{id}` - Delete category

### Products (Posts)
- `GET /api/posts` - List all products with pagination
- `POST /api/posts` - Create a new product
- `GET /api/posts/{id}` - Get specific product
- `PUT /api/posts/{id}` - Update product
- `DELETE /api/posts/{id}` - Delete product

#### Special Product Endpoints
- `GET /api/posts/featured` - Get featured products (high quantity, reasonable price)
- `GET /api/posts/low-stock` - Get products with low stock (1-10 items)
- `GET /api/posts/price-range` - Get products within price range
- `GET /api/posts/category/{category}` - Get products by category

### Query Parameters for Products
- `category_id` - Filter by category
- `min_price` / `max_price` - Filter by price range
- `in_stock` - Filter by availability (true/false)
- `search` - Search in title and description
- `sort_by` - Sort field (default: created_at)
- `sort_order` - Sort direction (asc/desc, default: desc)
- `per_page` - Items per page (default: 12)

## Data Models

### User
- name, email, password, role_id
- Relationships: hasMany(Post), belongsTo(Role)

### Role
- name (admin/user)
- Relationships: hasMany(User)

### Category
- name, parent_id (for hierarchical structure)
- Relationships: hasMany(Post), hasMany(Category), belongsTo(Category)

### Post (Product)
- thumbnail, title, description, quantity, price, category_id, user_id
- Relationships: belongsTo(Category), belongsTo(User)

## Sample API Responses

### Featured Products
```json
{
  "success": true,
  "data": [
    {
      "id": 55,
      "title": "Bestselling Fiction Novel",
      "description": "Award-winning fiction novel...",
      "quantity": 200,
      "price": "19.99",
      "category": {
        "id": 26,
        "name": "Books & Media"
      },
      "user": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com"
      }
    }
  ],
  "message": "Featured posts retrieved successfully"
}
```

### Categories with Hierarchy
```json
[
  {
    "id": 1,
    "name": "Electronics",
    "parent_id": null
  },
  {
    "id": 2,
    "name": "Smartphones & Phones",
    "parent_id": 1
  }
]
```

## Database Structure

### Categories Table
- Hierarchical structure with parent_id for subcategories
- Main categories: Electronics, Clothing & Fashion, Home & Garden, Sports & Outdoors, Books & Media, Beauty & Health, Automotive & Vehicles, Toys & Games, Food & Beverages, Jewelry & Watches

### Posts Table
- Products with realistic pricing ($10 - $5000)
- Various quantities (0 - 200 items)
- Thumbnails using Picsum for random images
- Associated with categories and users

## Running the Application

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Start Server**
   ```bash
   php artisan serve
   ```

5. **Access API**
   - Base URL: http://localhost:8000
   - API Base: http://localhost:8000/api

## Features

- **Comprehensive Seeding**: Realistic product data with proper relationships
- **Hierarchical Categories**: Main categories with subcategories
- **Advanced Filtering**: Price, category, availability, search
- **Pagination**: Configurable items per page
- **User Management**: Role-based access control
- **Rich Product Data**: Images, descriptions, pricing, inventory

## Future Enhancements

- Authentication middleware for protected endpoints
- Image upload functionality
- Order management system
- Shopping cart functionality
- User reviews and ratings
- Advanced search with Elasticsearch
- API rate limiting
- Caching for improved performance
