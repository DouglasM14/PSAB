# PSAB
 Prototipo de um Sistema de Agendamento para Barbearia

Coisas para resolver dps, Sim é pra resolver dps.
    - fazer os reurn dos select não serem mais matriz arrays 
    - arrumar o transction no update de client

Lista de Todas as paginas do site: 

o que user faz
    login
    logut

o que client faz
    marca horario
        visualiza horarios disponiveis
    edita horario
    edita informações
    deleta conta

o que o barbeiro faz
    visualiza agenda
    altera agenda

o que o adm faz 
    tudo que o babeiro e mais isso:
        cadastra barbeiros
        deleta barbeios
        edita info dos barbeiros
        altera agenda dos barbeiros
        edita serviços


dias e horas indisponiveis barbeiros

dias de funcionamento da barbearia com os horarios

se o horario escolhido está disponivel na agenda do barbeiro - AJAX pq tem o dia e a hora escolhida

to do: 

++Fazer sistema do barbeiro marcar se o cara foi vacilão e não foi cortar o bebelo
    - Verificar a resposta
    - Retirar o Cliente do horário após Barbeiro Responde
        (Adaptar o Select pra pegar só quando o State estiver ON)

++Sistema de cancelar horario(Barbeiros e Clientes)
++Historico do cliente

++Terminar a pagina scheduling
    -Tirar o lance do echo nas variaveis
    -Tirar o js da pagina e colocar como externo
    -Otimizar os codigo js para serem chamados em outros lugares (VERIFICAR SE FAZ SENTIDO OU NÃO, melhor fazer as outras paginas primeiro pra ter certeza)
    
++fazer o sistema de horários escolher agenda:
    - Mostrar os dias que o Barbeiro tem na agenda(como check box)
    - Mostrar os horários disponíveis para ele escolher(como check box)
    - Mandar os horários para o PHP
    - Salvar o JSON no banco de dados
    - Verificar se funcionou horários disponíveis para os clientes
        (O cara que tentou separar-- ----o-s -d-ia-s --da-s horas)

++Fazer sistema de Notificação
++"Esqueci minha Senha"
