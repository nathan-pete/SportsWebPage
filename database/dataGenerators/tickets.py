import mysql.connector

db = mysql.connector.connect(
  host='127.0.0.1',
  user='root',
  password='password',
  database='nhl'
)
cursor = db.cursor()

clients = cursor.execute('select * from Client').fetchall()
events = cursor.execute('select * from Event').fetchall()
