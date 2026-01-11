@extends('dropshipper.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dropshipper.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('dropshipper.catalog') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary md:ml-2">Katalog Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Detail Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="md:flex">
            <!-- Product Images -->
            <div class="md:w-1/2 p-6">
                <div class="relative">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-auto rounded-lg object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    @if($product->discount > 0)
                        <div class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                            Diskon {{ $product->discount }}%
                        </div>
                    @endif
                </div>
                
                @if($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-2">
                        @foreach($product->images as $image)
                            <div class="border rounded-lg overflow-hidden cursor-pointer hover:border-primary transition">
                                <img src="{{ asset('storage/' . $image->path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-20 object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-6 border-l border-gray-100">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                <div class="flex items-center mb-4">
                    <div class="flex items-center text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5" fill="{{ $i <= 4 ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <span class="text-gray-600 text-sm ml-2">(4.5)</span>
                    </div>
                    <span class="mx-2 text-gray-300">|</span>
                    <span class="text-sm text-gray-600">Terjual {{ $product->sold ?? 0 }} pcs</span>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    @if($product->discount > 0)
                        <div class="text-sm text-gray-500 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-primary">Rp {{ number_format($product->price - ($product->price * $product->discount / 100), 0, ',', '.') }}</span>
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded">Hemat {{ $product->discount }}%</span>
                        </div>
                    @else
                        <div class="text-2xl font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Deskripsi Produk</h3>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($product->description ?? 'Tidak ada deskripsi produk')) !!}
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center mb-4">
                        <div class="w-24 text-sm text-gray-500">Kategori</div>
                        <div class="text-gray-900">{{ $product->category->name ?? '-' }}</div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="w-24 text-sm text-gray-500">Stok</div>
                        <div class="text-gray-900">{{ $product->stock }} pcs</div>
                    </div>
                    <div class="flex items-center mb-6">
                        <div class="w-24 text-sm text-gray-500">Min. Order</div>
                        <div class="text-gray-900">{{ $product->min_order ?? 1 }} pcs</div>
                    </div>

                    <form action="{{ route('dropshipper.orders.cart.add') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border rounded-lg overflow-hidden">
                                <button type="button" class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 transition" onclick="decreaseQuantity()">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="{{ $product->min_order ?? 1 }}" min="{{ $product->min_order ?? 1 }}" max="{{ $product->stock }}" class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 transition" onclick="increaseQuantity({{ $product->stock }})">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-lg font-medium transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Masukkan Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <a href="{{ route('dropshipper.product.show', $relatedProduct->id) }}" class="block">
                            <div class="relative">
                                @if($relatedProduct->primaryImage)
                                    <img src="{{ asset('storage/' . $relatedProduct->primaryImage->path) }}" 
                                         alt="{{ $relatedProduct->name }}" 
                                         class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                @if($relatedProduct->discount > 0)
                                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        -{{ $relatedProduct->discount }}%
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex items-center">
                                    @if($relatedProduct->discount > 0)
                                        <span class="text-xs text-gray-400 line-through mr-1">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                        <span class="text-sm font-bold text-primary">Rp {{ number_format($relatedProduct->price - ($relatedProduct->price * $relatedProduct->discount / 100), 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-bold text-primary">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function increaseQuantity(max) {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity < max) {
            quantityInput.value = quantity + 1;
        }
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        const min = parseInt(quantityInput.min);
        if (quantity > min) {
            quantityInput.value = quantity - 1;
        }
    }
</script>
@endpush
@endsection