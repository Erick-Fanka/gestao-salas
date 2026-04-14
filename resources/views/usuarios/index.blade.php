<x-app-layout>
    <style>
        .card-gestao { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 6px solid #FF5900; }
        .input-senai { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; }
        .btn-senai { background: #005DAA; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; border: none; transition: 0.3s; width: 100%; }
        .btn-senai:hover { background: #FF5900; }
        
        .tabela-usuarios { width: 100%; margin-top: 20px; border-collapse: collapse; overflow: hidden; border-radius: 8px; }
        .tabela-usuarios th { background: #005DAA; color: white; padding: 12px; text-align: left; font-size: 0.9rem; }
        .tabela-usuarios td { padding: 12px; border-bottom: 1px solid #eee; background: white; font-size: 0.95rem; }
        .btn-remover { color: #e74c3c; font-weight: bold; border: none; background: none; cursor: pointer; }
        .btn-remover:hover { text-decoration: underline; }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="card-gestao mb-8">
                <h2 class="text-2xl font-bold text-[#005DAA] mb-6">Cadastrar Novo Usuário</h2>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-4 font-bold">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4 font-bold">{{ session('error') }}</div>
                @endif

                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Nome Completo" class="input-senai" required>
                        <input type="email" name="email" placeholder="E-mail Corporativo" class="input-senai" required>
                    </div>
                    <input type="password" name="password" placeholder="Senha (mínimo 8 caracteres)" class="input-senai" required>
                    <button type="submit" class="btn-senai">CRIAR ACESSO</button>
                </form>
            </div>

            <div class="card-gestao">
                <h3 class="text-xl font-bold text-[#005DAA] mb-4">Usuários Cadastrados</h3>
                <table class="tabela-usuarios">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                        <tr>
                            <td class="font-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->email !== 'erickfanka@gmail.com')
                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remover">Remover</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs font-bold uppercase">Admin</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>  
    </div>
</x-app-layout>