<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // 1 - 10
            ['Leche Entera UHT 1L', 'Leche entera ultrapasteurizada ideal para el consumo diario.', 10, 7.50, 1, 11],
            ['Yogurt Bebible Sabor Frutilla 1L', 'Yogurt líquido con sabor a frutilla, suave y nutritivo.', 20, 12.00, 3, 12],
            ['Queso Menonita 1kg', 'Queso semiduro de origen menonita, sabor suave.', 5, 45.00, 2, 14],
            ['Mantequilla con Sal 200g', 'Mantequilla natural con sal.', 15, 18.00, 4, 12],
            ['Dulce de Leche 250g', 'Dulce de leche tradicional, ideal para postres.', 10, 11.40, 5, 11],
            ['Leche Descremada UHT 1L', 'Leche descremada ultrapasteurizada, baja en grasa.', 10, 7.50, 1, 11],
            ['Yogurt Griego Natural 1L', 'Yogurt griego cremoso y natural.', 20, 19.00, 3, 12],
            ['Queso Cheddar 500g', 'Queso cheddar de sabor intenso, ideal para sándwiches.', 5, 40.00, 2, 11],
            ['Mantequilla sin Sal 200g', 'Mantequilla sin sal para repostería.', 15, 18.00, 4, 12],
            ['Crema de Leche 500ml', 'Crema de leche fresca para recetas.', 10, 14.50, 6, 12],

            // 11 - 20
            ['Leche Condensada 397g', 'Leche condensada azucarada, para postres.', 5, 10.00, 1, 11],
            ['Yogurt Bebible Sabor Durazno 1L', 'Yogurt con el fresco sabor del durazno.', 20, 12.00, 3, 12],
            ['Queso Parmesano Rallado 100g', 'Queso parmesano rallado, ideal para pastas.', 5, 25.00, 2, 11],
            ['Leche en Polvo Entera 760g', 'Leche en polvo de fácil disolución.', 5, 55.00, 1, 11],
            ['Yogurt Bebible Light Sabor Vainilla 1L', 'Yogurt light con sabor a vainilla.', 20, 13.00, 3, 12],
            ['Queso Gouda 1kg', 'Queso de textura cremosa, ideal para tablas.', 5, 50.00, 2, 14],
            ['Mantequilla con Sal 4kg', 'Mantequilla en presentación industrial.', 5, 220.00, 4, 12],
            ['Dulce de Leche Repostero 5kg', 'Dulce de leche espeso para repostería.', 5, 130.00, 5, 12],
            ['Leche Deslactosada UHT 1L', 'Leche sin lactosa, ideal para intolerantes.', 10, 8.00, 1, 11],
            ['Yogurt Bebible Sabor Piña 1L', 'Yogurt con sabor a piña, tropical y refrescante.', 20, 12.00, 3, 12],

            // 21 - 30
            ['Queso Edam 1kg', 'Queso semiduro de origen holandés.', 5, 55.00, 2, 14],
            ['Mantequilla sin Sal 4kg', 'Mantequilla sin sal en formato industrial.', 5, 220.00, 4, 12],
            ['Crema Vegetal para Repostería 1L', 'Crema vegetal para repostería.', 10, 20.00, 6, 12],
            ['Leche Evaporada 400g', 'Leche evaporada, ideal para recetas.', 5, 8.00, 1, 11],
            ['Yogurt Griego con Miel 1L', 'Yogurt griego con el dulzor de la miel.', 20, 20.00, 3, 12],
            ['Leche Entera UHT 500ml', 'Leche entera en presentación reducida.', 10, 4.00, 1, 11],
            ['Yogurt Bebible Sabor Mango 1L', 'Yogurt con el exótico sabor del mango.', 20, 12.50, 3, 12],
            ['Queso Fresco 500g', 'Queso fresco ideal para ensaladas.', 5, 22.00, 2, 13],
            ['Mantequilla Premium 250g', 'Mantequilla de alta calidad.', 15, 20.00, 4, 12],
            ['Dulce de Leche Artesanal 300g', 'Dulce de leche artesanal, receta tradicional.', 10, 15.00, 5, 14],

            // 31 - 40
            ['Leche Descremada UHT 500ml', 'Leche descremada en formato reducido.', 10, 4.00, 1, 11],
            ['Yogurt Natural 500ml', 'Yogurt natural sin aditivos.', 20, 10.00, 3, 12],
            ['Queso Mozzarella 500g', 'Queso mozzarella, ideal para pizzas.', 5, 35.00, 2, 11],
            ['Mantequilla con Sal 100g', 'Pequeña presentación de mantequilla con sal.', 15, 10.00, 4, 12],
            ['Crema de Leche Ligera 500ml', 'Crema de leche ligera para bebidas.', 10, 8.00, 6, 12],
            ['Leche Condensada Light 397g', 'Versión light de leche condensada.', 5, 11.00, 1, 11],
            ['Yogurt Bebible Sabor Coco 1L', 'Yogurt con sabor exótico a coco.', 20, 13.00, 3, 12],
            ['Queso Provolone 500g', 'Queso provolone semiduro, ideal para fundir.', 5, 38.00, 2, 11],
            ['Mantequilla sin Sal Premium 250g', 'Mantequilla premium sin sal.', 15, 20.00, 4, 12],
            ['Crema de Leche Ultra 1L', 'Crema de leche densa para recetas gourmet.', 10, 16.00, 6, 12],

            // 41 - 50
            ['Leche en Polvo Descremada 760g', 'Leche en polvo baja en grasa.', 5, 60.00, 1, 11],
            ['Yogurt Griego con Frutas 1L', 'Yogurt griego con trozos de fruta.', 20, 21.00, 3, 12],
            ['Queso Feta 500g', 'Queso feta cremoso, ideal para ensaladas.', 5, 30.00, 2, 14],
            ['Mantequilla Clarificada 200g', 'Mantequilla clarificada para usos gourmet.', 15, 19.00, 4, 12],
            ['Dulce de Leche Premium 250g', 'Dulce de leche con textura cremosa.', 10, 12.00, 5, 11],
            ['Leche Entera UHT 2L', 'Leche entera en presentación familiar.', 10, 15.00, 1, 11],
            ['Yogurt Bebible Sabor Naranja 1L', 'Yogurt con vibrante sabor a naranja.', 20, 12.00, 3, 12],
            ['Queso Edam en Rebanadas 250g', 'Queso Edam en rebanadas para sándwiches.', 5, 28.00, 2, 14],
            ['Mantequilla con Sal Orgánica 200g', 'Mantequilla orgánica con sal.', 15, 22.00, 4, 12],
            ['Crema de Leche Orgánica 500ml', 'Crema orgánica para recetas saludables.', 10, 15.00, 6, 12],

            // 51 - 60
            ['Leche Deslactosada UHT 500ml', 'Leche deslactosada en presentación reducida.', 10, 4.50, 1, 11],
            ['Yogurt Bebible Sabor Limón 1L', 'Yogurt refrescante con toque cítrico.', 20, 12.00, 3, 12],
            ['Queso Cheddar en Lonchas 250g', 'Queso cheddar en lonchas para sándwiches.', 5, 30.00, 2, 11],
            ['Mantequilla sin Sal Orgánica 200g', 'Mantequilla orgánica sin sal.', 15, 22.00, 4, 12],
            ['Crema Batida 250ml', 'Crema ligera batida para decorar postres.', 10, 12.50, 6, 12],
            ['Leche Evaporada 800g', 'Leche evaporada concentrada para recetas.', 5, 14.00, 1, 11],
            ['Yogurt Griego Sabor Miel y Nuez 1L', 'Yogurt griego con miel y nueces.', 20, 22.00, 3, 12],
            ['Queso Manchego 500g', 'Queso manchego tradicional para tablas.', 5, 40.00, 2, 14],
            ['Mantequilla con Sal Extra 200g', 'Mantequilla con sal extra para realzar sabores.', 15, 19.00, 4, 12],
            ['Dulce de Leche Casero 250g', 'Dulce de leche casero, receta tradicional.', 10, 13.00, 5, 14],

            // 61 - 70
            ['Leche Entera UHT 1.5L', 'Leche entera en formato intermedio.', 10, 11.00, 1, 11],
            ['Yogurt Bebible Sabor Fresa 1L', 'Yogurt con el clásico sabor de fresa.', 20, 12.00, 3, 12],
            ['Queso Port Salut 500g', 'Queso suave y cremoso para derretir.', 5, 37.00, 2, 11],
            ['Mantequilla sin Sal Light 200g', 'Mantequilla ligera sin sal.', 15, 18.00, 4, 12],
            ['Crema de Leche para Café 250ml', 'Crema de leche ideal para café.', 10, 9.00, 6, 12],
            ['Leche en Polvo Entera 500g', 'Leche en polvo para bebidas y recetas.', 5, 40.00, 1, 11],
            ['Yogurt Bebible Sabor Melocotón 1L', 'Yogurt con el dulce sabor del melocotón.', 20, 12.50, 3, 12],
            ['Queso Cottage 500g', 'Queso cottage fresco, ideal para dietas.', 5, 25.00, 2, 13],
            ['Mantequilla Tradicional 100g', 'Mantequilla clásica para uso cotidiano.', 15, 8.00, 4, 12],
            ['Dulce de Leche Tradicional 200g', 'Dulce de leche tradicional boliviano.', 10, 9.50, 5, 11],

            // 71 - 80
            ['Leche Descremada UHT 2L', 'Leche descremada en presentación familiar.', 10, 14.00, 1, 11],
            ['Yogurt Natural Sin Azúcar 500ml', 'Yogurt natural sin azúcares añadidos.', 20, 10.50, 3, 12],
            ['Queso Azul 250g', 'Queso de sabor intenso y característico.', 5, 35.00, 2, 14],
            ['Mantequilla Clarificada Premium 200g', 'Mantequilla clarificada premium para usos gourmet.', 15, 21.00, 4, 12],
            ['Crema de Leche Batida 500ml', 'Crema de leche batida para postres.', 10, 17.00, 6, 12],
            ['Leche Condensada Tradicional 397g', 'Leche condensada clásica para recetas.', 5, 10.00, 1, 11],
            ['Yogurt Bebible Sabor Maracuyá 1L', 'Yogurt con el ácido y dulce sabor del maracuyá.', 20, 12.50, 3, 12],
            ['Queso Parmesano en Cuadro 200g', 'Queso parmesano en cuadro para rallar.', 5, 20.00, 2, 11],
            ['Mantequilla con Sal en Barra 250g', 'Mantequilla en barra, práctica para uso diario.', 15, 20.00, 4, 12],
            ['Crema para Postres 1L', 'Crema de leche ideal para postres cremosos.', 10, 16.50, 6, 12],

            // 81 - 90
            ['Leche Evaporada Light 400g', 'Versión light de la leche evaporada.', 5, 9.00, 1, 11],
            ['Yogurt Griego Sabor Vainilla 1L', 'Yogurt griego con sabor a vainilla.', 20, 21.00, 3, 12],
            ['Queso Fresco en Bloque 1kg', 'Queso fresco en bloque para rallar o cortar.', 5, 40.00, 2, 13],
            ['Mantequilla Sin Sal en Barra 250g', 'Mantequilla sin sal en barra para uso diario.', 15, 20.00, 4, 12],
            ['Dulce de Leche para Repostería 500g', 'Dulce de leche especial para repostería.', 10, 22.00, 5, 11],
            ['Leche Entera UHT 750ml', 'Leche entera en presentación compacta.', 10, 6.00, 1, 11],
            ['Yogurt Bebible Sabor Kiwi 1L', 'Yogurt con el exótico sabor del kiwi.', 20, 13.00, 3, 12],
            ['Queso Cheddar en Bloque 1kg', 'Queso cheddar en bloque para rallar o cortar.', 5, 75.00, 2, 11],
            ['Mantequilla con Sal en Tarro 200g', 'Mantequilla en tarro para uso profesional.', 15, 18.50, 4, 12],
            ['Crema de Leche Extra 500ml', 'Crema de leche de alta calidad para recetas gourmet.', 10, 18.00, 6, 12],

            // 91 - 100
            ['Leche Deslactosada UHT 2L', 'Leche deslactosada en presentación familiar.', 10, 15.00, 1, 11],
            ['Yogurt Bebible Sabor Arándano 1L', 'Yogurt con el vibrante sabor de arándanos.', 20, 12.50, 3, 12],
            ['Queso Gouda en Lonchas 250g', 'Lonchas de queso Gouda para sándwiches.', 5, 32.00, 2, 14],
            ['Mantequilla sin Sal en Tarro 200g', 'Mantequilla sin sal en tarro para usos versátiles.', 15, 18.50, 4, 12],
            ['Crema para Repostería Orgánica 1L', 'Crema orgánica para postres y repostería saludable.', 10, 20.00, 6, 12],
            ['Leche en Polvo Integral 760g', 'Leche en polvo integral, con nutrientes intactos.', 5, 65.00, 1, 11],
            ['Yogurt Griego con Miel y Almendra 1L', 'Yogurt griego con miel y almendras.', 20, 23.00, 3, 12],
            ['Queso Mozzarella en Bolas 500g', 'Queso mozzarella en bolas, ideal para ensaladas.', 5, 36.00, 2, 11],
            ['Mantequilla Premium Orgánica 250g', 'Mantequilla orgánica premium para preparaciones especiales.', 15, 22.00, 4, 12],
            ['Dulce de Leche Ultra Cremoso 250g', 'Dulce de leche ultra cremosa, para deleitar paladares.', 10, 13.00, 5, 11],
        ];

        foreach ($productos as $producto) {
            Producto::create([
                'nombre'        => $producto[0],
                'descripcion'   => $producto[1],
                'stock_minimo'  => $producto[2],
                'precio_venta'  => $producto[3],
                'categoria_id'  => $producto[4],
                'marca_id'      => $producto[5],
            ]);
        }
    }
}
