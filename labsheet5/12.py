import mysql.connector
from mysql.connector import pooling
from getpass import getpass

pool = None
connection = None
cursor = None

try:
    password = getpass("Enter MySQL password: ")

    pool = pooling.MySQLConnectionPool(
        pool_name="mypool",
        pool_size=3,
        host="localhost",
        user="root",
        password=password,
        database="python_web_db",
        port=3306
    )

    connection = pool.get_connection()
    cursor = connection.cursor()

    cursor.execute("SELECT id, name, email FROM users")
    records = cursor.fetchall()

    print("Connection pooling successful!")
    print("\nUser Records:")

    for user in records:
        print(user)

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()

print("Database connection returned to the pool.")