This archive contains 3 php files and 1 sql file.

This check out system is build on Apache server and realized with html, php. Use mysql as database management system.

Funtions:
1. On the search books page, there are boxes where users can type their member id (a simplified signin) and a keyword, and a search button. The keyword can be part of a book title or category.
2. After the button on the start page is pressed, the PHP code would check the input member id and display a notice if invalid. Else, it would provide a list of all available books which have the keyword in their title or category, along with detailed information about each book. If no keyword is entered, all available books (and their information) should be displayed.
3. On the search result page, the user should be able to click a button to check out a book. After that, the code should add a record into the checkout table and turn to another page that shows all books currently checked out by this member. Or just shows all books currently checked out by this member if no selection is made.

Installation and running instruction:
1. Install mysql and build new database with name 'hw3p1' with the library.sql file.
2. Install and start Apache Server.
3. Visit http://localhost/hw3_librarycheckout.php
