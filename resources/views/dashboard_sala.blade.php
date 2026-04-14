<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <div class="bg-white/90 backdrop-blur p-6 rounded-xl shadow-sm border-l-4 border-[#FF5900] mb-6">
            <form action="{{ route('dashboard.sala') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                <div><label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Sala</label>
                    <select name="sala_id" class="w-full p-2 border rounded font-bold text-sm">
                        @foreach($salas as $s) <option value="{{ $s->id }}" {{ $salaId == $s->id ? 'selected' : '' }}>{{ $s->nome }}</option> @endforeach
                    </select>
                </div>
                <div><label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Turno</label>
                    <select name="turno" class="w-full p-2 border rounded font-bold text-sm">
                        <option value="">Todos</option>
                        <option value="2" {{ $turnoFiltro == '2' ? 'selected' : '' }}>Manhã</option>
                        <option value="3" {{ $turnoFiltro == '3' ? 'selected' : '' }}>Tarde</option>
                        <option value="4" {{ $turnoFiltro == '4' ? 'selected' : '' }}>Noite</option>
                    </select>
                </div>
                <div><label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Modalidade</label>
                    <select name="modalidade" class="w-full p-2 border rounded font-bold text-sm">
                        <option value="">Todas</option>
                        @foreach($nomesModalidades as $id => $nome) <option value="{{ $id }}" {{ $modalidadeFiltro == $id ? 'selected' : '' }}>{{ $nome }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Período</label>
                    <select name="periodo" class="w-full p-2 border rounded font-bold text-sm">
                        <option value="dia" {{ $periodo == 'dia' ? 'selected' : '' }}>Dia</option>
                        <option value="semana" {{ $periodo == 'semana' ? 'selected' : '' }}>Semana</option>
                        <option value="mes" {{ $periodo == 'mes' ? 'selected' : '' }}>Mês</option>
                    </select>
                </div>
                <div><label class="text-[10px] font-bold text-[#005DAA] uppercase block mb-1">Data</label>
                    <input type="date" name="data_base" value="{{ $dataBase }}" class="w-full p-2 border rounded font-bold text-sm">
                </div>
                <button type="submit" class="bg-[#005DAA] text-white p-2 rounded font-bold hover:bg-[#FF5900] transition h-[38px] text-sm uppercase">Gerar</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-center">
            <div class="bg-white p-10 rounded-xl shadow-sm border-t-4 border-[#005DAA]">
                <h3 class="text-gray-400 font-bold text-xs uppercase mb-2">Capacidade de Pessoas</h3>
                <div class="text-5xl font-black text-[#005DAA]"> {{ $salaSelecionada->capacidade ?? '0' }}</div>
            </div>
            <div class="bg-white p-10 rounded-xl shadow-sm border-t-4 border-[#FF5900]">
                <h3 class="text-gray-400 font-bold text-xs uppercase mb-2">Ocupação {{ $labelPeriodo }}</h3>
                <div class="text-5xl font-black text-[#FF5900]">{{ $taxaOcupacao }}%</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm h-[350px]">
                <h4 class="text-center font-bold text-[#005DAA] mb-2 uppercase text-xs">Uso por Turno</h4>
                <canvas id="graficoTurnos"></canvas>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm h-[350px]">
                <h4 class="text-center font-bold text-[#005DAA] mb-2 uppercase text-xs">Uso por Modalidade</h4>
                <canvas id="graficoModalidades"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm overflow-hidden">
            <h3 class="font-bold mb-4 text-[#005DAA] uppercase text-sm">Próximas Alocações</h3>
            <table class="w-full text-left">
                <thead class="bg-[#005DAA] text-white text-xs uppercase">
                    <tr><th class="p-3">Data</th><th class="p-3">Turno</th><th class="p-3">Instrutor</th></tr>
                </thead>
                <tbody>
                    @foreach($proximasReservas as $reserva)
                    <tr class="border-b text-sm">
                        <td class="p-3 font-bold">{{ date('d/m/Y', strtotime($reserva->data)) }}</td>
                        <td class="p-3">{{ $nomesTurnos[$reserva->turno] ?? 'Outro' }}</td>
                        <td class="p-3 text-gray-600 font-medium">{{ $reserva->professor }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('graficoTurnos'), { 
                type: 'bar', 
                data: { labels: {!! json_encode($labels) !!}, datasets: [{ label: 'Reservas', data: {!! json_encode($valores) !!}, backgroundColor: '#005DAA' }] },
                options: { maintainAspectRatio: false }
            });
            new Chart(document.getElementById('graficoModalidades'), { 
                type: 'pie', 
                data: { labels: {!! json_encode($modLabels) !!}, datasets: [{ data: {!! json_encode($modValores) !!}, backgroundColor: ['#FF5900', '#005DAA', '#333', '#2ecc71', '#f1c40f', '#9b59b6', '#1abc9c'] }] },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } } }
            });
        });
    </script>
</x-app-layout>