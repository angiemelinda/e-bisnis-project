@props(['product'])

<div class="bg-white rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer group">
    <div class="relative">
        @if($product->primaryImage)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
        @else
            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <span class="text-gray-400 text-sm">📷 No image</span>
            </div>
        @endif
        <button class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
    </div>
    <div class="p-3">
        <h4 class="font-medium text-gray-900 text-sm mb-2 line-clamp-2">{{ $product->name }}</h4>
        @if($product->category)
        <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
        @endif
        <div class="mb-2">
            <div class="text-lg font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        </div>
        <div class="text-xs text-gray-600 mb-3">
            @if($product->stock > 0)
                Stok: {{ $product->stock }} pcs
            @else
                <span class="text-red-600">Stok Habis</span>
            @endif
        </div>
        <button class="w-full bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition">+ Keranjang</button>
    </div>
</div>
