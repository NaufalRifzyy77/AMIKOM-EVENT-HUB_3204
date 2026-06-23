@extends('layouts.app')

@section('title', $event->title)

@section('content')
<main class="max-w-6xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">[Kembali ke Event]</a>
        <h1 class="text-4xl font-bold text-slate-900 mt-4">Checkout</h1>
        <p class="text-slate-600 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <!-- Error Message -->
    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
        {{ session('error') }}
    </div>
    @endif

    <!-- Checkout Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Order Summary -->
        <div class="lg:col-span-1">
            <div class="sticky top-24">
                <!-- Order Section -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Pesanan Anda</h3>
                    
                    <!-- Event Image -->
                    <img src="{{ ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/' . $event->poster_path)
                        : 'https://placehold.co/200x200' }}" alt="{{ $event->title }}"
                        class="w-full rounded-lg object-cover mb-4">
                    
                    <!-- Event Details -->
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-slate-900">{{ $event->title }}</h4>
                        <p class="text-sm text-slate-600 mt-1">{{ $event->date->format('d M Y') }} • {{ $event->location }}</p>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="border-t border-slate-200 pt-4 mb-4">
                        <div class="flex justify-between mb-3">
                            <span class="text-slate-600">1 x Tiket</span>
                            <span class="font-semibold text-slate-900">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Harga Tiket</span>
                            <span class="font-semibold text-slate-900">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Biaya Layanan</span>
                            <span class="font-semibold text-slate-900">Rp 5.000</span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex justify-between">
                            <span class="font-bold text-slate-900">Total Bayar</span>
                            <span class="font-bold text-lg text-indigo-600">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <h3 class="text-xl font-bold text-slate-900 mb-6">📦 Data Pemesan (Tanpa Login)</h3>

                <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="customer_name" class="block text-sm font-semibold text-slate-900 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" id="customer_name" name="customer_name"
                            value="{{ old('customer_name') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('customer_name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('customer_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="customer_email" class="block text-sm font-semibold text-slate-900 mb-2">
                            Email Aktif
                        </label>
                        <input type="email" id="customer_email" name="customer_email"
                            value="{{ old('customer_email') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('customer_email') border-red-500 @enderror"
                            placeholder="email@example.com">
                        <p class="text-xs text-slate-500 mt-1">*E-Ticket akan dikirim ke email ini</p>
                        @error('customer_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. WhatsApp -->
                    <div>
                        <label for="customer_phone" class="block text-sm font-semibold text-slate-900 mb-2">
                            No. WhatsApp
                        </label>
                        <input type="tel" id="customer_phone" name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('customer_phone') border-red-500 @enderror"
                            placeholder="6281234567890">
                        @error('customer_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                            Lanjut Pembayaran
                        </button>
                        <p class="text-xs text-slate-500 text-center mt-3">
                            Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
