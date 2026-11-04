import sys

print("Python Virtual Environment Setup")
print("Python version:", sys.version)
print("Python executable:", sys.executable)

try:
    import mysql.connector
    print("MySQL Connector installed successfully!")
except ImportError:
    print("MySQL Connector is not installed!")