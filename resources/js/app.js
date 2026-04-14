document.addEventListener('DOMContentLoaded', function() {
    
    /**
     * 1. EFEITO DE CONTADOR ANIMADO
     * Faz os números (como 44, 26, 18) subirem de 0 até o valor real.
     */
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const updateCount = () => {
            // Pega o valor final definido no atributo data-target do HTML
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            
            // Ajuste de velocidade (quanto maior o divisor, mais lento o efeito)
            const speed = 80; 
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                // Chama a função novamente em 20 milissegundos
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        
        // Só inicia a animação se o target for maior que 0
        if(+counter.getAttribute('data-target') > 0) {
            updateCount();
        }
    });

    /**
     * 2. FILTRO RÁPIDO NA TABELA (SEM REFRESH)
     * Esconde as linhas da tabela que não batem com o que foi digitado.
     */
    const inputBusca = document.getElementById('filtroRapido');
    const tabela = document.getElementById('tabelaAgenda');

    if (inputBusca && tabela) {
        const corpoTabela = tabela.getElementsByTagName('tbody')[0];
        const linhas = corpoTabela.getElementsByTagName('tr');

        inputBusca.addEventListener('keyup', function() {
            const termo = inputBusca.value.toLowerCase();

            Array.from(linhas).forEach(linha => {
                // Pega todo o texto da linha (Sala, Professor, Turma, etc)
                const textoDaLinha = linha.textContent.toLowerCase();
                
                if (textoDaLinha.indexOf(termo) > -1) {
                    linha.style.display = ""; // Mostra a linha
                    linha.style.opacity = "1";
                } else {
                    linha.style.display = "none"; // Esconde a linha
                }
            });
        });
    }
});