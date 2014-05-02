How it works 
------------
Project that converts CSV (Excel files) to a simple insert statement. Provided that:
- the first row contains the names of the fields 
	- in the order that they appear in the database
- the name of the file is the same as the name of the database table

Files with an extension .csv will be read in the folder where the both php files reside.

an sql file with the same name as the database table will be stored in the folder where both php files reside.

Files 
-----
index.php	- files that display the CSV files in the folder with an hyperlink
csv2sql.php	- script that processes the csv file