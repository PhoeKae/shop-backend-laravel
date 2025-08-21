<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the posts/products.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Post::with(['category', 'user']);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by availability
        if ($request->has('in_stock')) {
            if ($request->in_stock) {
                $query->where('quantity', '>', 0);
            } else {
                $query->where('quantity', '<=', 0);
            }
        }

        // Search by title or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort by different fields
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $posts = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => 'Posts retrieved successfully'
        ]);
    }

    /**
     * Display the specified post/product.
     */
    public function show(Post $post): JsonResponse
    {
        $post->load(['category', 'user']);
        
        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post retrieved successfully'
        ]);
    }

    /**
     * Get posts by category.
     */
    public function byCategory(Category $category): JsonResponse
    {
        $posts = Post::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => "Posts in category '{$category->name}' retrieved successfully"
        ]);
    }

    /**
     * Get featured posts (posts with high quantity and reasonable price).
     */
    public function featured(): JsonResponse
    {
        $posts = Post::with(['category', 'user'])
            ->where('quantity', '>', 10)
            ->where('price', '<=', 500)
            ->orderBy('quantity', 'desc')
            ->take(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => 'Featured posts retrieved successfully'
        ]);
    }

    /**
     * Get posts with low stock.
     */
    public function lowStock(): JsonResponse
    {
        $posts = Post::with(['category', 'user'])
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 10)
            ->orderBy('quantity', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => 'Low stock posts retrieved successfully'
        ]);
    }

    /**
     * Get posts by price range.
     */
    public function byPriceRange(Request $request): JsonResponse
    {
        $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0|gte:min_price'
        ]);

        $posts = Post::with(['category', 'user'])
            ->whereBetween('price', [$request->min_price, $request->max_price])
            ->orderBy('price', 'asc')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => "Posts in price range \${$request->min_price} - \${$request->max_price} retrieved successfully"
        ]);
    }
}
