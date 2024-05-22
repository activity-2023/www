DROP TABLE IF EXISTS person, user_account, parent, staff, internal_staff,
    external_staff, staff_presence, building, room, activity, event,
    room_log, building_log, participate, subscribe, child, organize, propose CASCADE;

DROP TYPE IF EXISTS gender, contract_type, staff_function, room_type, school_level;

CREATE TYPE gender AS ENUM (
    'MALE', 'FEMALE'
    );

CREATE TYPE school_level AS ENUM (
    'YEAR1', 'YEAR2', 'YEAR3', 'YEAR4', 'YEAR5', 'YEAR6',
    'YEAR7', 'YEAR8', 'YEAR9', 'YEAR10', 'YEAR11', 'YEAR12'
    );

CREATE TYPE contract_type AS ENUM (
    'PERMANENT', 'TEMPORARY', 'INTERIM', 'SERVICE'
    );

CREATE TYPE staff_function AS ENUM (
    'EXECUTIVE', 'SECRETARY', 'EMPLOYEE'
    );

CREATE TYPE room_type AS ENUM (
    'AMPHITHEATER', 'ROOM', 'WORKSHOP'
    );

CREATE TABLE IF NOT EXISTS person(
                                     person_id SERIAL,
                                     person_fname VARCHAR(50) NOT NULL CHECK ( person_fname ~ '^[[:upper:]][[:lower:]]+([[:space:]][[:upper:]])?([[:space:]]?[[:upper:]][[:lower:]]+)*$' ),
                                     person_lname VARCHAR(50) NOT NULL CHECK ( person_lname ~ '^([[:upper:]]+[[:space:]]?)+$' ),
                                     person_gender VARCHAR(6) NOT NULL CHECK ( person_gender IN ( 'MALE', 'FEMALE' ) ),
                                     person_birth_date DATE NOT NULL CHECK (person_birth_date < CURRENT_DATE AND person_birth_date > CURRENT_DATE - INTERVAL '150 years'),
                                     person_access_pin_hash CHAR(64) NOT NULL CHECK ( person_access_pin_hash ~ '^[a-f0-9]{64}$|^[A-F0-9]{64}$' ),
                                     PRIMARY KEY (person_id)
);

CREATE TABLE IF NOT EXISTS user_account(
                                           user_id INTEGER,
                                           user_login VARCHAR(20) NOT NULL UNIQUE CHECK ( user_login ~ '^[[:lower:]][a-z0-9]+$' ),
                                           user_password_hash CHAR(128) NOT NULL CHECK ( user_password_hash ~ '^[a-f0-9]{128}$|^[A-F0-9]{128}$' ),
                                           user_password_salt CHAR(10) NOT NULL CHECK ( user_password_salt ~ '^[[:alnum:]]{10}$' ),
                                           PRIMARY KEY (user_id),
                                           FOREIGN KEY (user_id) REFERENCES person(person_id)
);

CREATE TABLE IF NOT EXISTS parent(
                                     parent_id INTEGER,
                                     parent_email VARCHAR(320) NOT NULL CHECK ( parent_email ~ '^[\w!#$%&''/*+=?`{|}~^-]+(?:\.[\w!#$%&''/*+=?`{|}~^-]+)*@(?:[a-z0-9-]+\.)+[a-z]{2,6}$' ),
                                     parent_phone CHAR(10) NOT NULL CHECK ( parent_phone ~ '^0[1-9][[:digit:]]{8}$' ),
                                     parent_job VARCHAR(50) NULL CHECK ( parent_job ~ '^[-'' a-zA-Z]+$' ),
                                     address_street_number INTEGER NOT NULL CHECK ( address_street_number > 0 AND address_street_number < 10000 ),
                                     address_street_name VARCHAR(50) NOT NULL,
                                     address_zip_code CHAR(5) NOT NULL CHECK ( address_zip_code ~ '^[0-9]{5}$' ),
                                     address_city VARCHAR(50) NOT NULL CHECK ( address_city ~ '^[-'' A-Z]+$' ),
                                     PRIMARY KEY (parent_id),
                                     FOREIGN KEY (parent_id) REFERENCES user_account(user_id)
);

