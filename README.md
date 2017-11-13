# restProject
Nesse projeto foi utilziado o programa xamp, este possui servidor apache, php, mysql.
Para o banco de dados devem ser rodados os script que estão no caminho restProjet/rest/rest_db/
  - db_script.sql : Cria o banco de dados.
  - load_plans.sql : Adiciona os planos no banco de dados.
Após instalado os servidores e configurado corretamente o banco de dados, basta acessar o sales.php da seguinte maneira:
  - ^/sales/payment : Para adicionar pagamentos com método POST.
  - ^/sales/plans : Para obter o json dos pagamentos com método GET.
