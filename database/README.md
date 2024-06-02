# TODO
  - user & privilege management
- ez install instructions
 - installation
 - replication
 
 # Installation
- Login as root
- create the db
```mysql
 create database nhl_sports;
```
- use the database
```mysql
use nhl_sports;
```
- import the database
```
source ~/Path/to/Repo/database/nhl-sports.sql;
```

# Some queries

## Authentication
```mysql
-- login
select * from Client where email = ?

-- sign up
insert into Client (firstname,lastname,email,password) values(?,?,?)
```

## Homepage
```mysql
-- weekly mathces
select *
from Event
where date between current_date() and date_add(current_date(),interval 1 week)

-- select highlight event
select *
from Event
where date between current_date() 
  and date_add(current_date(),interval 1 week)
order by rand() limit 1
```

## all events page
```mysql
-- all events from today
select * from Event where date >= date(now()) and time > current_time() order by date asc

-- filter by month
select * from Event where month(date) = ?

-- all events by sport
select * from Event where eventId in(select distinct eventId from (select t.teamId,s.sportId from Team as t join Sport as s on t.sportId = s.sportId) ts join (select * from EventMatch) m on ts.teamId = m.teamId where sportId = ?)

-- all events by team
 select * from Event where eventId in(select eventId from EventMatch where teamId = ?)
```
## single event page
```mysql
--show teams playing
select name,teamId from Team where teamId in(select teamId from EventMatch as m join Event as e on e.eventId = m.eventId where e.eventId = ?)

-- stadium info
select * from Stadium where stadiumId in (select stadiumId from event where eventId = ?)

-- prices
select price,seatingType from PriceList where eventId = ?

-- date time
select date,time from Event where eventId = ?

-- tickets sold
select count(eventId) from Ticket where eventId = ?

-- sport
select name,sportId from Sport where sportId in(select sportId from Team where teamId in(select teamId from EventMatch as m join Event as e on e.eventId = m.eventId where e.eventId = ?))
```

## Client info admin

### preferences
```mysql
-- change firstName
update Client set LastName = ? where clientId = clientId

-- change lastName
update Client set LastName = ? where clientId = clientId

-- change email
update Client set email = ? where clientId = clientId;

-- change password
update Client set email = ? where clientId = clientId;

-- add favTeam
insert into FavouriteTeam(clientId,teamId) values (?,?)

-- drop favTeam
delete from FavouriteTeam where clientId = ? and teamId = ?

-- add favSport
insert into FavouriteSport(clientId,teamId) values (?,?)

-- drop favSport
delete from FavouriteSport where clientId = ? and sportId = ?

-- show all tickets
select * from Ticket where clientId = ?

-- get all favourite sports
select * from Sport where sportId in( select sportId from FavouriteSport where clientId = ?

-- get all favourite teams
select * from Team where teamId in(select teamId from FavouriteTeam where clientId = ?

-- delete account
TODO 
 -- set old ticket null, delete new tickets
```
## Administration

### Event
**deletion**
//TODO
- check if tickets are deleted

**pre deletion/reschedule check**
- get all clients affected
- send e-mail

### Stadium
**deletion**
- deletes all relevant events and seatingzones

**pre deletion check**
- get all events affected etc...
```mysql
select eventId where stadiumId  = ?
```

**events without matches**
```mysql
  select * from (select eventId from Event) e left join (select distinct eventId as `match` from EventMatch) m on e.eventId = m.`match` where `match` is null;
```

**capacity change**
- get all events affected etc...
- re-calculate seatingzones

### Team
**deletion**
- favourite teams are deleted
- matches are deleted as well

### Sport
**deletion**
- teams are deleted
- relevant favourites are deleted
- relevant matches deleted as well

# Joins on subqueries
big brain shit

```mysql
-- teamId,sportId,eventId,teamId
select * from
(select t.teamId,s.sportId from Team as t join Sport as s on t.sportId = s.sportId) ts join
(select * from EventMatch) m on ts.teamId = m.teamId;
```mysql