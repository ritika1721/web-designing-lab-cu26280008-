import csv
import mysql.connector
from getpass import getpass

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

    with open("users.csv", "r", newline="", encoding="utf-8") as file:
        reader = csv.DictReader(file)

        users = [
            (row["name"], row["email"])
            for row in reader
        ]

    if users:
        query = "INSERT INTO users (name, email) VALUES (%s, %s)"
        cursor.executemany(query, users)
        connection.commit()
        print(len(users), "records inserted successfully!")
    else:
        print("CSV file is empty.")

except (mysql.connector.Error, OSError, KeyError, csv.Error) as error:
    if connection and connection.is_connected():
        connection.rollback()
    print("Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()