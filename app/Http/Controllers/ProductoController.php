<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Marca;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('dashboard.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('dashboard.productos.create', compact('categorias', 'marcas'));
    }

    public function store(StoreProductoRequest $request)
    {
        $uploadedFileUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            try {
                // Accede al nombre del folder desde el archivo .env
                $folder = env('CLOUDINARY_FOLDER', 'productos-farmacia');
                
                // Subir la imagen a Cloudinary
                $uploadedFileUrl = cloudinary()->upload($file->getRealPath(), [
                    'folder' => $folder
                ])->getSecurePath();
            } catch (\Exception $e) {
                session()->flash('error', 'Ocurrió un error al intentar subir la imagen');
                return redirect()->route('productos.index');
            }
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock_minimo' => $request->stock_minimo,
            'url_imagen' => $uploadedFileUrl,
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id
        ]);
        
        if (!$producto) {
            session()->flash('error', 'Ocurrió un error al intentar crear el producto');
            return redirect()->route('productos.index');
        }
        
        session()->flash('guardado', 'El producto se ha guardado correctamente');
        return redirect()->route('productos.index');
    }

    public function show(Producto $producto)
    {
        //
    }

    public function edit(string $id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('dashboard.productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    public function update(UpdateProductoRequest $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            session()->flash('error', 'El producto no existe');
            return redirect()->route('productos.index');
        }

        // Validar si la imagen fue subida
        $uploadedFileUrl = $producto->url_imagen; // Por defecto, mantener la imagen actual

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior de Cloudinary si existe
            if ($producto->url_imagen) {
                $publicId = explode('/', $producto->url_imagen);
                $publicId = end($publicId); // Obtener el public_id de la imagen en Cloudinary
                cloudinary()->destroy($publicId); // Eliminar la imagen anterior de Cloudinary
            }

            // Subir la nueva imagen
            $file = $request->file('imagen');
            try {
                // Accede al nombre del folder desde el archivo .env
                $folder = env('CLOUDINARY_FOLDER', 'productos-farmacia');
                
                // Subir la imagen a Cloudinary
                $uploadedFileUrl = cloudinary()->upload($file->getRealPath(), [
                    'folder' => $folder
                ])->getSecurePath();
            } catch (\Exception $e) {
                session()->flash('error', 'Ocurrió un error al intentar subir la imagen');
                return redirect()->route('productos.index');
            }
        }

        // Actualizar el producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock_minimo' => $request->stock_minimo,
            'url_imagen' => $uploadedFileUrl,
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id
        ]);
        
        session()->flash('actualizado', 'El producto se ha actualizado correctamente');
        return redirect()->route('productos.index');
    }

    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            session()->flash('error', 'El producto no existe');
            return redirect()->route('productos.index');
        }

        // Eliminar la imagen de Cloudinary si existe
        if ($producto->url_imagen) {
            $publicId = explode('/', $producto->url_imagen);
            $publicId = end($publicId); // Obtener el public_id de la imagen en Cloudinary
            cloudinary()->destroy($publicId); // Eliminar la imagen de Cloudinary
        }

        $producto->delete();
        session()->flash('eliminado', 'El producto se ha eliminado correctamente');
        return redirect()->route('productos.index');
    }
}
