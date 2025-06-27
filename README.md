# Este codigo é um exemplo de como faz para ver a previsão do tempo em tempo real via terminal :v
## Usamos uma API do site Open Weather, para conseguir sua API precisa fazer login e ir no seu perfil e acessar o "My API key"
- Usamos tambem um composer.json depois no terminal para fazermos a instalação dele precisa digitar
- Comando: composer install


# dia 2: Usei apache para banco de dados
## dito isso, Usei mysql mesmo porém muitos erros enfrentei ao linkar o apache com o mysql
### Parte do front... tem 2 inputs com um botão de consulta que ainda não funciona, tendo problemas no banco

# dia 3
## Ajustado o apache, e tambem ajustado o erro nas chamadas das classes que estavam sendo chamadas de app/WebServices/....
## o jeito certo era app/WebServer/
### Em todo caso, para esse codigo funcionar precisa fazer o seguinte:
- navegar até o arquivo index.php e colocar no terminal *php -S localhost:8000*, assim poderá acessar o link  http://localhost:8000

# dia 4 
## adicionado conexao mysql 
### creditos @wdevoficial 
