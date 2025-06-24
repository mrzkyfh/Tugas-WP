<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart - PaLuDaGa')]
class CartPage extends Component {

    public $cart_item= [];
    public $grand_total;

    public function mount(){
        $this->cart_item = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_item);
    }

    public function removeItem($product_id) {
        $this->cart_item = CartManagement::removeCartItem($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_item);
        $this->dispatch('update-cart-count', total_count: count($this->cart_item))->to(Navbar::class);
    }

    public function increaseQty($product_id){
        $this->cart_item = CartManagement::incrementQuantityToCartItem($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_item);
    }

    public function decreaseQty($product_id){
        $this->cart_item = CartManagement::decrementQuantityToCartItem($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_item);
    }



    public function render()
    {
        return view('livewire.cart-page');
    }
}
