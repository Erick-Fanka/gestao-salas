<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Sala;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $nomesModalidades = [
        2 => 'Aperfeiçoamento', 3 => 'Aprendizagem', 4 => 'Evento', 5 => 'Graduação',
        6 => 'Manutenção', 7 => 'Olimpíada', 8 => 'Qualificação', 9 => 'Reunião',
        10 => 'Técnico', 11 => 'Treinamento', 13 => 'Iniciação'
    ];

    private $nomesTurnos = [2 => 'Manhã', 3 => 'Tarde', 4 => 'Noite', 9 => 'Monitoria'];

    // 1. VISÃO MENSAL CORRIGIDA
    public function index(Request $request)
    {
        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', date('m'));
        $turnoFiltro = $request->input('turno', ''); 
        $modalidadeFiltro = $request->input('modalidade', '');

        // Query base para os contadores
        $query = Reserva::whereYear('data', $ano)->whereMonth('data', $mes);
        if ($turnoFiltro) $query->where('turno', $turnoFiltro);
        if ($modalidadeFiltro) $query->where('modalidade', $modalidadeFiltro);
        
        $totalMesAtual = $query->count();
        
        // Tendência (Mês anterior)
        $dataAnterior = Carbon::create($ano, $mes, 1)->subMonth();
        $totalMesAnterior = Reserva::whereYear('data', $dataAnterior->year)
                                    ->whereMonth('data', $dataAnterior->month)
                                    ->count();
        $crescimento = $totalMesAnterior > 0 ? round((($totalMesAtual - $totalMesAnterior) / $totalMesAnterior) * 100, 1) : ($totalMesAtual > 0 ? 100 : 0);

        // Ocupação
        $totalSalasAtivas = Sala::where('ativo', 1)->count();
        $taxaOcupacao = $totalSalasAtivas > 0 ? round(($totalMesAtual / ($totalSalasAtivas * 66)) * 100, 1) : 0;

        // --- CORREÇÃO: SALAS MENOS USADAS ---
        // Agora o filtro de modalidade e turno entra dentro do JOIN para o cálculo ser real
        $salasOciosas = Sala::where('salas.ativo', 1)
            ->leftJoin('reservas', function($join) use ($ano, $mes, $modalidadeFiltro, $turnoFiltro) {
                $join->on('salas.id', '=', 'reservas.sala')
                     ->whereRaw('YEAR(reservas.data) = ?', [$ano])
                     ->whereRaw('MONTH(reservas.data) = ?', [$mes]);
                
                if ($modalidadeFiltro) $join->where('reservas.modalidade', $modalidadeFiltro);
                if ($turnoFiltro) $join->where('reservas.turno', $turnoFiltro);
            })
            ->select('salas.nome', DB::raw('count(reservas.id) as total_reservas'))
            ->groupBy('salas.id', 'salas.nome')
            ->orderBy('total_reservas', 'asc') // Menos usadas primeiro
            ->limit(5)
            ->get();

        // --- CORREÇÃO: GARGALOS POR TURNO (Mapa de Calor) ---
        $mapaCalor = [];
        $diasSemana = [2 => 'Segunda', 3 => 'Terça', 4 => 'Quarta', 5 => 'Quinta', 6 => 'Sexta'];
        $turnos = [2 => 'Manhã', 3 => 'Tarde', 4 => 'Noite'];

        foreach ($diasSemana as $num => $nome) {
            foreach ($turnos as $tNum => $tNome) {
                $qCalor = Reserva::whereYear('data', $ano)
                                 ->whereMonth('data', $mes)
                                 ->whereRaw('DAYOFWEEK(data) = ?', [$num])
                                 ->where('turno', $tNum);
                
                // Aplica o filtro de modalidade no mapa também
                if ($modalidadeFiltro) $qCalor->where('modalidade', $modalidadeFiltro);
                
                $mapaCalor[$nome][$tNome] = $qCalor->count();
            }
        }

        return view('dashboard', [
            'ano' => $ano, 'mes' => $mes, 'totalMesAtual' => $totalMesAtual, 
            'taxaOcupacao' => $taxaOcupacao, 'crescimento' => $crescimento,
            'mapaCalor' => $mapaCalor, 'salasOciosas' => $salasOciosas,
            'turnoFiltro' => $turnoFiltro, 'modalidadeFiltro' => $modalidadeFiltro,
            'listaModalidades' => $this->nomesModalidades,
            'turnosPrincipais' => $turnos
        ]);
    }

    // 2. RAIO-X DA SALA
    public function porSala(Request $request)
    {
        $salas = Sala::where('ativo', 1)->get();
        $salaId = $request->input('sala_id', $salas->first()->id ?? null);
        $salaSelecionada = $salas->firstWhere('id', $salaId);
        
        $periodo = $request->input('periodo', 'mes'); 
        $dataBase = $request->input('data_base', date('Y-m-d')); 
        $turnoFiltro = $request->input('turno', ''); 
        $modalidadeFiltro = $request->input('modalidade', '');
        $dataCarbon = Carbon::parse($dataBase);

        $q = Reserva::where('sala', $salaId);
        
        if ($periodo == 'dia') {
            $q->whereDate('data', $dataCarbon->format('Y-m-d'));
            $capMax = 3;
            $labelPeriodo = 'no Dia';
        } elseif ($periodo == 'semana') {
            $inicioSemana = $dataCarbon->copy()->startOfWeek();
            $fimSemana = $dataCarbon->copy()->endOfWeek();
            $q->whereBetween('data', [$inicioSemana, $fimSemana]);
            $capMax = 15;
            $labelPeriodo = 'na Semana';
        } else {
            $q->whereYear('data', $dataCarbon->year)->whereMonth('data', $dataCarbon->month);
            $capMax = 66;
            $labelPeriodo = 'no Mês';
        }
        
        if ($turnoFiltro) $q->where('turno', $turnoFiltro);
        if ($modalidadeFiltro) $q->where('modalidade', $modalidadeFiltro);
        
        $totalReservas = $q->count();
        $taxaOcupacao = round(($totalReservas / $capMax) * 100, 1);
        
        $labels = ['Manhã', 'Tarde', 'Noite'];
        $valores = [(clone $q)->where('turno', 2)->count(), (clone $q)->where('turno', 3)->count(), (clone $q)->where('turno', 4)->count()];

        $usoModalidades = (clone $q)->select('modalidade', DB::raw('count(*) as total'))->groupBy('modalidade')->get();
        $modLabels = []; $modValores = [];
        foreach ($usoModalidades as $item) {
            $modLabels[] = $this->nomesModalidades[$item->modalidade] ?? 'Outros';
            $modValores[] = $item->total;
        }

        $proximasReservas = Reserva::where('sala', $salaId)->whereDate('data', '>=', date('Y-m-d'))
            ->leftJoin('usuarios', 'reservas.usuario', '=', 'usuarios.id') 
            ->select('reservas.*', 'usuarios.nome as professor') 
            ->orderBy('data', 'asc')->limit(5)->get();

        return view('dashboard_sala', [
            'salas' => $salas, 'salaId' => $salaId, 'salaSelecionada' => $salaSelecionada,
            'periodo' => $periodo, 'dataBase' => $dataBase, 'taxaOcupacao' => $taxaOcupacao,
            'labels' => $labels, 'valores' => $valores, 'modLabels' => $modLabels, 'modValores' => $modValores,
            'proximasReservas' => $proximasReservas, 'nomesTurnos' => [2 => 'Manhã', 3 => 'Tarde', 4 => 'Noite'],
            'labelPeriodo' => $labelPeriodo, 'turnoFiltro' => $turnoFiltro, 'modalidadeFiltro' => $modalidadeFiltro,
            'nomesModalidades' => $this->nomesModalidades
        ]);
    }

    // 3. AGENDA DIÁRIA
    public function porDia(Request $request)
    {
        $dataEscolhida = $request->input('data', date('Y-m-d'));
        $turnoFiltro = $request->input('turno', ''); 
        $statusFiltro = $request->input('status', ''); 
        
        $salas = Sala::where('ativo', 1)->get();
        $nomesTurnos = [2 => 'Manhã', 3 => 'Tarde', 4 => 'Noite', 9 => 'Monitoria'];

        $query = Reserva::whereDate('reservas.data', $dataEscolhida)
            ->leftJoin('usuarios', 'reservas.usuario', '=', 'usuarios.id') 
            ->select('reservas.*', 'usuarios.nome as professor_nome');

        if ($turnoFiltro != '') {
            $idTurno = is_numeric($turnoFiltro) ? $turnoFiltro : array_search($turnoFiltro, $nomesTurnos);
            if ($idTurno) $query->where('reservas.turno', $idTurno);
        }
        
        $reservas = $query->get();
        $ocupadasIds = $reservas->pluck('sala')->toArray();
        $dadosCompletos = [];
        
        foreach ($reservas as $r) {
            $dadosCompletos[] = [
                'sala_nome' => $salas->firstWhere('id', $r->sala)->nome ?? 'N/A',
                'turno' => $nomesTurnos[$r->turno] ?? 'Outro',
                'professor' => $r->professor_nome ?? 'Não informado',
                'status' => 'Ocupada'
            ];
        }

        foreach ($salas as $s) {
            if (!in_array($s->id, $ocupadasIds)) {
                $dadosCompletos[] = [
                    'sala_nome' => $s->nome, 
                    'turno' => ($turnoFiltro && isset($nomesTurnos[$turnoFiltro]) ? $nomesTurnos[$turnoFiltro] : '-'), 
                    'professor' => '-', 
                    'status' => 'Livre'
                ];
            }
        }

        $dadosTabela = $dadosCompletos;
        if ($statusFiltro == 'ocupada') $dadosTabela = array_filter($dadosCompletos, fn($item) => $item['status'] == 'Ocupada');
        elseif ($statusFiltro == 'livre') $dadosTabela = array_filter($dadosCompletos, fn($item) => $item['status'] == 'Livre');

        return view('dashboard_dia', [
            'dataEscolhida' => $dataEscolhida, 'turnoFiltro' => $turnoFiltro, 'statusFiltro' => $statusFiltro, 
            'dadosTabela' => $dadosTabela, 'totalSalas' => $salas->count(),
            'totalOcupadas' => count(array_unique($ocupadasIds)), 'totalLivres' => $salas->count() - count(array_unique($ocupadasIds))
        ]);
    }
}