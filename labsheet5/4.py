import mysql.connector

try:
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="lavisha@2006",
        port=3306
    )

    cursor = connection.cursor()

    cursor.execute("CREATE DATABASE IF NOT EXISTS python_web_db")
    print("Database created successfully!")

    cursor.execute("USE python_web_db")

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100)
        )
    """)

    print("Users table created successfully!")

    cursor.close()
    connection.close()

except mysql.connector.Error as error:
    print("MySQL Error:", error)