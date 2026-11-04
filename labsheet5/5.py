import mysql.connector

try:
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="lavisha@2006",
        database="python_web_db",
        port=3306
    )

    cursor = connection.cursor()

    users = [
        ("Lavisha", "lavisha@example.com"),
        ("Rahul", "rahul@example.com"),
        ("Priya", "priya@example.com")
    ]

    query = "INSERT INTO users (name, email) VALUES (%s, %s)"

    cursor.executemany(query, users)
    connection.commit()

    print(cursor.rowcount, "user records inserted successfully!")

    cursor.close()
    connection.close()

except mysql.connector.Error as error:
    print("Database Error:", error)