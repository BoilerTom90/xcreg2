DROP DATABASE IF EXISTS XCREG3;
CREATE DATABASE XCREG3; 
USE XCREG3;


CREATE TABLE events (
  id int(11) AUTO_INCREMENT,
  ev_name varchar(25) DEFAULT NULL,
  ev_date date DEFAULT NULL,
  ev_reg_status varchar(25) DEFAULT "Open", 
  ev_contact_email varchar(255) DEFAULT NULL,
  ev_contact_phone varchar(20) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (ev_name),
  UNIQUE KEY (ev_date)
);

CREATE TABLE races (
  id int(11) NOT NULL,
  event_id int(11) NOT NULL,
  distance float(4,2) NOT NULL,
  description varchar(25) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (event_id, description)
);


CREATE TABLE users (
   id int(11) NOT NULL,
   school_id int(11),
   role varchar(10) NOT NULL,
   status varchar(10) NOT NULL,
   email varchar(255) NOT NULL,
   reset_code bigint,
   password varchar(100),
   num_logins int(11) DEFAULT 0,
   login_date datetime DEFAULT 0 on update CURRENT_TIMESTAMP,
   PRIMARY KEY (id),
   UNIQUE KEY (email)
);

-- alter table users add column num_logins int(11) default 0 after password;
-- alter table users add column login_date datetime default 0 on update current_timestamp after num_logins

CREATE TABLE pending_users (
   id int(11) NOT NULL,
   email varchar(255) NOT NULL,
   school_name varchar(50) NOT NULL,
   req_date datetime DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (id),
   UNIQUE KEY (email)
);

CREATE TABLE schools (
   id int(11) NOT NULL,
   name varchar(50) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE KEY (name)
);

CREATE TABLE runners (
   id int(11) NOT NULL AUTO_INCREMENT,
   school_id int(11) NOT NULL,
   event_id int(11) NOT NULL,
   race_id int(11) NOT NULL,
   sex varchar(1) NOT NULL,
   grade tinyint(4) NOT NULL,
   first_name varchar(25) NOT NULL,
   last_name varchar(25) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE KEY (school_id, event_id, first_name, last_name)
);

