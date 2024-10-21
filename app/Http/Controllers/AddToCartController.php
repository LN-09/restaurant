<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class AddToCartController extends Controller
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $food->name,
                "quantity" => 1,
                "price" => $food->price,
                "img" => $food->img
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Món ăn đã được thêm vào giỏ hàng!');
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $cart = session()->get('cart');

        if (isset($cart[$id])) {

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Số lượng món ăn đã được cập nhật!');
        }

        return redirect()->back()->with('error', 'Món ăn không tồn tại trong giỏ hàng!');
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $cart = session()->get('cart');

        if (isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Món ăn đã được xóa khỏi giỏ hàng!');
        }

        return redirect()->back()->with('error', 'Món ăn không tồn tại trong giỏ hàng!');
    }
}
