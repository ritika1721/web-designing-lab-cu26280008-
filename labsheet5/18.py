import mysql.connector
from getpass import getpass
import uuid

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

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS user_sessions (
            session_id VARCHAR(100) PRIMARY KEY,
            username VARCHAR(100) NOT NULL
        )
    """)

    session_id = str(uuid.uuid4())
    username = input("Enter username: ").strip()

    if not username:
        print("Username cannot be empty.")
    else:
        cursor.execute(
            "INSERT INTO user_sessions (session_id, username) VALUES (%s, %s)",
            (session_id, username)
        )
        connection.commit()

        print("Session created successfully!")
        print("Session ID:", session_id)

        cursor.execute(
            "SELECT username FROM user_sessions WHERE session_id = %s",
            (session_id,)
        )
        result = cursor.fetchone()

        if result:
            print("Session username:", result[0])

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()