<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <form action="{{ route('dashboard') }}" method="GET" class="bg-white/80 backdrop-blur p-6 rounded-xl shadow-sm mb-8 flex flex-wrap gap-4 border-l-4 border-[#FF5900]">
            @csrf
            
            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-[#005DAA] uppercase mb-1">Mês de Referência</label>
                <select name="mes" class="p-2 border rounded font-bold text-sm min-w-[150px] focus:ring-[#FF5900] focus:border-[#FF5900]">
                    @php
                        $mesesNomes = [
                            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                        ];
                    @endphp
                    @foreach($mesesNomes as $numero => $nome)
                        <option value="{{ $numero }}" {{ $mes == $numero ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-[#005DAA] uppercase mb-1">Modalidade</label>
                <select name="modalidade" class="p-2 border rounded font-bold text-sm min-w-[180px] focus:ring-[#FF5900] focus:border-[#FF5900]">
                    <option value="">Todas as Modalidades</option>
                    @foreach($listaModalidades as $id => $nome) 
                        <option value="{{ $id }}" {{ $modalidadeFiltro == $id ? 'selected' : '' }}>{{ $nome }}</option> 
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-[#005DAA] uppercase mb-1">Turno</label>
                <select name="turno" class="p-2 border rounded font-bold text-sm min-w-[120px] focus:ring-[#FF5900] focus:border-[#FF5900]">
                    <option value="">Todos os Turnos</option>
                    <option value="2" {{ $turnoFiltro == '2' ? 'selected' : '' }}>Manhã</option>
                    <option value="3" {{ $turnoFiltro == '3' ? 'selected' : '' }}>Tarde</option>
                    <option value="4" {{ $turnoFiltro == '4' ? 'selected' : '' }}>Noite</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-[#005DAA] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#FF5900] transition-all duration-300 h-[42px] shadow-md uppercase text-xs tracking-wider">
                    Atualizar Painel
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-center">
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#FF5900] hover:shadow-md transition-shadow">
                <h3 class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">Taxa de Ocupação</h3>
                <div class="text-4xl font-black text-[#005DAA] mt-2 contador" data-target="{{ $taxaOcupacao }}">{{ $taxaOcupacao }}%</div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#005DAA] hover:shadow-md transition-shadow">
                <h3 class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">Total de Reservas</h3>
                <div class="text-4xl font-black text-[#005DAA] mt-2 contador" data-target="{{ $totalMesAtual }}">{{ $totalMesAtual }}</div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-gray-800 hover:shadow-md transition-shadow">
                <h3 class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">Tendência Mensal</h3>
                <div class="text-4xl font-black mt-2 {{ $crescimento >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $crescimento > 0 ? '+' : '' }}{{ $crescimento }}%
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="font-bold text-[#005DAA] mb-4 text-center uppercase text-xs tracking-tighter"> Gargalos por Turno (Volume de Reservas)</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr class="bg-[#005DAA] text-white text-[10px] uppercase">
                                <th class="p-3 rounded-tl-lg">Dia da Semana</th>
                                @foreach($turnosPrincipais as $t) <th class="p-3">{{ $t }}</th> @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($mapaCalor as $dia => $dadosTurno)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-3 font-bold bg-gray-50 text-xs text-gray-600 border-r">{{ $dia }}</td>
                                @foreach($dadosTurno as $valor)
                                <td class="p-3 font-black {{ $valor > 5 ? 'text-red-600 bg-red-50' : 'text-gray-700' }}">
                                    {{ $valor }}
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-[9px] text-gray-400 mt-4 italic text-center">* Valores em vermelho indicam alta concentração de turmas.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="font-bold text-[#005DAA] mb-4 text-center uppercase text-xs tracking-tighter"> Salas com Menor Ocupação</h2>
                <div class="space-y-3">
                    @forelse($salasOciosas as $s)
                    <div class="flex justify-between items-center p-4 border rounded-lg hover:border-[#FF5900] hover:bg-orange-50 transition-all group">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-gray-100 text-[#005DAA] flex items-center justify-center font-bold text-xs mr-3 group-hover:bg-[#005DAA] group-hover:text-white transition-colors">
                                {{ $loop->iteration }}º
                            </span>
                            <span class="font-bold text-gray-700 uppercase text-xs">{{ $s->nome }}</span>
                        </div>
                        <span class="bg-[#FF5900] text-white px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm">
                            {{ $s->total_reservas }} RESERVAS
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="italic text-sm">Nenhum dado encontrado para os filtros selecionados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animateCounter = (el) => {
                const target = parseFloat(el.getAttribute('data-target'));
                const isPercent = el.innerText.includes('%');
                let current = 0;
                const duration = 1500; // 1.5 segundos
                const increment = target / (duration / 16); // 60fps

                const update = () => {
                    current += increment;
                    if (current < target) {
                        el.innerText = Math.floor(current) + (isPercent ? '%' : '');
                        requestAnimationFrame(update);
                    } else {
                        el.innerText = target + (isPercent ? '%' : '');
                    }
                };
                update();
            };

            document.querySelectorAll('.contador').forEach(animateCounter);
        });
    </script>
</x-app-layout>