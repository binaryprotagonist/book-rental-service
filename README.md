Steps to setup

1. Take clone of Repository.
2. Create a database and set credentials in .env
3. Set Gmail credentials in .env and give proper permission Gmail account for send email.
4. Run migration cammand for creating database table "php artisan migrate"
5. Run seed cammand for insert books details in book table "php artisan db:seed"
6. Create a user with the help of register Api (All Api postman collection provided)
7. Login user with the help of login api with email and password. you can get the token in return.
8. Test all Api's with pass bearer token in authentication.
9. For testing the overdue book set a past rent date and run a custom cammand "php artisan rentals:mark-overdue"
10. When you run the custom cammand then user also receive a email related to overdue related information.
