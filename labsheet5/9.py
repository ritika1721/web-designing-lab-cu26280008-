import mysql.connector
from getpass import getpass

connection = None
cursor = None

try:
    user_id = int(input("Enter User ID to delete: "))

    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password=getpass("Enter MySQL password: "),
        database="python_web_db",
        port=3306
    )

    cursor = connection.cursor()

    query = "DELETE FROM users WHERE id = %s"
    cursor.execute(query, (user_id,))
    connection.commit()

    if cursor.rowcount > 0:
        print("User record deleted successfully!")
    else:
        print("No user found with this ID.")

except ValueError:
    print("Invalid input! Please enter a numeric User ID.")

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()