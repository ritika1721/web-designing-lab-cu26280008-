import mysql.connector
from getpass import getpass

connection = None
cursor = None

try:
    search_name = input("Enter name to search: ").strip()

    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password=getpass("Enter MySQL password: "),
        database="python_web_db",
        port=3306
    )

    cursor = connection.cursor()

    query = "SELECT id, name, email FROM users WHERE name = %s"
    cursor.execute(query, (search_name,))

    records = cursor.fetchall()

    if records:
        print("\nUser Records:")
        for user in records:
            print("ID:", user[0])
            print("Name:", user[1])
            print("Email:", user[2])
            print("----------------")
    else:
        print("No matching user found.")

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()