import mysql.connector

db = mysql.connector.connect(
  host='127.0.0.1',
  user='root',
  password='password',
  database='nhl'
)
cursor = db.cursor()

def seatData(stadiumSeatingZoneId,capacity):
  def seat_tuple(stadiumSeatingZoneId,iteration,asciichar):
    row = (iteration + 1) % 20
    asciichar = asciichar +(iteration//20)
    return (stadiumSeatingZoneId,row,asciichar)
  return [seat_tuple(stadiumSeatingZoneId, iteration,97) for iteration in range(capacity)]


cursor.execute('select stadiumSeatingZoneId,capacity from StadiumSeatingZone')
result = cursor.fetchall()
for x in result:
  data = seatData(x[0], x[1])
  query = """insert into Seat (stadiumSeatingZoneId,`row`,`column`) values(%s,%s,char(%s));"""
  cursor.executemany(query, data)
  db.commit()
db.close()