import re

name = input("Enter your name: ").strip()
email = input("Enter your email: ").strip()

# Validate name
if not name or not re.fullmatch(r"[A-Za-z ]+", name):
    print("Invalid name!")
    
# Validate email
elif not re.fullmatch(r"[^@\s]+@[^@\s]+\.[^@\s]+", email):
    print("Invalid email!")
    
else:
    # Sanitize inputs by trimming extra spaces
    name = " ".join(name.split())
    email = email.lower()

    print("Input validated successfully!")
    print("Name:", name)
    print("Email:", email)