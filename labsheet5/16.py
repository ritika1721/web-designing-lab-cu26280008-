import mysql.connector
import json
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

    cursor = connection.cursor(dictionary=True)

    cursor.execute("SELECT id, name, email FROM users")
    users = cursor.fetchall()

    # Convert database records into JSON
    json_data = json.dumps(users, indent=4)

    print("JSON Response:")
    print(json_data)

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()