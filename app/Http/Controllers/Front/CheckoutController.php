<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException(trans('Cart is empty'));
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:20'],
            'addr.billing.last_name' => ['required', 'string', 'max:20'],
            'addr.billing.email' => ['nullable', 'email', 'max:50'],
            'addr.billing.phone_number' => ['required', 'min:9', 'numeric'],
            'addr.billing.city' => ['required', 'string', 'max:20'],
            'addr.shipping.first_name' => ['required', 'string', 'max:20'],
            'addr.shipping.last_name' => ['required', 'string', 'max:20'],
            'addr.shipping.email' => ['nullable', 'email', 'max:50'],
            'addr.shipping.phone_number' => ['required', 'min:9', 'numeric'],
            'addr.shipping.city' => ['required', 'string', 'max:20'],
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {

                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'stripe',
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            DB::commit();

            //event('order.created', $order, Auth::user());
            event(new OrderCreated($order));

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('orders.payments.create', $order->id);
    }
}