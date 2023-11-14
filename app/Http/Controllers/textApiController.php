<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class textApiController extends Controller
{
    //
    public function getData()
    {
        $filePath = 'data.txt';
        $fileContent = Storage::get($filePath);
        $lines = explode(PHP_EOL, $fileContent);

        $products = [];

        foreach ($lines as $line) {

            $productData = explode(',', $line);
            if(count($productData) > 1){
                $product = [
                    'name' => $productData[0],
                    'quantity' => (int) $productData[1],
                    'price' => (float) $productData[2],
                    'image_path' => $productData[3],
                ];
                $products[] = $product;
            }


        }

        return response()->json(['products' => $products]);
    }

    public function getProductById($id){
        $data = $this->getData();
        $products = $data->getOriginalContent()['products'];


        if (isset($products[$id])) {
            $selectedProduct = $products[$id];
            return response()->json( $selectedProduct);
        } else {
            return response()->json(['error' => 'Index not found'], 404);
        }
    }
}