CREATE TABLE IF NOT EXISTS child(
                                    child_id INTEGER,
                                    child_school_level VARCHAR(6) NULL CHECK ( child_school_level IN ( 'YEAR1', 'YEAR2', 'YEAR3', 'YEAR4', 'YEAR5', 'YEAR6', 'YEAR7', 'YEAR8', 'YEAR9', 'YEAR10', 'YEAR11', 'YEAR12' ) ),
                                    parent_id INTEGER NOT NULL,
                                    PRIMARY KEY (child_id),
                                    FOREIGN KEY (child_id) REFERENCES person(person_id),
                                    FOREIGN KEY (parent_id) REFERENCES parent(parent_id)
);

CREATE TABLE IF NOT EXISTS staff(
                                    staff_id INTEGER,
                                    staff_email VARCHAR(320) NOT NULL UNIQUE CHECK ( staff_email ~ '^[\w!#$%&''/*+=?`{|}~^-]+(?:\.[\w!#$%&''/*+=?`{|}~^-]+)*@(?:[a-z0-9-]+\.)+[a-z]{2,6}$' ),
                                    staff_phone CHAR(10) NOT NULL UNIQUE CHECK ( staff_phone ~ '^0[1-9][[:digit:]]{8}$' ),
                                    staff_contract_type VARCHAR(9) NOT NULL CHECK ( staff_contract_type IN ( 'PERMANENT', 'TEMPORARY', 'INTERIM', 'SERVICE' ) ),
                                    PRIMARY KEY (staff_id),
                                    FOREIGN KEY (staff_id) REFERENCES user_account(user_id)
);

