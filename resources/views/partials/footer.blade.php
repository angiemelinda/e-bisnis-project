@if(auth()->check() && (request()->routeIs('superadmin.*') || request()->routeIs('adminproduk.*') || request()->routeIs('adminpengguna.*') || request()->routeIs('admintransaksi.*') || request()->routeIs('adminlaporan.*') || request()->routeIs('supplier.*') || request()->routeIs('dropshipper.*')))
    <footer class="bg-white border-t border-gray-200 px-6 py-4 mt-auto">
        <div class="text-center text-sm text-gray-500">
            <p>© {{ date('Y') }} GrosirHub. {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'Admin')) }} Panel.</p>
        </div>
    </footer>
@elseif(!auth()->check())
    <footer class="bg-dark text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg">
                            <i class="fas fa-box-open text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold">Grosir<span class="text-primary">Hub</span></span>
                    </div>
                    <p class="text-gray-400">Platform B2B terpercaya untuk menghubungkan supplier dan dropshipper di seluruh Indonesia.</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-lg">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-primary transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-primary transition">Harga</a></li>
                        <li><a href="#" class="hover:text-primary transition">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-primary transition">API</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-lg">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-primary transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition">Blog</a></li>
                        <li><a href="#" class="hover:text-primary transition">Karir</a></li>
                        <li><a href="{{ route('kontak') }}" class="hover:text-primary transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-lg">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 p-3 rounded-lg hover:bg-primary transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-800 p-3 rounded-lg hover:bg-primary transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-gray-800 p-3 rounded-lg hover:bg-primary transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-gray-800 p-3 rounded-lg hover:bg-primary transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} GrosirHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
@endif
