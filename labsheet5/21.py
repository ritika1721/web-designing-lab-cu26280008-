import mysql.connector

print("Q21 program started")

try:
    con = mysql.connector.connect(
        host="localhost",
        user="root",
        password="YOUR_MYSQL_PASSWORD",
        database="python_web_db",
        port=3306
    )

    print("Database connected successfully!")

    cur = con.cursor()

    cur.execute("SELECT COUNT(*) FROM users")
    total = cur.fetchone()[0]

    cur.execute("SELECT MIN(id), MAX(id) FROM users")
    result = cur.fetchone()

    print("\nANALYTICAL SUMMARY REPORT")
    print("-------------------------")
    print("Total Users:", total)
    print("First User ID:", result[0])
    print("Last User ID:", result[1])

    cur.close()
    con.close()

except Exception as err:
    print("Error:", err)