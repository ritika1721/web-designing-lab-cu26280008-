import mysql.connector

try:
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="lavisha@2006",
        port=3306
    )

    cursor = connection.cursor()
    cursor.execute("SELECT VERSION()")

    result = cursor.fetchone()

    print("Connected to MySQL Server Successfully!")
    print("MySQL Server Version:", result[0])

    cursor.close()
    connection.close()

except mysql.connector.Error as error:
    print("MySQL Error:", error)