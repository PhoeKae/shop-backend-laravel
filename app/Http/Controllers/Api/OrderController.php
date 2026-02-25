<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.post_id' => 'required|exists:posts,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $postIds = array_column($validated['items'], 'post_id');
        $posts = Post::whereIn('id', $postIds)->get()->keyBy('id');

        foreach ($validated['items'] as $item) {
            if (!$posts->has($item['post_id'])) {
                return response()->json([
                    'message' => 'Product not found',
                    'errors' => ['items' => ['Product with ID ' . $item['post_id'] . ' does not exist.']],
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($validated, $posts) {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $post = $posts->get($item['post_id']);

                $unitPrice = round((float) $post->price, 2);
                $subtotal = round($unitPrice * $item['quantity'], 2);
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'post_id' => $item['post_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => auth()->id() ?? null,
                'total_amount' => round($totalAmount, 2),
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            return $order->load('orderItems.post');
        });

        $items = $order->orderItems->map(function ($orderItem) {
            return [
                'post_id' => $orderItem->post_id,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
                'subtotal' => $orderItem->subtotal,
                'post' => $orderItem->post ? [
                    'id' => $orderItem->post->id,
                    'title' => $orderItem->post->title,
                    'price' => $orderItem->post->price,
                ] : null,
            ];
        });

        return response()->json([
            'message' => 'Order created successfully',
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'total_amount' => $order->total_amount,
                'created_at' => $order->created_at->toIso8601String(),
                'items' => $items,
            ],
        ], 201);
    }
}
