#!/usr/bin/env python

import time
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
import Adafruit_CharLCD as LCD

db = mysql.connector.connect(
  host="localhost",
  user="grapeadmin",
  passwd="********",
  database="etrikelog"
)

cursor = db.cursor()
reader = SimpleMFRC522()
lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 4);

try:
  while True:
#     lcd.clear()
#     lcd.message('Place Card to\nregister')
    print('Place Card to register')
    id, text = reader.read()
    cursor.execute("SELECT id FROM users WHERE rfid_uid="+str(id))
    cursor.fetchone()

    if cursor.rowcount >= 1:
#       lcd.clear()
#       lcd.message("Overwrite\nexisting user?")
      print('Overwrite existing user?')
      overwrite = input("Overwite (Y/N)? ")
      if overwrite[0] == 'Y' or overwrite[0] == 'y':
#         lcd.clear()
#         lcd.message("Overwriting user.")
        print("Overwriting user.")
        time.sleep(1)
        sql_insert = "UPDATE users SET name = %s WHERE rfid_uid=%s"
      else:
        continue;
    else:
      sql_insert = "INSERT INTO users (name, rfid_uid) VALUES (%s, %s)"
#     lcd.clear()
#     lcd.message('Enter new name')
    print("Enter new name")
    new_name = input("Name: ")

    cursor.execute(sql_insert, (new_name, id))

    db.commit()

#     lcd.clear()
#     lcd.message("User " + new_name + "\nSaved")
    print("User " + new_name + "Saved")
    time.sleep(2)
finally:
  GPIO.cleanup()
