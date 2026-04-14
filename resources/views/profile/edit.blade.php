<x-app-layout>
    <div class="py-12 max-w-xl mx-auto px-4">
        <div class="bg-white/90 backdrop-blur-md p-8 rounded-xl shadow-lg border-t-4 border-[#FF5900]">
            <h2 class="text-2xl font-bold text-[#005DAA] mb-6">⚙️ Minha Segurança</h2>
            
            @if (session('status') === 'password-updated')
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 font-bold text-sm">Senha alterada com sucesso! ✅</div>
            @endif

            <form method="post" action="{{ route('password.update.custom') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block font-bold text-[#005DAA] text-xs uppercase">Senha Atual</label>
                    <input type="password" name="current_password" class="w-full p-3 border rounded-lg mt-1" required>
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-bold text-[#005DAA] text-xs uppercase">Nova Senha</label>
                    <input type="password" name="password" class="w-full p-3 border rounded-lg mt-1" required>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-bold text-[#005DAA] text-xs uppercase">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation" class="w-full p-3 border rounded-lg mt-1" required>
                </div>
                <button type="submit" class="w-full bg-[#005DAA] text-white p-3 rounded-lg font-bold hover:bg-[#FF5900] transition">ATUALIZAR SENHA</button>
            </form>
        </div>
    </div>
</x-app-layout>