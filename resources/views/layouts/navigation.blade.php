<nav x-data="{ open: false, userMenu: false }" class="bg-white border-b-4 border-[#005DAA] shadow-md relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-[#333]">
                        SENAI <span class="text-[#FF5900]">Mauá</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold leading-5 text-gray-500 hover:text-[#005DAA] transition"> Início</a>
                    
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-[#FF5900] text-[#FF5900]' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 transition"> Visão Mensal</a>
                    
                    <a href="{{ route('dashboard.sala') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard.sala') ? 'border-[#FF5900] text-[#FF5900]' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 transition"> Raio-X</a>
                    
                    <a href="{{ route('dashboard.dia') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard.dia') ? 'border-[#FF5900] text-[#FF5900]' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 transition"> Agenda Diária</a>

                    @if(Auth::user()->email === 'erickfanka@gmail.com')
                        <a href="{{ route('usuarios.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('usuarios.index') ? 'border-[#FF5900] text-[#FF5900]' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 transition">
                             Gestão de Usuários
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 relative">
                <div class="relative">
                    <button @click="userMenu = !userMenu" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-bold rounded-md text-[#005DAA] bg-white hover:bg-gray-50 focus:outline-none transition">
                        <div> {{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="userMenu" @click.away="userMenu = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-100 transition">
                             Mudar Minha Senha
                        </a>

                        <div class="border-t border-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 transition">
                                 Sair (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>