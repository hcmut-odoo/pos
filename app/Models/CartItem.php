<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItem extends Model
{
    protected $fillable = ['product_id', 'quantity', 'size', 'note', 'cart_id'];

    public function __construct($product_id, $cart_id, $size, $note, $quantity)
    {
        $this->product_id = $product_id;
        $this->cart_id = $cart_id;
        $this->size = $size;
        $this->note = $note;
        $this->quantity = $quantity;
    }

    public function create()
    {
        $this->save();
    }

    public static function get($id)
    {
        return DB::table('cart_items')->where('id', $id)->get();
    }

    public static function remove($id)
    {
        return DB::table('cart_items')->where('id', $id)->delete();
    }

    public function edit($items)
    {
        return CartItem::where('id', $items['id'])
                    ->update([
                        'product_id' => $items['product_id'],
                        'quantity' => $items['quantity'],
                        'size' => $items['size'],
                        'note' => $items['note']
                    ]);
    }
}
