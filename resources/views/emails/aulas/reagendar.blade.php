<x-mail::message>
# Alteração no agendamento da aula

Horário e data da aula foram alterados. <br><br>

Data: {{ \Carbon\Carbon::create($data['data_agendamento'])->format('d/m/Y') }} <br>
Horário: {{ \Carbon\Carbon::create($data['hora_agendamento'])->format('H:s') }}


<x-mail::button :url="''">
Acessar Sistema
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
