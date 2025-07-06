<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getSessionId()
    {
        if (!Auth::check()) {
            return 'guest_' . session()->getId();
        }

        // Crear un session_id único para cada usuario autenticado
        $userSessionKey = 'cart_session_user_' . Auth::user()->id;
        
        if (!Session::has($userSessionKey)) {
            Session::put($userSessionKey, 'user_' . Auth::user()->id . '_' . uniqid());
        }
        
        return Session::get($userSessionKey);
    }

    public function index()
    {
        // Si el usuario no está autenticado, mostrar vista sin carrito
        if (!Auth::check()) {
            return view('cart', [
                'cartItems' => collect([]),
                'total' => 0
            ]);
        }

        // Usuario autenticado: mostrar su carrito específico
        $cartItems = CartItem::where('session_id', $this->getSessionId())
            ->with('product')
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        // Verificar autenticación PRIMERO
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Debes iniciar sesión para agregar productos al carrito.');
        }

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

        return back()->with('success', 'Producto agregado al carrito')
                    ->with('product_added', $product->id)
                    ->with('user_id', Auth::user()->id);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Debes iniciar sesión para modificar el carrito.');
        }

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
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Debes iniciar sesión para modificar el carrito.');
        }

        if ($cartItem->session_id !== $this->getSessionId()) {
            abort(403);
        }

        $productId = $cartItem->product_id;
        $cartItem->delete();

        return back()->with('success', 'Producto eliminado del carrito')
                    ->with('product_removed', $productId)
                    ->with('user_id', Auth::user()->id);
    }

    public function checkProduct($productId)
    {
        if (!Auth::check()) {
            return response()->json(['inCart' => false]);
        }

        $sessionId = $this->getSessionId();
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            return response()->json([
                'inCart' => true,
                'quantity' => $cartItem->quantity
            ]);
        }

        return response()->json(['inCart' => false]);
    }

    public function checkout()
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Debes iniciar sesión para proceder al checkout.');
        }

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
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Debes iniciar sesión para realizar un pedido.');
        }

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
            'total' => $total,
            'user_id' => Auth::user()->id // Asociar la orden al usuario
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

        // Limpiar carrito del usuario específico
        CartItem::where('session_id', $this->getSessionId())->delete();

        return redirect()->route('order.success', $order)->with('success', 'Pedido realizado exitosamente');
    }

    public function orderSuccess(Order $order)
    {
        return view('order-success', compact('order'));
    }
}