CREATE TABLE IF NOT EXISTS external_staff(
                                             ex_staff_id INTEGER,
                                             ex_staff_origin VARCHAR(50) NOT NULL CHECK ( ex_staff_origin ~ '^[-'' a-zA-Z]+$' ),
                                             ex_staff_job VARCHAR(50) NULL CHECK ( ex_staff_job ~ '^[-'' a-zA-Z]+$' ),
                                             PRIMARY KEY (ex_staff_id),
                                             FOREIGN KEY (ex_staff_id) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS internal_staff(
                                             int_staff_id INTEGER,
                                             int_staff_hr_number INTEGER NOT NULL UNIQUE CHECK ( int_staff_hr_number > 0 ),
                                             int_staff_function VARCHAR(9) NOT NULL CHECK ( int_staff_function IN ( 'EXECUTIVE', 'SECRETARY', 'EMPLOYEE' ) ),
                                             address_street_number INTEGER NOT NULL CHECK ( address_street_number > 0 AND address_street_number < 10000 ),
                                             address_street_name VARCHAR(50) NOT NULL,
                                             address_zip_code CHAR(5) NOT NULL CHECK ( address_zip_code ~ '^[0-9]{5}$'),
                                             address_city VARCHAR(50) NOT NULL CHECK ( address_city ~ '^[-'' A-Z]+$' ),
                                             PRIMARY KEY (int_staff_id),
                                             FOREIGN KEY (int_staff_id) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS activity(
                                       activity_id SERIAL,
                                       activity_name VARCHAR(50) NOT NULL,
                                       activity_description TEXT NOT NULL,
                                       activity_min_age INTEGER NOT NULL CHECK (activity_min_age > 1),
                                       activity_price FLOAT NOT NULL CHECK (activity_price >= 0),
                                       PRIMARY KEY (activity_id)
);

CREATE TABLE IF NOT EXISTS building(
                                       building_id SERIAL,
                                       building_name VARCHAR(20) NOT NULL CHECK ( building_name ~ '^[-'' a-zA-Z]+$' ),
                                       address_street_number INTEGER NOT NULL CHECK ( address_street_number > 0 AND address_street_number < 10000 ),
                                       address_street_name VARCHAR(50) NOT NULL,
                                       address_zip_code CHAR(5) NOT NULL CHECK ( address_zip_code ~ '^[[:digit:]]{5}$' ),
                                       address_city VARCHAR(50) NOT NULL CHECK ( address_city ~ '^[-'' A-Z]+$' ),
                                       building_nb_floors INTEGER NOT NULL CHECK (building_nb_floors >= 0),
                                       building_has_elevator BOOLEAN NOT NULL,
                                       PRIMARY KEY (building_id)
);

CREATE TABLE IF NOT EXISTS room(
                                   room_id SERIAL,
                                   room_name VARCHAR(20) NOT NULL,
                                   room_floor INTEGER NOT NULL CHECK (room_floor >= 0 AND room_floor < 500),
                                   room_number INTEGER NOT NULL CHECK (room_number >= 0),
                                   room_type VARCHAR(12) NOT NULL CHECK ( room_type IN ( 'AMPHITHEATER', 'ROOM', 'WORKSHOP' ) ),
                                   room_capacity INTEGER NOT NULL CHECK (room_capacity >= 1 AND room_capacity < 50000),
                                   building_id INTEGER NOT NULL,
                                   PRIMARY KEY (room_id),
                                   FOREIGN KEY (building_id) REFERENCES building(building_id)
);

CREATE TABLE IF NOT EXISTS event(
                                    event_id SERIAL,
                                    event_date DATE NOT NULL CHECK (event_date >= CURRENT_DATE),
                                    event_start_time TIME NOT NULL,
                                    event_duration TIME NOT NULL,
                                    event_max_participants INT NOT NULL,
                                    room_id INTEGER NOT NULL,
                                    activity_id INTEGER NOT NULL,
                                    PRIMARY KEY (event_id),
                                    FOREIGN KEY (room_id) REFERENCES room(room_id),
                                    FOREIGN KEY (activity_id) REFERENCES activity(activity_id)
);

CREATE TABLE IF NOT EXISTS staff_presence(
                                             staff_pres_id SERIAL,
                                             staff_pres_date DATE NOT NULL,
                                             staff_pres_start_time TIME NOT NULL,
                                             staff_pres_duration TIME NOT NULL,
                                             staff_id INTEGER NOT NULL,
                                             PRIMARY KEY (staff_pres_id),
                                             FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS building_log(
                                           bl_id SERIAL,
                                           person_id INTEGER NOT NULL,
                                           building_id INTEGER NOT NULL,
                                           bl_timestamp TIMESTAMP NOT NULL,
                                           bl_status BOOL NOT NULL,
                                           PRIMARY KEY (bl_id),
                                           FOREIGN KEY (person_id) REFERENCES person(person_id),
                                           FOREIGN KEY (building_id) REFERENCES building(building_id)
);

CREATE TABLE IF NOT EXISTS room_log(
                                       rl_id SERIAL,
                                       room_id INTEGER NOT NULL,
                                       person_id INTEGER NOT NULL,
                                       rl_timestamp TIMESTAMP NOT NULL,
                                       rl_status BOOL NOT NULL,
                                       PRIMARY KEY (rl_id),
                                       FOREIGN KEY (room_id) REFERENCES room(room_id),
                                       FOREIGN KEY (person_id) REFERENCES person(person_id)
);

CREATE TABLE IF NOT EXISTS participate(
                                          person_id INTEGER,
                                          event_id INTEGER,
                                          PRIMARY KEY (person_id, event_id),
                                          FOREIGN KEY (person_id) REFERENCES person(person_id),
                                          FOREIGN KEY (event_id) REFERENCES  event(event_id)
);

CREATE TABLE IF NOT EXISTS subscribe(
                                        person_id INTEGER,
                                        activity_id INTEGER,
                                        PRIMARY KEY (person_id, activity_id),
                                        FOREIGN KEY (person_id) REFERENCES person(person_id),
                                        FOREIGN KEY (activity_id) REFERENCES  activity(activity_id)
);

CREATE TABLE IF NOT EXISTS organize(
                                       staff_id INTEGER,
                                       event_id INTEGER,
                                       PRIMARY KEY (staff_id, event_id),
                                       FOREIGN KEY (staff_id) REFERENCES staff(staff_id),
                                       FOREIGN KEY (event_id) REFERENCES event(event_id)
);

CREATE TABLE IF NOT EXISTS propose(
                                      staff_id INTEGER,
                                      activity_id INTEGER,
                                      PRIMARY KEY (staff_id, activity_id),
                                      FOREIGN KEY (staff_id) REFERENCES staff(staff_id),
                                      FOREIGN KEY (activity_id) REFERENCES activity(activity_id)
);

INSERT INTO person VALUES (1, 'Dania', 'OULKADI', 'FEMALE', '2002-07-16', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (2, 'Thomas', 'REMY', 'MALE', '1998-10-17', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (3, 'Amayas', 'TAHAR', 'MALE', '2010-06-30', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (4, 'Jana', 'SABI', 'FEMALE', '2012-03-07', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (5, 'Alicia', 'DJANI', 'FEMALE', '2015-06-30', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (6, 'Pierre', 'RABHI', 'MALE', '1989-12-12', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (7, 'Fati', 'HACHEMI', 'FEMALE', '1985-5-28', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb'),
                          (8, 'Mohammed', 'DUMAS', 'MALE', '1968-8-12', 'cad6ddf10c7f185baa569652306063313da25e747d9c7c2ce29f5b1d3bd216cb');

INSERT INTO user_account VALUES (1, 'doulkadi', 'd1516002982f64fafc28209615d23c2e617499dc942c61a41c1e7e32e80444c4439f9b546e4eda052aad10dd37a4f4cc956ccf62c712a181cde902706366a0e4', 'gcszduouws'),
                                (2, 'tremy', 'd1516002982f64fafc28209615d23c2e617499dc942c61a41c1e7e32e80444c4439f9b546e4eda052aad10dd37a4f4cc956ccf62c712a181cde902706366a0e4', 'gcszduouws'),
                                (6, 'prabhi', 'd1516002982f64fafc28209615d23c2e617499dc942c61a41c1e7e32e80444c4439f9b546e4eda052aad10dd37a4f4cc956ccf62c712a181cde902706366a0e4', 'gcszduouws'),
                                (7, 'fhachemi', 'd1516002982f64fafc28209615d23c2e617499dc942c61a41c1e7e32e80444c4439f9b546e4eda052aad10dd37a4f4cc956ccf62c712a181cde902706366a0e4', 'gcszduouws'),
                                (8, 'mdumas', 'd1516002982f64fafc28209615d23c2e617499dc942c61a41c1e7e32e80444c4439f9b546e4eda052aad10dd37a4f4cc956ccf62c712a181cde902706366a0e4', 'gcszduouws');


INSERT INTO parent VALUES (1, 'daniaoulkadi@gmail.com', '0856894523', NULL, 6,'Rue de la République', 95000 ,'CERGY'),
                          (2, 'thomasremy@gmail.com', '0523568910', NULL, 6, 'Rue Saint Sébastien', 75011, 'PARIS'),
                          (8, 'mohamdedumas@gmail.com', '0892562565', NULL, 6, 'Boulvard de la République', 95000,'SAINT DENIS');

INSERT INTO child VALUES (3, 'YEAR2', 1),(4, NULL, 2), (5, 'YEAR4',1);

INSERT INTO staff VALUES (6,'prahbi@activity.com', '0156859586', 'PERMANENT'), (7, 'fhachemi@activity.com', '0156857586', 'INTERIM');

INSERT INTO external_staff VALUES (6, 'Entreprise externe', NULL );

INSERT INTO internal_staff VALUES (7, 12, 'EXECUTIVE',  6, 'Boulevard de la République', 95600,'EAUBONNE');

INSERT INTO activity VALUES (1, 'ATELIER COUTURE', 'Ceci est la description de couture avec une professionnelle', 10, 6),
                            (2, 'CONFERENCE DE PRESSE', 'Ceci est la description de la conférence', 16, 10),
                            (3, 'REUNION ADMINISTRATION', 'Ceci est la description de la réunion administrative', 18, 0);

INSERT INTO building VALUES (1, 'A', 26,'Rue de la République',75011,'PARIS', 4, TRUE),
                            (2, 'B', 24, 'Rue de la République', 75011, 'PARIS', 2, FALSE);


INSERT INTO room VALUES (1, 'a', 1, 25, 'WORKSHOP', 12, 1), (2,'a', 0, 10, 'AMPHITHEATER', 300, 1 ),
                        (3, 'b', 1, 56, 'ROOM', 45, 2), (4, 'a', 2, 20, 'WORKSHOP', 13, 2);

INSERT INTO event VALUES (1, '2025-12-15', '12:45:00', '02:00:00', 10, 1, 1),
                         (2, '2025-12-15', '10:00:00', '03:00:00', 250, 2, 2),
                         (3, '2025-02-02', '14:00:00', '03:00:00', 250, 2, 3),
                         (4, '2025-11-28', '10:00:00', '03:00:00', 30, 3, 3),
                         (5, '2025-12-10', '10:00:00', '03:00:00', 200, 2, 2);


INSERT INTO participate VALUES (2,2),(8,2),(8,4),(3,4);

INSERT INTO subscribe VALUES (1,1),(3,2),(2,2),(1,2);

INSERT INTO organize VALUES (6,1),(6,2),(7,2),(7,5);

INSERT INTO propose VALUES (6,2),(6,3),(7,2);