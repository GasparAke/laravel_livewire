<?php

namespace App\Http\Livewire;


use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Denomination;
use App\Models\SaleDetails;
use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use App\Traits\Utils;
use App\Models\Sale;
use App\Models\User;
use DB;
use App\Traits\CartTrait;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class Pos extends Component
{
    use CartTrait;
    public $total, $itemsQuantity, $efectivo, $change;
    private $pagination = 5;

    public function render()
    {
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name')
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'scan-components',
        'ACash' => 'ACash',
        'scan-code-byid' => 'ScanCodeById'

    ];

    public function ScanCodeById(Product $product)
    {
        $this->IncreaseQuantity($product);
    }

    public function ScanCode($barcode, $cant = 1)
    {
        $this->ScanearCode($barcode, $cant);
    }

    public function increaseQty(Product $product, $cant = 1)
    {
        $this->IncreaseQuantity($product, $cant);
    }

    public function updateQty(Product $product, $cant = 1)
    {
        if($cant <=0)
            $this->removeItem($product->id);
        else
            $this->updateQuantity($product, $cant);
    }

    public function decreaseQty($productId)
    {
        $this->decreaseQuantity($productId);
    }

    public function AddCash($value)
    {
        if($value > 0)
            $this->efectivo += $value;
        else
        $this->efectivo += $this->total;
        
    }

    public function clearCart()
    {
        $this->trashCart();
    }

    public function saveSale()
    {
        if ($this->total <=0) {
            $this->emit('sale-error', 'AGREGAR PRODUCTOS A LA VENTA');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'INGRESA EL EFECTIVO');
            return;
        }
        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
            return;
        }

        DB::beginTransaction();

        try {

             $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id
            ]); 

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    //Update a stock
                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                    $nombreImpresora = "POS-58";
// $connector = new WindowsPrintConnector($nombreImpresora);
// $impresora = new Printer($connector);
// $impresora->setJustification(Printer::JUSTIFY_CENTER);
// $impresora->setTextSize(2, 2);
// $impresora->text("Imprimiendo\n");
// $impresora->text("ticket\n");
// $impresora->text("desde\n");
// $impresora->text("Laravel\n");
// $impresora->setTextSize(1, 1);
// $impresora->text("https://parzibyte.me");
// $impresora->feed(5);
// $impresora->close();    
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo =0;
            $this->change =0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'VENTA REGISTRADA CON EXITO, REVISA TU TICKET DE VENTA');
            // $this->emit('print-ticket', $sale->id);

        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
        
    }
  

    // public function printTicket($sale)
    // {
    //    return Redirect::to("print//$sale->id");
    // }

   
}
