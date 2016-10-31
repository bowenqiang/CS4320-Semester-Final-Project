/* When completed, this file can be read with mysql to initialize the database structure.
   Running this file will wipe the entire db and reinitialize it, 
   SO DON'T DO IT IF YOU DON'T WANT TO WHIPE THE DB!!!
*/

/* this file does not specify a DB to use. You must pipe it in with the mysql command like this
     mysql -u <username> -p <DBName> < dbinit.sql 
*/

/* drop tables for clean slate. Order is important because it will complain about 
   foreign key constraints if you try to drop them in the wrong order
*/
DROP TABLE IF EXISTS m_x_snc;
DROP TABLE IF EXISTS user_info;
DROP TABLE IF EXISTS manifest;
DROP TABLE IF EXISTS snc;
DROP TABLE IF EXISTS person;

CREATE TABLE person (
    PID int NOT NULL AUTO_INCREMENT,
    LastName varchar(255) NOT NULL,
    FirstName varchar(255),
    MiddleName varchar(255),
    Email varchar(255),
    Phone varchar(255),
    PRIMARY KEY (PID)
);

CREATE TABLE user_info (
    UserName varchar(255) NOT NULL,
    PID int,
    AccountEmail varchar(255),
    Hashword varchar(255),
    PRIMARY KEY (UserName),
    FOREIGN KEY (PID) REFERENCES person(PID)
);

CREATE TABLE manifest (
    StandardVersions varchar(255),
    MID int NOT NULL AUTO_INCREMENT,
    Creator int, 
    UploadDate datetime NOT NULL,
    UploadComment varchar(1000),
    UploadTitle varchar(1000),
    DsTitle varchar(1000),
    DsTimeInterval varchar(255),
    RetrievedTimeInterval varchar(255),
    DsDateCreated datetime,
    JsonFile varchar(255) NOT NULL,
    DataSet varchar(255) NOT NULL,
    PRIMARY KEY (MID),
    FOREIGN KEY (Creator) REFERENCES person(PID)
);

CREATE TABLE snc (
    FID int NOT NULL AUTO_INCREMENT,
    Creator int,
    DateCreated datetime NOT NULL,
    FileName varchar(255),
    PRIMARY KEY (FID),
    FOREIGN KEY (Creator) REFERENCES person(PID)
);

CREATE TABLE m_x_snc (
    Creator int NOT NULL,
    MID int NOT NULL,
    FID int NOT NULL,
    DateCreated datetime,
    FOREIGN KEY (Creator) REFERENCES person(PID),
    FOREIGN KEY (MID) REFERENCES manifest(MID),
    FOREIGN KEY (FID) REFERENCES snc(FID)
);
