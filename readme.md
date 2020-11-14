##  How to install and run your task?
- this app created with laravel 5.8 so you need PHP >= 7.1.3.
- go to this repository link "https://github.com/seniorsam/fleet/tree/master".
- run git clone on the project git link "https://github.com/seniorsam/fleet.git".
- when done cloning to your device run "composer install" in the project root.
- run "php artisan serve" in the project root.
##  How to expose the Endpoint?
- http://baseurl/api/v1/cars/expenses
##  How to make a search, filter, and sorting?
### Full filteration example
- http://baseurl/api/v1/cars/expenses?page=1&type=fuel&vehicle_name=don&cost_min=1&cost_max=100&date_min=2019-1-1&date_max=2020-1-1&sort=cost,asc
## Important consedirations
- i am using "paging and limitation" for the data reponse to increase perforanmce and reduce response time, you will notice that i pass "page=1" in the previous url, if you didn't pass the page it will be "1" by default, otherwise you have to pass the "page" accordingly to get full inforamtion. 