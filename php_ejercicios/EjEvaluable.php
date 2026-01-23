<?php

$inventario = [
    "Informatic" => [
        [
            "name" => "Televisor Samsung 50\"",
            "price" => 450.50,
            "stock" => 10
        ],
        [
            "name" => "Auriculares Bluetooth",
            "price" => 25.99,
            "stock" => 50
        ],
        [
            "name" => "Smartphone Android",
            "price" => 299.99,
            "stock" => 15
        ]
    ],
    "Clothes" => [
        [
            "name" => "Camiseta de Algodón",
            "price" => 12.00,
            "stock" => 100
        ],
        [
            "name" => "Pantalón Vaquero",
            "price" => 35.50,
            "stock" => 40
        ]
    ],
    "food" => [
        [
            "name" => "Manzanas (kg)",
            "price" => 2.50,
            "stock" => 200
        ],
        [
            "name" => "Leche (litro)",
            "price" => 0.90,
            "stock" => 60
        ]
    ]
];


// Function agregarCarrito

$carrito = [];

function agregarCarrito($category, $product, $cantidad){

    global $carrito, $inventario;

    foreach ($inventario [$category] as $item) {
        if($item ["name"] === $product){

            // If para saber si hay stock o no
            if($item["stock"] < $cantidad){

                echo "Lo sentimos, nos hemos quedado sin stock en nuestra tienda";
                return;

            }else{
                echo "Tenemos stock, gracias por comprar en nuestra tienda";

                $item["stock"] -= $cantidad;
            }
        }

    }
}

agregarCarrito("Informatic", "Televisor Samsung 50", "2");