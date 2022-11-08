<x-mail::message>
# Bem vindo!

Você agora tem uma conta de usuário e senha para acessar nosso sistema, basta clicar no botão "Acessar Sistema" fazer
login e boa.<br><br>

Usuário: {{ $data['email'] }} <br>
Senha: {{ $data['password'] }}

<x-mail::button :url="''">
Acessar Sistema
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
