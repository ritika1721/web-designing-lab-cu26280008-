import mysql.connector
from getpass import getpass

connection = None
cursor = None

try:
    user_id = int(input("Enter User ID to update: "))
    new_name = input("Enter new name: ").strip()
    new_email = input("Enter new email: ").strip()

    if not new_name or not new_email:
        print("Name and email cannot be empty.")
    else:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password=getpass("Enter MySQL password: "),
            database="python_web_db",
            port=3306
        )

        cursor = connection.cursor()

        query = "UPDATE users SET name = %s, email = %s WHERE id = %s"
        cursor.execute(query, (new_name, new_email, user_id))
        connection.commit()

        if cursor.rowcount > 0:
            print("User profile updated successfully!")
        else:
            print("No user found with this ID.")

except ValueError:
    print("Please enter a valid numeric User ID.")

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()