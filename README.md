##  How to install and run your task?
- this app created with laravel 5.8 so you need PHP >= 7.1.3.
- go to this repository link "https://github.com/seniorsam/fleet/tree/master".
- run git clone on the project git link "https://github.com/seniorsam/fleet.git".
- when done cloning to your device run "composer install" in the project root.
- configure the database in ".env" file.
- run "php artisan serve" in the project root.
##  overview about What i did so far.
- this app depends on 1 controller (ExpensesController), and two custom services on of them responsible for building the main sql (search query (VehicleExpensesSearcher) <br> and the other service responsible for building the sql filteration (VehicleExpensesFilter) <br> 
and tests file (VehicleExpensesSearcherTest). <br>
- i tried to seperate the concerns by creting custom services depend on each other, to make the modifications and reusability easier in case if you want to add more features.
##  How to expose the Endpoint?
- http://baseurl/api/v1/cars/expenses
##  How to make a search, filter, and sorting?
### Full filteration example
- http://baseurl/api/v1/cars/expenses?page=1&type=fuel&vehicle_name=don&cost_min=1&cost_max=100&date_min=2019-1-1&date_max=2020-1-1&sort=cost,asc
## Important consedirations
- i am using "paging and limitation" for the data reponse to increase perforanmce and reduce response time.
- for example if the returned data is "900" record i split it to 3 parts corresponding to 3 pages each page hold 300 so if you want to get the first "300" records you pass "page=1" and if you want to get the second "300" records you pass "page=2" and so on.
- you will notice that i pass "page=1" in the previous url, if you didn't pass the page it will be "1" by default.
- check the previous filteration example carefully for the keys and values formats in order for the filteration to work as expected, or you might notice the following
    - if you passed wrong filter key the app wont take it in consideration.
    - only allowed sort keys are "cost" and "created_at", if you passed diffrent key the app will use cost by default, for example if you passed "sort=name,asc" the app will treat it as "sort=cost,asc" because "name" not available for sorting as you required in the task.
    so try to imitate the exmample we mentioned earlier;

### Please feel free to contact me regards any clarification
#### Thanks in advance