<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white/80 backdrop-blur p-4 rounded-xl border-l-4 border-[#005DAA] col-span-4 shadow-sm">
                <form action="{{ route('dashboard.dia') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Data</label>
                        <input type="date" name="data" value="{{ $dataEscolhida }}" class="w-full p-2 border rounded-lg font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Turno</label>
                        <select name="turno" class="w-full p-2 border rounded-lg font-bold text-sm">
                            <option value="">Todos os Turnos</option>
                            <option value="2" {{ $turnoFiltro == '2' ? 'selected' : '' }}>Manhã</option>
                            <option value="3" {{ $turnoFiltro == '3' ? 'selected' : '' }}>Tarde</option>
                            <option value="4" {{ $turnoFiltro == '4' ? 'selected' : '' }}>Noite</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Status da Sala</label>
                        <select name="status" class="w-full p-2 border rounded-lg font-bold text-sm">
                            <option value="">Todas as Salas</option>
                            <option value="ocupada" {{ ($statusFiltro ?? '') == 'ocupada' ? 'selected' : '' }}>Somente Ocupadas</option>
                            <option value="livre" {{ ($statusFiltro ?? '') == 'livre' ? 'selected' : '' }}>Somente Livres</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-[#005DAA] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#FF5900] transition text-sm h-[42px]">
                        FILTRAR
                    </button>
                </form>
            </div>

            <div class="bg-white/80 backdrop-blur p-4 rounded-xl border-l-4 border-[#FF5900] shadow-sm">
                <label class="text-[10px] font-bold text-[#FF5900] uppercase block mb-1">Busca Rápida</label>
                <input type="text" id="filtroRapido" placeholder="Sala ou instrutor..." class="w-full p-2 border rounded-lg text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-gray-300">
                <span class="text-[10px] font-bold text-gray-400 uppercase">Total de Salas</span>
                <div class="text-2xl font-black text-gray-700">{{ $totalSalas }}</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-[#FF5900]">
                <span class="text-[10px] font-bold text-[#FF5900] uppercase">Ocupadas</span>
                <div class="text-2xl font-black text-[#FF5900]">{{ $totalOcupadas }}</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-[#005DAA]">
                <span class="text-[10px] font-bold text-[#005DAA] uppercase">Livres</span>
                <div class="text-2xl font-black text-[#005DAA]">{{ $totalLivres }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
            <table class="w-full text-left" id="tabelaAgenda">
                <thead class="bg-[#005DAA] text-white text-xs uppercase font-bold">
                    <tr>
                        <th class="p-4">Sala</th>
                        <th class="p-4">Turno</th>
                        <th class="p-4">Instrutor</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($dadosTabela as $l)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-[#333]">{{ $l['sala_nome'] }}</td>
                        <td class="p-4 text-sm">{{ $l['turno'] }}</td>
                        <td class="p-4 text-sm font-medium text-gray-600">{{ $l['professor'] }}</td>
                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $l['status'] == 'Ocupada' ? 'bg-[#FF5900] text-white' : 'border-2 border-[#005DAA] text-[#005DAA]' }}">
                                {{ $l['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400 font-bold italic">Nenhuma sala encontrada com este filtro.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Filtro em tempo real (JS)
        document.getElementById('filtroRapido').addEventListener('keyup', function() {
            let v = this.value.toLowerCase();
            document.querySelectorAll('#tabelaAgenda tbody tr').forEach(tr => {
                tr.style.display = tr.innerText.toLowerCase().includes(v) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>