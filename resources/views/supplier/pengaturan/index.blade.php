@extends('layouts.supplier')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-gray-50 rounded-2xl shadow-lg">

    <!-- Header -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Pengaturan Akun</h1>

    <!-- Tabs -->
    <div class="relative flex gap-4 border-b border-gray-300 mb-8">
        <div id="tab-indicator" class="absolute bottom-0 h-1 rounded-full bg-orange-500 transition-all duration-300"></div>
        <button class="tab-link py-3 px-6 text-gray-600 font-medium text-sm relative hover:text-orange-500 transition" data-tab="keamanan">Keamanan</button>
        <button class="tab-link py-3 px-6 text-gray-600 font-medium text-sm relative hover:text-orange-500 transition" data-tab="notifikasi">Notifikasi</button>
    </div>

    <div class="tab-content space-y-6">

        <!-- KEAMANAN -->
        <div id="keamanan" class="tab-pane">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 hover:shadow-2xl transition">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">Ganti Password</h2>
                <form action="{{ route('supplier.password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Lama</label>
                        <input type="password" name="current_password" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-3" placeholder="Masukkan password lama">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="password" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-3" placeholder="Masukkan password baru">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-3" placeholder="Konfirmasi password baru">
                    </div>
                    <button type="submit" class="mt-4 bg-orange-500 text-white py-3 px-6 rounded-xl hover:bg-orange-600 shadow-md transition">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- NOTIFIKASI -->
        <div id="notifikasi" class="tab-pane hidden">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 hover:shadow-2xl transition">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">Pengaturan Notifikasi Supplier GrosirHub</h2>

                <div class="space-y-5">

                    <!-- Toggle Parent Contoh: Notifikasi Pesanan -->
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer toggle-parent" data-target="sub-pesanan">
                        <div>
                            <h3 class="font-medium text-gray-800">Notifikasi Pesanan</h3>
                            <p class="text-gray-500 text-sm">Update terbaru tentang pesanan masuk, dikemas, dan dikirim</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer toggle-wrapper">
                            <input type="checkbox" class="sr-only toggle-input" checked>
                            <div class="w-12 h-6 bg-gray-300 rounded-full peer transition-colors duration-300"></div>
                            <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-green-500 rounded-full shadow-md transition-transform duration-300 toggle-thumb"></span>
                        </label>
                    </div>

                    <!-- Sub-item Notifikasi Pesanan -->
                    <div id="sub-pesanan" class="ml-6 mt-2 space-y-3">
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <h4 class="font-medium text-gray-800">Status Pesanan</h4>
                                <p class="text-gray-500 text-sm">Info terbaru dari status pesanan</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer toggle-wrapper">
                                <input type="checkbox" class="sr-only toggle-input" checked>
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer transition-colors duration-300"></div>
                                <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-green-500 rounded-full shadow-md transition-transform duration-300 toggle-thumb"></span>
                            </label>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <h4 class="font-medium text-gray-800">Promosi Supplier</h4>
                                <p class="text-gray-500 text-sm">Info promo terbaru dari GrosirHub</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer toggle-wrapper">
                                <input type="checkbox" class="sr-only toggle-input">
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer transition-colors duration-300"></div>
                                <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-green-500 rounded-full shadow-md transition-transform duration-300 toggle-thumb"></span>
                            </label>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <h4 class="font-medium text-gray-800">Update Produk</h4>
                                <p class="text-gray-500 text-sm">Notifikasi stok, harga, dan produk baru</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer toggle-wrapper">
                                <input type="checkbox" class="sr-only toggle-input">
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer transition-colors duration-300"></div>
                                <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-green-500 rounded-full shadow-md transition-transform duration-300 toggle-thumb"></span>
                            </label>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <h4 class="font-medium text-gray-800">Pengingat Admin</h4>
                                <p class="text-gray-500 text-sm">Pengingat penting dari admin GrosirHub</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer toggle-wrapper">
                                <input type="checkbox" class="sr-only toggle-input" checked>
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer transition-colors duration-300"></div>
                                <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-green-500 rounded-full shadow-md transition-transform duration-300 toggle-thumb"></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>

<script>
    // Tab switching
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const indicator = document.getElementById('tab-indicator');

    tabLinks.forEach(link => {
        link.addEventListener('click', () => {
            const target = link.getAttribute('data-tab');
            tabPanes.forEach(pane => pane.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');
            const rect = link.getBoundingClientRect();
            const parentRect = link.parentElement.getBoundingClientRect();
            indicator.style.width = `${rect.width}px`;
            indicator.style.left = `${rect.left - parentRect.left}px`;
            tabLinks.forEach(l => l.classList.remove('text-orange-500', 'font-semibold'));
            link.classList.add('text-orange-500', 'font-semibold');
        });
    });
    tabLinks[0].click();

    // Toggle animation
    document.querySelectorAll('.toggle-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('.toggle-input');
        const thumb = wrapper.querySelector('.toggle-thumb');
        const track = wrapper.querySelector('div');
        function updateToggle() {
            if(input.checked){
                track.classList.remove('bg-gray-300');
                track.classList.add('bg-green-500');
                thumb.style.transform = 'translateX(24px)';
            } else {
                track.classList.remove('bg-green-500');
                track.classList.add('bg-gray-300');
                thumb.style.transform = 'translateX(0)';
            }
        }
        updateToggle();
        input.addEventListener('change', updateToggle);
    });

    // Sub-notifikasi supplier
    document.querySelectorAll('.toggle-parent').forEach(parent => {
        const targetId = parent.dataset.target;
        const sub = document.getElementById(targetId);
        const checkbox = parent.querySelector('.toggle-input');
        sub.style.display = checkbox.checked ? 'block' : 'none';
        parent.addEventListener('click', (e) => {
            if(e.target.tagName !== 'INPUT' && !e.target.closest('label')) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
            sub.style.display = checkbox.checked ? 'block' : 'none';
        });
    });
</script>
@endsection
