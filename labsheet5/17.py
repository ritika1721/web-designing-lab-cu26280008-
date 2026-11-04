import mysql.connector
from getpass import getpass
from datetime import datetime

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

    filename = "python_web_db_backup.sql"

    with open(filename, "w", encoding="utf-8") as file:
        file.write("-- MySQL Database Backup\n")
        file.write("-- Created: " + str(datetime.now()) + "\n\n")
        file.write("CREATE DATABASE IF NOT EXISTS python_web_db;\n")
        file.write("USE python_web_db;\n\n")

        cursor.execute("SHOW CREATE TABLE users")
        table_info = cursor.fetchone()
        file.write(table_info[1] + ";\n\n")

        cursor.execute("SELECT id, name, email FROM users")
        rows = cursor.fetchall()

        for row in rows:
            values = ", ".join(
                "NULL" if value is None
                else "'" + str(value).replace("\\", "\\\\").replace("'", "\\'") + "'"
                for value in row
            )
            file.write(
                "INSERT INTO users (id, name, email) VALUES ("
                + values + ");\n"
            )

    print("Backup created successfully:", filename)

except (mysql.connector.Error, OSError) as error:
    print("Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()