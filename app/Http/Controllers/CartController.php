<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getSessionId()
    {
        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', uniqid());
        }
        return Session::get('cart_session_id');
    }

    public function index()
    {
        $cartItems = CartItem::where('session_id', $this->getSessionId())
            ->with('product')
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $sessionId = $this->getSessionId();
        
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Stock insuficiente');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock
        ]);

        if ($cartItem->session_id !== $this->getSessionId()) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Carrito actualizado');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->session_id !== $this->getSessionId()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function checkout()
    {
        $cartItems = CartItem::where('session_id', $this->getSessionId())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'El carrito está vacío');
        }

        $total = $cartItems->sum('subtotal');

        return view('checkout', compact('cartItems', 'total'));
    }

    public function processOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500'
        ]);

        $cartItems = CartItem::where('session_id', $this->getSessionId())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'El carrito está vacío');
        }

        $total = $cartItems->sum('subtotal');

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total' => $total
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);

            // Reducir stock
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Limpiar carrito
        CartItem::where('session_id', $this->getSessionId())->delete();
        Session::forget('cart_session_id');

        return redirect()->route('order.success', $order)->with('success', 'Pedido realizado exitosamente');
    }

    public function orderSuccess(Order $order)
    {
        return view('order-success', compact('order'));
    }
}