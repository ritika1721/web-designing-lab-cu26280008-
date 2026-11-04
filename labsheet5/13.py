import mysql.connector
import logging
from getpass import getpass

logging.basicConfig(
    filename="database_errors.log",
    level=logging.ERROR,
    format="%(asctime)s - %(levelname)s - %(message)s"
)

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
    cursor.execute("SELECT VERSION()")
    version = cursor.fetchone()

    print("Database connected successfully!")
    print("MySQL Version:", version[0])

except mysql.connector.Error as error:
    logging.error("Database error: %s", error)
    print("Database error occurred. Check database_errors.log")

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()