# For Setup Project
 This Project Based On CI3 Frame Work
1. Clone Project
2.  Create a database "task_pro" use sql query from sql_diff.sql
3. Change Usermame ,Password ,Host and database Name
4. Database Details Define in   "task/application/config/basic_setup.php"
5. For Browser Controller Please Check  Billing Controller path "task/application/controllers/Billing.php"
6. For Api Controller Please Check Song controller "task/application/controllers/api/Task.php"
7. For Model Please check  "task/application/models/Task_model"
8. For View Check under view folder
9. Some Ie.Api Url http://base_url/index.php/api/apicontrollername/Methordname
	{"name":"Move Your Body"}
10. http://localhost:8080//index.php/api/task/index
Methord GET
Response: 
In Json Formate
11. All Api GET Methord


Cron
http://localhost:8080/task/index.php/cronjob/deleteTask
Crontab -e
Command : php -f index.php cronjob/deleteTask

