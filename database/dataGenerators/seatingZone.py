import mysql.connector

db = mysql.connector.connect(
    host='127.0.0.1',
    user='root',
    password ='password',
    database='nhl'
)

cursor = db.cursor()

def zoneData(stadiumId,capacity):
    #(stadiumId,zoneId,capacity)
    seatingZoneId = 1
    zones = []
    while seatingZoneId < 5:
        def zoneinfo(zoneId):
            my_dict = {
                1:{'capacity':0.05,'name':'vip'},
                2:{'capacity':0.15,'name':'s'},
                3:{'capacity':0.5,'name':'a'},
                4:{'capacity':0.3,'name':'b'}
            }
            return my_dict[zoneId]#

        def zone_tuple(stadiumId,zoneId,capacity,iteration):
            stadiumSeatingZoneId = "Zone" + str(stadiumId) + zoneinfo(zoneId).get('name') + str(iteration)
            return (stadiumSeatingZoneId, stadiumId,zoneId,capacity)
    
        zonecapacity = int(zoneinfo(seatingZoneId).get('capacity')*capacity)
        zones = zones + [zone_tuple(stadiumId, seatingZoneId, x,(i+1)) for i,x in  enumerate([200]*(zonecapacity//200) + [zonecapacity%200])]
        seatingZoneId += 1
    return zones

cursor.execute("select * from Stadium")
result = cursor.fetchall()

for x in result:
    data = zoneData(x[0],x[3])
    query = """insert into StadiumSeatingZone (stadiumSeatingZoneId,stadiumId,seatingType,capacity)
                    values(%s,%s,%s,%s);"""
    cursor.executemany(query, data)
    db.commit()
db.close()