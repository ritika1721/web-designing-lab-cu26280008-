import mysql.connector
from html import escape

connection = None
cursor = None

try:
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="lavisha@2006",
        database="python_web_db",
        port=3306
    )

    cursor = connection.cursor()
    cursor.execute("SELECT id, name, email FROM users")
    users = cursor.fetchall()

    html = """
    <html>
    <head><title>User Records</title></head>
    <body>
    <h2>All User Records</h2>
    <table border="1">
    <tr><th>ID</th><th>Name</th><th>Email</th></tr>
    """

    for user in users:
        html += (
            "<tr><td>" + str(user[0]) + "</td>"
            "<td>" + escape(str(user[1])) + "</td>"
            "<td>" + escape(str(user[2])) + "</td></tr>"
        )

    html += "</table></body></html>"

    print(html)

except mysql.connector.Error as error:
    print("Database Error:", error)

finally:
    if cursor:
        cursor.close()
    if connection and connection.is_connected():
        connection.close()