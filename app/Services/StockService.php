<?php 
namespace App\Services;
use App\Models\Product;
class StockService{
    protected Product $product;
    public $required_quantity = null;

    public function __construct(Product $product){
        // set product
        $this->product = $product;
    }

    public function stock_availaibility(): bool 
    {
        // check if product have quantity
        if($this->product->quantity == '0'):
           return false;
        endif;
        
        // check if required quantity is allow in product
        if( ($this->required_quantity != null) && ( $this->required_quantity > ($this->product->quantity - intval($this->product->hold_stock)) ) ):
            return false;
        endif;

        return true;
    }

    public function decrease_stock(){
        // decrease stock
        $this->product->decrement('quantity', $this->required_quantity);
    }

    public function increase_stock(){
        // decrease stock
        $this->product->increment('quantity', $this->required_quantity);
    }
}