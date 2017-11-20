# restProject
Nesse projeto foi utilizado o programa xamp, este possui servidor apache, php, mysql.
Para o banco de dados devem ser executados os scripts que estão no caminho restProjet/rest/rest_db/
  - db_script.sql : Cria o banco de dados.
  - load_plans.sql : Adiciona os planos no banco de dados.
  
Após instalado os servidores e configurado corretamente o banco de dados, basta acessar o sales.php da seguinte maneira:
  - ^/sales/payment : Para adicionar pagamentos com método POST.
  - ^/sales/plans : Para obter o json dos pagamentos com método GET.
  
  Obs: Nenhum campo da compra é calculado pelo back-end, ou seja todos os campos devem ser enviados no método POST.

# FrontEnd Project

 Ouve algumas modificações no banco de dados, então para utilizar esse projeto, deve-se rodar o script load_plans novamente. Os caminhos do paymente e plans tem que ser exatamente:
    -localhost/rest/sales/payment
    -localhost/rest/sales/plans
    
 Os caminhos das novas implementações são:
  -localhost/frontEnd/pagamento.php
  -localhost/frontEnd/produtos.php
