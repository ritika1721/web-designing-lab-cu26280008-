import mysql.connector
from getpass import getpass

name = input("Enter user name: ").strip()
email = input("Enter user email: ").strip()

if not name or not email:
    print("Name and email are required.")
else:
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password=getpass("Enter MySQL password: "),
            database="python_web_db",
            port=3306
        )

        cursor = connection.cursor()

        query = "INSERT INTO users (name, email) VALUES (%s, %s)"
        cursor.execute(query, (name, email))
        connection.commit()

        print("User registered successfully!")

    except mysql.connector.Error as error:
        print("Database Error:", error)

    finally:
        if cursor:
            cursor.close()
        if connection and connection.is_connected():
            connection.close()